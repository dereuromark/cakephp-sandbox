<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationTimezones extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('timezones')
			->addColumn('name', 'string', [
				'comment' => null,
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('offset', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('offset_dst', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('type', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('country_code', 'string', [
				'comment' => 'ISO_3166-2',
				'default' => null,
				'limit' => 2,
				'null' => true,
			])
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('lat', 'float', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('lng', 'float', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('covered', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('notes', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('linked_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();
	}

}
