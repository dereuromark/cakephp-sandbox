<?php

declare(strict_types=1);

namespace App\Plugin;

use Cake\Core\ContainerInterface;
use Mercure\Authorization;
use Mercure\MercurePlugin as BaseMercurePlugin;
use Mercure\Publisher;
use Mercure\Service\AuthorizationInterface;
use Mercure\Service\PublisherInterface;
use ReflectionClass;

/**
 * Mercure, registered without a League service provider.
 *
 * `App.container` selects the container: the default builds a League container,
 * `'cake'` builds CakePHP's own via `CakeContainerBridge`. The bridge accepts
 * only `Cake\Container\ServiceProvider\ServiceProviderInterface`, and the
 * plugin's `MercureServiceProvider` extends `Cake\Core\ServiceProvider`, which
 * is a League `AbstractServiceProvider` - an unrelated hierarchy. So the stock
 * plugin throws on boot under the CakePHP container:
 *
 * > Service provider must implement
 * > `Cake\Container\ServiceProvider\ServiceProviderInterface` when using the
 * > CakePHP container
 *
 * The provider wrapped two `add()` calls, and `add()` exists on both
 * containers, so registering the two services directly needs no provider and no
 * version gate. Deferred registration buys nothing for two closures.
 *
 * Drop this class and restore `'Mercure' => []` in `config/plugins.php` once
 * the plugin registers its services container-agnostically upstream.
 *
 * @see \Mercure\MercurePlugin::services()
 */
class MercurePlugin extends BaseMercurePlugin {

	/**
	 * Keeps the plugin's identity, which subclassing would otherwise take away.
	 *
	 * `BasePlugin` derives all of these from the class it is instantiated as, so
	 * this subclass would be `App/Plugin` living in `src/Plugin/` - and then
	 * `Configure::load('Mercure.mercure')` in the inherited bootstrap resolves a
	 * DIFFERENT, unloaded plugin named `Mercure` and adds the stock class behind
	 * this one, whose `services()` throws exactly what this class exists to
	 * avoid. Pinning name and paths to the vendor plugin keeps one Mercure.
	 *
	 * @param array<string, mixed> $options Plugin options.
	 */
	public function __construct(array $options = []) {
		$vendorPath = dirname((string)(new ReflectionClass(BaseMercurePlugin::class))->getFileName(), 2) . DS;

		parent::__construct($options + [
			'name' => 'Mercure',
			'path' => $vendorPath,
			'classPath' => $vendorPath . 'src' . DS,
			'configPath' => $vendorPath . 'config' . DS,
			'templatePath' => $vendorPath . 'templates' . DS,
		]);
	}

	/**
	 * @param \Cake\Core\ContainerInterface $container The Container to update.
	 * @return void
	 */
	public function services(ContainerInterface $container): void {
		$container->add(PublisherInterface::class, function (): PublisherInterface {
			return Publisher::create();
		});

		$container->add(AuthorizationInterface::class, function (): AuthorizationInterface {
			return Authorization::create();
		});
	}

}
