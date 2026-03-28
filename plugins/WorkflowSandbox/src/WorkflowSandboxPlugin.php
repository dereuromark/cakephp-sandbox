<?php
declare(strict_types=1);

namespace WorkflowSandbox;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventManager;
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

	/**
	 * @param \Cake\Core\PluginApplicationInterface $app Application instance
	 * @return void
	 */
	public function bootstrap(PluginApplicationInterface $app): void {
		parent::bootstrap($app);

		$this->registerWorkflows();
	}

	/**
	 * Register workflow definitions from this plugin.
	 *
	 * @return void
	 */
	private function registerWorkflows(): void {
		$workflowsPath = Plugin::path('WorkflowSandbox') . 'config' . DS . 'workflows' . DS;

		// Create a NeonLoader for our plugin's workflows
		$loader = new NeonLoader($workflowsPath);
		$chainLoader = new ChainLoader([$loader]);
		$registry = new WorkflowRegistry($chainLoader, EventManager::instance());

		// Store in Configure for access by controllers and behaviors
		Configure::write('WorkflowSandbox.registry', $registry);
		// Also set for Workflow admin panel
		Configure::write('Workflow.registry', $registry);
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
