<?php

namespace Sandbox\Model\Table;

use Cake\Core\Configure;
use Data\Model\Table\CountriesTable;

/**
 * @property \Data\Model\Table\StatesTable&\Cake\ORM\Association\HasMany $States
 *
 * @mixin \Hashid\Model\Behavior\HashidBehavior
 */
class HashidCountriesTable extends CountriesTable {

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->table('countries');

		$config = [
			'field' => Configure::read('Hashid.field'),
			'debug' => Configure::read('Hashid.debug'),
		];
		$this->addBehavior('Hashid.Hashid', $config);
	}

}
