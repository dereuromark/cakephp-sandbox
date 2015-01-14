<?php
namespace Sandbox\Model;

use Cake\Database\ConnectionManager;
use Tools\Model\Table\Table;

class ExampleRecordsTable extends Table {

	public $records = array();

	public function __construct($id = false, $table = false, $ds = null) {
		parent::__construct($id, $table, $ds);

		ConnectionManager::create('array', array('datasource' => 'Datasources.ArraySource'));

		$this->records = array(
			array(
				'id' => 1,
				'name' => 'Foo',
				'flag' => 3,
			),
			array(
				'id' => 2,
				'name' => 'Bar',
				'flag' => 7,
			),
		);
	}

}
