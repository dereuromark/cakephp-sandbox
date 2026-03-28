<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Workflow\Service\WorkflowRegistry;

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
		return Configure::read('WorkflowSandbox.registry');
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
