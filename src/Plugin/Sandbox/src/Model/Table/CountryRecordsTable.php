<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class CountryRecordsTable extends Table {

	//public $alias = 'Country';

	public $order = array('sort' => 'DESC', 'name' => 'ASC');

	public $filterArgs = array(
		'search' => array('type' => 'like', 'field' => array('name', 'ori_name', 'iso2', 'iso3')),
	);

	public function initialize(array $config) {
		$this->table('countries');

		$this->addBehavior('Search.Searchable');
		parent::initialize($config);
	}

}
