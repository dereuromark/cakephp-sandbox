<?php

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class ExampleRecordsTable extends Table {

	/**
	 * @var array
	 */
	public $records = [];

	/**
	 * @param array<string, mixed> $config
	 */
	public function __construct(array $config = []) {
		parent::__construct($config);

		//ConnectionManager::create('array', ['datasource' => 'Datasources.ArraySource']);

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
