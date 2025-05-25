<?php
declare(strict_types=1);

namespace Sandbox\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SandboxCitiesFixture
 */
class SandboxCitiesFixture extends TestFixture {

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void {
		$this->records = [
			[
				'name' => 'Lorem ipsum dolor sit amet',
				'alias' => 'Lorem ipsum dolor sit amet',
				'country_id' => 1,
				'lat' => 1,
				'lng' => 1,
				'coordinates' => '',
			],
		];
		parent::init();
	}

}
