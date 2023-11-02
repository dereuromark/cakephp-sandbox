<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationUserStatus extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('sandbox_users')
			->addColumn('status', 'tinyinteger', [
				'default' => 0,
				'limit' => null,
				'null' => false,
			])
			->update();
	}

}
