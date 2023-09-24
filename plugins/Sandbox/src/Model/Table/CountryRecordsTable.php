<?php

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

/**
 * @method \Search\Manager searchManager()
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class CountryRecordsTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['sort' => 'DESC', 'name' => 'ASC'];

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->setTable('countries');

		parent::initialize($config);

		$this->addBehavior('Search.Search');

		$this->searchManager()
			->value('status')
			->add('search', 'Search.Like', [
				'before' => true,
				'after' => true,
				'mode' => 'or',
				'comparison' => 'LIKE',
				'fields' => ['name', 'ori_name', 'iso2', 'iso3'],
			]);
	}

}
