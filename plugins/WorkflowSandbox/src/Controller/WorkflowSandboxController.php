<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Http\Response;
use RuntimeException;
use Workflow\Service\WorkflowRegistry;
use Workflow\Service\WorkflowRegistryLocator;

/**
 * WorkflowSandbox Controller
 *
 * Main entry point for workflow demos.
 */
class WorkflowSandboxController extends AppController {

	/**
	 * Get the workflow registry.
	 *
	 * @return \Workflow\Service\WorkflowRegistry
	 */
	protected function getRegistry(): WorkflowRegistry {
		return WorkflowRegistryLocator::get() ?? throw new RuntimeException('Workflow registry not configured');
	}

	/**
	 * Index - Overview of workflow demos
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$registry = $this->getRegistry();

		// Get all workflow definitions
		$workflows = [];
		foreach ($registry->getWorkflowNames() as $name) {
			$workflows[$name] = $registry->getWorkflow($name);
		}

		$this->set(compact('workflows'));

		return null;
	}

}
