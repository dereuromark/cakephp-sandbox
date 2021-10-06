<?php

use Migrations\AbstractMigration;

class States extends AbstractMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change() {
		$content = <<<SQL
RENAME TABLE `country_provinces` TO  `states`;
SQL;

		$this->query($content);

		$table = $this->table('States');
		$table->renameColumn('abbr', 'code');
		$table->update();
	}

}
