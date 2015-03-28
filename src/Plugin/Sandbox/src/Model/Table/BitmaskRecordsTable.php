<?php
namespace Sandbox\Model;

use Cake\Database\ConnectionManager;

class BitmaskRecordsTable extends SandboxAppModel {

	public $useDbConfig = 'array';

	public $records = [];

	public function __construct($id = false, $table = false, $ds = null) {
		parent::__construct($id, $table, $ds);

		ConnectionManager::create('array', ['datasource' => 'Datasources.ArraySource']);

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
