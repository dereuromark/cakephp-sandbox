<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * EventFactory
 *
 * @method \Sandbox\Model\Entity\Event getEntity()
 * @method array<\Sandbox\Model\Entity\Event> getEntities()
 * @method \Sandbox\Model\Entity\Event|array<\Sandbox\Model\Entity\Event> persist()
 */
class EventFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.Events';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'title' => $generator->sentence(3),
				'location' => $generator->city(),
				'lat' => $generator->randomFloat(6, -90, 90),
				'lng' => $generator->randomFloat(6, -180, 180),
				'description' => $generator->paragraph(2),
				'beginning' => $generator->dateTime(),
				'end' => $generator->dateTime(),
			];
		});
	}

}
