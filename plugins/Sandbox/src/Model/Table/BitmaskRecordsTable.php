<?php

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class BitmaskRecordsTable extends Table {

	/**
	 * @var string
	 */
	public $useDbConfig = 'array';

	/**
	 * @var array
	 */
	public $records = [];

	/**
	 * @param array $config
	 */
	public function __construct(array $config = []) {
		parent::__construct($config);

		$this->records = [
			[
				'id' => 1,
				'name' => 'Foo',
				'flag' => 3,
			],
			[
				'id' => 2,
				'name' => 'Bar',
				'flag' => 7,
			],
		];
	}

}
