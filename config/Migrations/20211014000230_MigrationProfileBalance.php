<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationProfileBalance extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('sandbox_profiles')
			->addColumn('username', 'string', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('balance', 'decimal', [
				'default' => 0.0,
				'limit' => null,
				'null' => false,
				'precision' => 10,
				'scale' => 2,
			])
			->addColumn('extra', 'decimal', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 2,
			])
			->create();
	}

}
