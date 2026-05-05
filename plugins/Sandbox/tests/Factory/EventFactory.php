<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * EventFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\Event>
 */
class EventFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.Events';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'title' => $generator->sentence(3),
			'location' => $generator->city(),
			'lat' => $generator->randomFloat(6, -90, 90),
			'lng' => $generator->randomFloat(6, -180, 180),
			'description' => $generator->paragraph(2),
			'beginning' => $generator->dateTime(),
			'end' => $generator->dateTime(),
		];
	}

}
