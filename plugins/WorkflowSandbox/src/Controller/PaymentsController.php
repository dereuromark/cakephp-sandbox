<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;

/**
 * Payments Controller
 *
 * Demonstrates automated payment verification with timeout-based retry logic.
 *
 * @property \WorkflowSandbox\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Payments = $this->fetchTable('WorkflowSandbox.Payments');
	}

	/**
	 * Get the workflow registry.
	 *
	 * @return \Workflow\Service\WorkflowRegistry
	 */
	protected function getRegistry(): WorkflowRegistry {
		return Configure::read('WorkflowSandbox.registry');
	}

	/**
	 * Index - list all payments
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$payments = $this->Payments->find()
			->contain(['Users'])
			->orderBy(['Payments.created' => 'DESC'])
			->toArray();

		$definition = $this->getRegistry()->getWorkflow('payment');

		$this->set(compact('payments', 'definition'));

		return null;
	}

	/**
	 * View a payment with workflow diagram
	 *
	 * @param int $id Payment ID
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function view(int $id): ?Response {
		$payment = $this->Payments->get($id, contain: ['Users']);

		$definition = $this->getRegistry()->getWorkflow('payment');
		$availableTransitions = $this->Payments->getAvailableTransitions($payment);

		$logger = new TransitionLogger();
		$transitionHistory = $logger->getHistory('payment', 'WorkflowSandbox.Payments', (string)$id);

		$this->set(compact('payment', 'definition', 'availableTransitions', 'transitionHistory'));

		return null;
	}

	/**
	 * Add a new payment for verification
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function add(): ?Response {
		$payment = $this->Payments->newEmptyEntity();

		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$data['status'] = 'pending';
			$data['retry_count'] = 0;

			if (empty($data['transaction_id'])) {
				$data['transaction_id'] = 'TXN-' . strtoupper(bin2hex(random_bytes(8)));
			}

			$payment = $this->Payments->patchEntity($payment, $data);

			if ($this->Payments->save($payment)) {
				$this->Flash->success('Payment created. Click "Start Verification" to begin automated processing.');

				return $this->redirect(['action' => 'view', $payment->id]);
			}

			$this->Flash->error('Could not create payment.');
		}

		$providers = [
			'stripe' => 'Stripe',
			'paypal' => 'PayPal',
			'braintree' => 'Braintree',
			'adyen' => 'Adyen',
		];
		$currencies = ['USD' => 'USD', 'EUR' => 'EUR', 'GBP' => 'GBP'];
		$users = $this->fetchTable('Users')->find('list')->toArray();

		$this->set(compact('payment', 'providers', 'currencies', 'users'));

		return null;
	}

	/**
	 * Execute a workflow transition.
	 *
	 * With autoSave and autoLog enabled on the behavior, this is all we need:
	 * - applyTransition() runs workflow commands (set timestamps, etc.)
	 * - autoSave saves the entity
	 * - autoLog logs the transition
	 *
	 * @param int $id Payment ID
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function transition(int $id): ?Response {
		$this->request->allowMethod(['post']);

		$payment = $this->Payments->get($id);
		$transitionName = $this->request->getData('transition');

		// Demo: simulate random success for payment checks
		if (in_array($transitionName, ['check_timeout_1', 'check_timeout_2', 'check_timeout_3'], true)) {
			if (random_int(1, 100) <= 40) {
				$transitionName = 'payment_success';
			}
		}

		$result = $this->Payments->applyTransition($payment, $transitionName, [
			'reason' => $this->request->getData('reason') ?: 'Manual transition',
		]);

		if ($result->isSuccess()) {
			$this->Flash->success("Transition '{$transitionName}' applied successfully.");
		} elseif ($result->isBlocked()) {
			$this->Flash->warning(__('Transition blocked: {0}', implode(', ', $result->getBlockedBy())));
		} else {
			$this->Flash->error(__('Transition failed: {0}', $result->getError()?->getMessage() ?? 'Unknown error'));
		}

		return $this->redirect(['action' => 'view', $id]);
	}

	/**
	 * Simulate automated verification (for demo).
	 *
	 * @param int $id Payment ID
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function simulate(int $id): ?Response {
		$this->request->allowMethod(['post']);

		$payment = $this->Payments->get($id);
		$messages = [];

		for ($i = 0; $i < 10; $i++) {
			$available = $this->Payments->getAvailableTransitions($payment);

			if (!$available) {
				$messages[] = "Final state: {$payment->status}";

				break;
			}

			// Try payment success (40% chance)
			if (in_array('payment_success', $available, true) && random_int(1, 100) <= 40) {
				$this->Payments->applyTransition($payment, 'payment_success', [
					'reason' => 'Simulated: Payment confirmed',
				]);
				$messages[] = '✓ Payment verified successfully!';

				break;
			}

			// Find and apply timeout transition
			$timeout = $this->findTimeoutTransition($available);
			if ($timeout) {
				$this->Payments->applyTransition($payment, $timeout, [
					'reason' => 'Automated: Timeout check',
				]);

				if ($timeout === 'max_retries_exceeded') {
					$messages[] = '✗ Max retries exceeded. Payment moved to verification failed for manual review.';
				} else {
					$messages[] = "→ Retry {$payment->retry_count}: Scheduling next check...";
				}
			} else {
				break;
			}
		}

		$this->Flash->success(implode('<br>', $messages));

		return $this->redirect(['action' => 'view', $id]);
	}

	/**
	 * Find timeout transition from available transitions.
	 *
	 * @param array<string> $available
	 * @return string|null
	 */
	private function findTimeoutTransition(array $available): ?string {
		foreach ($available as $t) {
			if (str_starts_with($t, 'check_timeout_') || $t === 'max_retries_exceeded') {
				return $t;
			}
		}

		return null;
	}

	/**
	 * Delete a payment
	 *
	 * @param int $id Payment ID
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function delete(int $id): ?Response {
		$this->request->allowMethod(['post', 'delete']);

		$payment = $this->Payments->get($id);

		if ($this->Payments->delete($payment)) {
			$this->Flash->success('Payment deleted.');
		} else {
			$this->Flash->error('Could not delete payment.');
		}

		return $this->redirect(['action' => 'index']);
	}

}
