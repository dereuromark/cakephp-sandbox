<?php
declare(strict_types=1);

namespace StateMachineSandbox;

use Cake\Core\BasePlugin;
use Cake\Routing\RouteBuilder;

/**
 * StateMachineSandbox Plugin
 *
 * DEPRECATED: This plugin only provides 301 redirects to WorkflowSandbox.
 * All functionality has been moved to WorkflowSandbox.
 */
class StateMachineSandboxPlugin extends BasePlugin {

	/**
	 * @var bool
	 */
	protected bool $bootstrapEnabled = false;

	/**
	 * @var bool
	 */
	protected bool $middlewareEnabled = false;

	/**
	 * @var bool
	 */
	protected bool $consoleEnabled = false;

	/**
	 * @param \Cake\Routing\RouteBuilder $routes Routes
	 * @return void
	 */
	public function routes(RouteBuilder $routes): void {
		$routes->plugin(
			'StateMachineSandbox',
			['path' => '/state-machine-sandbox'],
			function (RouteBuilder $builder): void {
				// Redirect all routes to WorkflowSandbox
				$builder->redirect('/', '/workflow-sandbox', ['status' => 301]);
				$builder->redirect('/registrations', '/workflow-sandbox/registrations', ['status' => 301]);
				$builder->redirect('/registrations/*', '/workflow-sandbox/registrations', ['status' => 301]);
				$builder->redirect('/*', '/workflow-sandbox', ['status' => 301]);
			},
		);
	}

}
