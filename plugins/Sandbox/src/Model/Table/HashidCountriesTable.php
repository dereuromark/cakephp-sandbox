<?php
namespace Sandbox\Model\Table;

use Cake\Core\Configure;
use Data\Model\Table\CountriesTable;

class HashidCountriesTable extends CountriesTable {

	/**
	 * initialize()
	 *
	 * @param mixed $config
	 * @return void
	 */
	public function initialize(array $config) {
		$this->table('countries');

		$config = [
			'field' => Configure::read('Hashid.field'),
			'debug' => Configure::read('Hashid.debug'),
		];
		$this->addBehavior('Hashid.Hashid', $config);
	}

}
