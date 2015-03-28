<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class CountryRecordsTable extends Table {

	//public $alias = 'Country';

	public $order = ['sort' => 'DESC', 'name' => 'ASC'];

	public $filterArgs = [
		'search' => ['type' => 'like', 'field' => ['name', 'ori_name', 'iso2', 'iso3']],
	];

	public function initialize(array $config) {
		$this->table('countries');

		$this->addBehavior('Search.Searchable');
		parent::initialize($config);
	}

}
