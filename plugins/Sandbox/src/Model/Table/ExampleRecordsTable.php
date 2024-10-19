<?php

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class ExampleRecordsTable extends Table {

	/**
	 * @var array<mixed>
	 */
	public $records = [];

	/**
	 * @param array<string, mixed> $config
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
