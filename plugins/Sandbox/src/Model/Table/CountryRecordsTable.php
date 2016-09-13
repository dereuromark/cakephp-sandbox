<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

/**
 * @method \Search\Manager searchManager()
 */
class CountryRecordsTable extends Table {

	public $order = ['sort' => 'DESC', 'name' => 'ASC'];

	public $filterArgs = [
		'search' => ['type' => 'like', 'field' => ['name', 'ori_name', 'iso2', 'iso3']],
		'status' => ['type' => 'value']
	];

	/**
	 * @param array $config
	 *
	 * @return void
     */
	public function initialize(array $config) {
		$this->table('countries');

		parent::initialize($config);

		$this->addBehavior('Search.Search');

		$this->searchManager()
			->value('status')
			->add('search', 'Search.Like', [
				'before' => true,
				'after' => true,
				'mode' => 'or',
				'comparison' => 'LIKE',
				'field' => ['name', 'ori_name', 'iso2', 'iso3']
			]);
	}

}
