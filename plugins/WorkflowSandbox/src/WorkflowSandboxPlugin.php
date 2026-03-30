<?php
declare(strict_types=1);

namespace WorkflowSandbox;

use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\Plugin;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventManager;
use Cake\I18n\DateTime;
use Cake\Routing\RouteBuilder;
use Workflow\Loader\ChainLoader;
use Workflow\Loader\NeonLoader;
use Workflow\Service\WorkflowRegistry;

/**
 * WorkflowSandbox Plugin
 *
 * Demonstrates the cakephp-workflow plugin with multiple workflow examples.
 */
class WorkflowSandboxPlugin extends BasePlugin {

	/**
	 * @var bool
	 */
	protected bool $middlewareEnabled = false;

	/**
	 * @var bool
	 */
	protected bool $consoleEnabled = false;

	public function services(ContainerInterface $container): void {
		$container->addShared(WorkflowRegistry::class, function () {
			return $this->buildRegistry();
		});
	}

	private function buildRegistry(): WorkflowRegistry {
		$workflowsPath = Plugin::path('WorkflowSandbox') . 'config' . DS . 'workflows' . DS;

		$loader = new NeonLoader($workflowsPath);
		$chainLoader = new ChainLoader([$loader]);
		$registry = new WorkflowRegistry($chainLoader, EventManager::instance());

		// Register commands for each workflow
		$this->registerPaymentCommands($registry);
		$this->registerOrderCommands($registry);
		$this->registerTicketCommands($registry);
		$this->registerContentCommands($registry);
		$this->registerDocumentCommands($registry);
		$this->registerRegistrationCommands($registry);

		return $registry;
	}

	/**
	 * Register payment workflow commands.
	 *
	 * @param \Workflow\Service\WorkflowRegistry $registry
	 * @return void
	 */
	private function registerPaymentCommands(WorkflowRegistry $registry): void {
		$engine = $registry->getEngine('payment');

		// Set verified timestamp on confirmation
		$engine->addCommand('recordConfirmation', function (EntityInterface $entity): void {
			$entity->set('verified_at', new DateTime());
		});

		// Same for manual confirmation
		$engine->addCommand('manualConfirmation', function (EntityInterface $entity): void {
			$entity->set('verified_at', new DateTime());
		});

		// Increment retry count on timeout checks
		$engine->addCommand('checkPaymentStatus', function (EntityInterface $entity): void {
			$entity->set('retry_count', ($entity->get('retry_count') ?? 0) + 1);
		});

		// Mark as failed with reason
		$engine->addCommand('markAsFailed', function (EntityInterface $entity): void {
			$entity->set('failure_reason', 'Maximum verification attempts exceeded');
		});

		// Placeholder commands (no-op for demo)
		$engine->addCommand('initiatePaymentCheck', function (EntityInterface $entity): void {
			// In production: trigger external payment verification
		});

		$engine->addCommand('initiateRefund', function (EntityInterface $entity): void {
			// In production: trigger refund process
		});

		$engine->addCommand('recordRefund', function (EntityInterface $entity): void {
			// In production: record refund completion
		});
	}

	/**
	 * Register order workflow commands.
	 *
	 * @param \Workflow\Service\WorkflowRegistry $registry
	 * @return void
	 */
	private function registerOrderCommands(WorkflowRegistry $registry): void {
		$engine = $registry->getEngine('order');

		$engine->addCommand('recordPayment', function (EntityInterface $entity): void {
			$entity->set('paid_at', new DateTime());
		});

		$engine->addCommand('recordShipment', function (EntityInterface $entity): void {
			$entity->set('shipped_at', new DateTime());
		});

		$engine->addCommand('recordDelivery', function (EntityInterface $entity): void {
			$entity->set('delivered_at', new DateTime());
		});

		$engine->addCommand('recordCancellation', function (EntityInterface $entity): void {
			$entity->set('cancelled_at', new DateTime());
		});

		$engine->addCommand('processRefund', function (EntityInterface $entity): void {
			$entity->set('refunded_at', new DateTime());
		});
	}

	/**
	 * Register ticket workflow commands.
	 *
	 * @param \Workflow\Service\WorkflowRegistry $registry
	 * @return void
	 */
	private function registerTicketCommands(WorkflowRegistry $registry): void {
		$engine = $registry->getEngine('ticket');

		$engine->addCommand('recordEscalation', function (EntityInterface $entity): void {
			$entity->set('escalated_at', new DateTime());
		});

		$engine->addCommand('recordResolution', function (EntityInterface $entity): void {
			$entity->set('resolved_at', new DateTime());
		});

		$engine->addCommand('clearResolution', function (EntityInterface $entity): void {
			$entity->set('resolved_at', null);
		});
	}

	/**
	 * Register content workflow commands.
	 *
	 * @param \Workflow\Service\WorkflowRegistry $registry
	 * @return void
	 */
	private function registerContentCommands(WorkflowRegistry $registry): void {
		$engine = $registry->getEngine('content');

		$engine->addCommand('recordPublication', function (EntityInterface $entity): void {
			$entity->set('published_at', new DateTime());
		});

		$engine->addCommand('clearRejection', function (EntityInterface $entity): void {
			$entity->set('rejection_reason', null);
		});
	}

	/**
	 * Register document workflow commands.
	 *
	 * Note: recordApproval and recordRejection are no-ops because the user_id
	 * and rejection_reason come from form data and are set by the controller
	 * before the transition. Commands can only handle computed/derived values.
	 *
	 * @param \Workflow\Service\WorkflowRegistry $registry
	 * @return void
	 */
	private function registerDocumentCommands(WorkflowRegistry $registry): void {
		$engine = $registry->getEngine('document');

		// Approval tracking is handled by controller (needs form input for user_id)
		$engine->addCommand('recordApproval', function (EntityInterface $entity): void {
			// User tracking is done by controller before transition
		});

		// Rejection tracking is handled by controller (needs form input)
		$engine->addCommand('recordRejection', function (EntityInterface $entity): void {
			// User/reason tracking is done by controller before transition
		});

		$engine->addCommand('clearApprovalState', function (EntityInterface $entity): void {
			$entity->set('rejected_by', null);
			$entity->set('rejection_reason', null);
			$entity->set('approved_by', null);
			$entity->set('current_approver_level', 0);
		});
	}

	/**
	 * Register registration workflow commands.
	 *
	 * @param \Workflow\Service\WorkflowRegistry $registry
	 * @return void
	 */
	private function registerRegistrationCommands(WorkflowRegistry $registry): void {
		$engine = $registry->getEngine('registration');

		$engine->addCommand('createPaymentJob', function (EntityInterface $entity): void {
			// In production: create a payment job/invoice
			$entity->set('payment_requested_at', new DateTime());
		});

		$engine->addCommand('sendConfirmationEmail', function (EntityInterface $entity): void {
			// In production: send confirmation email
			$entity->set('confirmation_sent_at', new DateTime());
		});
	}

	/**
	 * @param \Cake\Routing\RouteBuilder $routes Routes
	 * @return void
	 */
	public function routes(RouteBuilder $routes): void {
		$routes->plugin(
			'WorkflowSandbox',
			['path' => '/workflow-sandbox'],
			function (RouteBuilder $builder): void {
				$builder->connect('/', ['controller' => 'WorkflowSandbox', 'action' => 'index']);
				$builder->fallbacks();
			},
		);
		parent::routes($routes);
	}

}
