<?php

use Migrations\AbstractMigration;

class MigrationBitmasked extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$table = $this->table('bitmasked_records');
		$table->addColumn('name', 'string', [
			'default' => null,
			'limit' => 100,
			'null' => false,
		]);

		$table->addColumn('flag_optional', 'integer', [
			'limit' => 10,
			'default' => null,
			'null' => true,
		]);
		$table->addColumn('flag_required', 'integer', [
			'limit' => 10,
			'default' => null,
			'null' => false,
		]);

		$table->addColumn('created', 'datetime', [
			'default' => null,
			'null' => false,
		]);
		$table->addColumn('modified', 'datetime', [
			'default' => null,
			'null' => false,
		]);

		$table->create();
	}

}
