<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\I18n\DateTime;
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

		// Get transition history
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

			// Generate a fake transaction ID if not provided
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

		$this->set(compact('payment', 'providers', 'currencies'));

		return null;
	}

	/**
	 * Execute a workflow transition
	 *
	 * @param int $id Payment ID
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function transition(int $id): ?Response {
		$this->request->allowMethod(['post']);

		$payment = $this->Payments->get($id);
		$transitionName = $this->request->getData('transition');

		// Simulate external payment check for demo purposes
		if (in_array($transitionName, ['payment_success', 'check_timeout_1', 'check_timeout_2', 'check_timeout_3'], true)) {
			// Randomly succeed or continue to next retry
			$shouldSucceed = random_int(1, 100) <= 40; // 40% success rate per check

			if ($shouldSucceed && $transitionName !== 'payment_success') {
				$transitionName = 'payment_success';
			}
		}

		$result = $this->Payments->applyTransition($payment, $transitionName, [
			'reason' => $this->request->getData('reason') ?? 'Manual transition',
		]);

		if ($result->isSuccess()) {
			// Update retry count for retry transitions
			if (str_starts_with($transitionName, 'check_timeout_')) {
				$payment->retry_count = ($payment->retry_count ?? 0) + 1;
			}

			// Set verified timestamp on success
			if ($transitionName === 'payment_success') {
				$payment->verified_at = new DateTime();
			}

			// Set failure reason
			if ($transitionName === 'max_retries_exceeded') {
				$payment->failure_reason = 'Maximum verification attempts exceeded';
			}

			$this->Payments->save($payment);
			$this->Flash->success("Transition '{$transitionName}' applied successfully.");
		} else {
			$this->Flash->error(__('Transition failed: {0}', $result->getError()?->getMessage() ?? 'Unknown error'));
		}

		return $this->redirect(['action' => 'view', $id]);
	}

	/**
	 * Simulate automated verification (for demo)
	 *
	 * @param int $id Payment ID
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function simulate(int $id): ?Response {
		$this->request->allowMethod(['post']);

		$payment = $this->Payments->get($id);

		$messages = [];
		$maxIterations = 10; // Safety limit
		$iteration = 0;

		// Run through the automated flow
		while ($iteration < $maxIterations) {
			$iteration++;
			$available = $this->Payments->getAvailableTransitions($payment);

			if (!$available) {
				$messages[] = "No more transitions available. Final state: {$payment->status}";

				break;
			}

			// Prioritize success check
			if (in_array('payment_success', $available, true)) {
				// 40% chance of success at each check
				if (random_int(1, 100) <= 40) {
					$result = $this->Payments->applyTransition($payment, 'payment_success', ['reason' => 'Automated: Payment confirmed']);
					if ($result->isSuccess()) {
						$payment->verified_at = new DateTime();
						$this->Payments->save($payment);
						$messages[] = '✓ Payment verified successfully!';
					}

					break;
				}
			}

			// Find timeout transition
			$timeoutTransition = null;
			foreach ($available as $t) {
				if (str_starts_with($t, 'check_timeout_') || $t === 'max_retries_exceeded') {
					$timeoutTransition = $t;

					break;
				}
			}

			if ($timeoutTransition) {
				$result = $this->Payments->applyTransition($payment, $timeoutTransition, ['reason' => 'Automated: Timeout check']);
				if ($result->isSuccess()) {
					$payment->retry_count = ($payment->retry_count ?? 0) + 1;

					if ($timeoutTransition === 'max_retries_exceeded') {
						$payment->failure_reason = 'Maximum verification attempts exceeded';
						$messages[] = '✗ Max retries exceeded. Payment failed.';
					} else {
						$messages[] = "→ Retry {$payment->retry_count}: Payment not yet confirmed, scheduling next check...";
					}

					$this->Payments->save($payment);
				}
			} else {
				break;
			}
		}

		$this->Flash->success(implode('<br>', $messages));

		return $this->redirect(['action' => 'view', $id]);
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
