<?php
declare(strict_types=1);

namespace Sandbox\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SandboxArticlesFixture
 */
class SandboxArticlesFixture extends TestFixture {

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void {
		$this->records = [
			[
				'title' => 'Lorem ipsum dolor sit amet',
				'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
				'status' => 'Lorem ipsum dolor sit amet',
				'created' => '2015-05-20 20:50:45',
				'modified' => '2015-05-20 20:50:45',
			],
		];
		parent::init();
	}

}
