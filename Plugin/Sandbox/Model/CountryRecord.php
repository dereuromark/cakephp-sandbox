<?php
App::uses('SandboxAppModel', 'Sandbox.Model');

class CountryRecord extends SandboxAppModel {

	public $useTable = 'countries';

	public $alias = 'Country';

	public $order = array('CountryRecord.sort' => 'DESC', 'CountryRecord.name' => 'ASC');

	public $actsAs = array('Search.Searchable');

	public $filterArgs = array(
		'search' => array('type' => 'like', 'field' => array('name', 'ori_name', 'iso2', 'iso3')),
	);

}
