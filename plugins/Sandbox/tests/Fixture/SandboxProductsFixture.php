<?php
declare(strict_types=1);

namespace Sandbox\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SandboxProductsFixture
 */
class SandboxProductsFixture extends TestFixture {

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void {
		$this->records = [
			[
				'title' => 'Lorem ipsum dolor sit amet',
				'price' => 1.5,
				'created' => '2025-04-17 12:57:27',
				'modified' => '2025-04-17 12:57:27',
			],
		];
		parent::init();
	}

}
