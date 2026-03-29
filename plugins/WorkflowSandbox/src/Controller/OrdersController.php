<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Http\Response;
use RuntimeException;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;
use Workflow\Service\WorkflowRegistryLocator;

/**
 * Orders Controller
 *
 * Demo for Order workflow.
 *
 * @property \WorkflowSandbox\Model\Table\OrdersTable $Orders
 * @property \Workflow\Controller\Component\WorkflowComponent $Workflow
 */
class OrdersController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Orders = $this->fetchTable('WorkflowSandbox.Orders');
		$this->loadComponent('Workflow.Workflow');
	}

	/**
	 * Get the workflow registry.
	 *
	 * @return \Workflow\Service\WorkflowRegistry
	 */
	protected function getRegistry(): WorkflowRegistry {
		return WorkflowRegistryLocator::get() ?? throw new RuntimeException('Workflow registry not configured');
	}

	/**
	 * Index - List orders and show workflow diagram.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$orders = $this->Orders->find()
			->contain(['Users'])
			->orderByDesc('Orders.created')
			->limit(20)
			->all()
			->toArray();

		$definition = $this->getRegistry()->getWorkflow('order');
		$users = $this->fetchTable('Users')->find('list')->toArray();

		$this->set(compact('orders', 'definition', 'users'));

		return null;
	}

	/**
	 * Create a new order.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function add(): ?Response {
		$order = $this->Orders->newEmptyEntity();

		if ($this->request->is('post')) {
			$order = $this->Orders->patchEntity($order, $this->request->getData());
			$order->order_number = $this->Orders->generateOrderNumber();
			$order->status = 'pending';

			if ($this->Orders->save($order)) {
				$this->Flash->success(__('Order {0} created.', $order->order_number));

				return $this->redirect(['action' => 'view', $order->id]);
			}
			$this->Flash->error(__('Could not create order.'));
		}

		$users = $this->fetchTable('Users')->find('list')->toArray();
		$paymentMethods = ['cash' => 'Cash', 'card' => 'Credit Card', 'paypal' => 'PayPal'];
		$this->set(compact('order', 'users', 'paymentMethods'));

		return null;
	}

	/**
	 * View an order.
	 *
	 * @param int|null $id Order ID
	 * @return \Cake\Http\Response|null
	 */
	public function view(?int $id = null): ?Response {
		$order = $this->Orders->get($id, contain: ['Users']);
		$definition = $this->getRegistry()->getWorkflow('order');
		$availableTransitions = $this->Orders->getAvailableTransitions($order);

		// Get transition history
		$logger = new TransitionLogger();
		$transitionHistory = $logger->getHistory('order', 'WorkflowSandbox.Orders', (string)$order->id);

		$this->set(compact('order', 'definition', 'availableTransitions', 'transitionHistory'));

		return null;
	}

	/**
	 * Apply a transition to an order.
	 *
	 * Uses the WorkflowComponent for standardized flash messages.
	 * With autoSave and autoLog enabled on the behavior:
	 * - applyTransition() runs workflow commands (set timestamps, etc.)
	 * - autoSave saves the entity
	 * - autoLog logs the transition
	 *
	 * @param int $id Order ID
	 * @return \Cake\Http\Response
	 */
	public function transition(int $id): Response {
		$this->request->allowMethod(['post']);

		$order = $this->Orders->get($id);

		return $this->Workflow->handleTransition(
			$this->Orders,
			$order,
			['action' => 'view', $id],
		);
	}

	/**
	 * Delete an order.
	 *
	 * @param int|null $id Order ID
	 * @return \Cake\Http\Response|null
	 */
	public function delete(?int $id = null): ?Response {
		$this->request->allowMethod(['post', 'delete']);

		$order = $this->Orders->get($id);

		if ($this->Orders->delete($order)) {
			$this->Flash->success(__('Order deleted.'));
		} else {
			$this->Flash->error(__('Could not delete order.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Reset all orders (for demo purposes).
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function reset(): ?Response {
		$this->request->allowMethod(['post']);

		$this->Orders->deleteAll([]);
		$this->Flash->success(__('All orders reset.'));

		return $this->redirect(['action' => 'index']);
	}

}
