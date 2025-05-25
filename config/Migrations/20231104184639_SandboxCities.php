<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class SandboxCities extends BaseMigration {

	/**
	 * Up Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
	 * @return void
	 */
	public function change(): void {
		$this->table('sandbox_cities')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => false,
			])
			->addColumn('alias', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('country_id', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => false,
				'signed' => false,
			])
			->addColumn('lat', 'float', [
				'comment' => 'latitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addColumn('lng', 'float', [
				'comment' => 'longitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
			])
			->addIndex(
				[
					'name', 'country_id',
				],
				['unique' => true],
			)
			->addIndex(
				[
					'lat', 'lng',
				],
				['unique' => false],
			)
			->addIndex(
				[
					'name',
				],
			)
			->create();
	}

}
