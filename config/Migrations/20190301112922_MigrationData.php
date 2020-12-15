<?php

use Migrations\AbstractMigration;

class MigrationData extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('continents')
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 2,
				'null' => true,
			])
			->changeColumn('parent_id', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->changeColumn('lft', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->changeColumn('rght', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => true,
				'signed' => false,
			])
			->update();

		$this->table('countries')
			->changeColumn('lat', 'float', [
				'comment' => 'latitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->changeColumn('lng', 'float', [
				'comment' => 'longitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->changeColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->update();
	}

}
