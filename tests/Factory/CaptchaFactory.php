<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * CaptchaFactory
 *
 * @method \Cake\Datasource\EntityInterface getEntity()
 * @method array<\Cake\Datasource\EntityInterface> getEntities()
 * @method \Cake\Datasource\EntityInterface|array<\Cake\Datasource\EntityInterface> persist()
 */
class CaptchaFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Captcha.Captchas';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'session_id' => $generator->uuid(),
				'ip' => $generator->ipv4(),
				'result' => $generator->word(),
			];
		});
	}

}
