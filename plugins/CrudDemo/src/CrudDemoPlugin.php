<?php
declare(strict_types=1);

namespace CrudDemo;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for CrudDemo
 */
class CrudDemoPlugin extends BasePlugin {

	/**
	 * Load all the plugin configuration and bootstrap logic.
	 *
	 * The host application is provided as an argument. This allows you to load
	 * additional plugin dependencies, or attach events.
	 *
	 * @param \Cake\Core\PluginApplicationInterface $app The host application
	 * @return void
	 */
	public function bootstrap(PluginApplicationInterface $app): void {
		// remove this method hook if you don't need it
	}

	/**
	 * Add routes for the plugin.
	 *
	 * If your plugin has many routes and you would like to isolate them into a separate file,
	 * you can create `$plugin/config/routes.php` and delete this method.
	 *
	 * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
	 * @return void
	 */
	public function routes(RouteBuilder $routes): void {
		$routes->plugin(
			'CrudDemo',
			['path' => '/crud-demo'],
			function (RouteBuilder $builder) {
				// Add custom routes here

				$builder->fallbacks();
			},
		);
		parent::routes($routes);
	}

	/**
	 * Add middleware for the plugin.
	 *
	 * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to update.
	 * @return \Cake\Http\MiddlewareQueue
	 */
	public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
		// Add your middlewares here
		// remove this method hook if you don't need it

		return $middlewareQueue;
	}

	/**
	 * Add commands for the plugin.
	 *
	 * @param \Cake\Console\CommandCollection $commands The command collection to update.
	 * @return \Cake\Console\CommandCollection
	 */
	public function console(CommandCollection $commands): CommandCollection {
		// Add your commands here
		// remove this method hook if you don't need it

		$commands = parent::console($commands);

		return $commands;
	}

	/**
	 * Register application container services.
	 *
	 * @link https://book.cakephp.org/5/en/development/dependency-injection.html#dependency-injection
	 * @param \Cake\Core\ContainerInterface $container The Container to update.
	 * @return void
	 */
	public function services(ContainerInterface $container): void {
		// Add your services here
		// remove this method hook if you don't need it
	}

}
