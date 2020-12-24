<?php
declare(strict_types = 1);

use Migrations\AbstractMigration;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable PSR2R.Classes.ClassFileName.NoMatch
class MigrationCountryTimezones extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$this->table('countries')
			->addColumn('timezone', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->changeColumn('country_code', 'string', [
				'default' => null,
				'limit' => 20,
				'null' => true,
			])
			->renameColumn('country_code', 'phone_code')
			->update();
	}

}
