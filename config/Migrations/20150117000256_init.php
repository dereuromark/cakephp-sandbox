<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration {

	/**
	 * Migrate Up.
	 */
	public function up() {
		$content = file_get_contents(dirname(__FILE__) . '/' . '20150117000256_sql.sql');
		$this->query($content);
	}

	/**
	 * Migrate Down.
	 */
	public function down() {

	}

}
