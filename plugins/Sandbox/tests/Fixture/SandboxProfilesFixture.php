<?php
declare(strict_types=1);

namespace Sandbox\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SandboxProfilesFixture
 */
class SandboxProfilesFixture extends TestFixture {

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void {
		$this->records = [
			[
				'id' => 1,
				'username' => 'Lorem ipsum dolor sit amet',
				'balance' => 1.5,
				'extra' => 1.5,
			],
		];
		parent::init();
	}

}
