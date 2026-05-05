<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * CaptchaFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Captcha\Model\Entity\Captcha>
 */
class CaptchaFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Captcha.Captchas';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'session_id' => $generator->uuid(),
			'ip' => $generator->ipv4(),
			'result' => $generator->word(),
		];
	}

}
