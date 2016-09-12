<?php

use Phinx\Migration\AbstractMigration;

class RatingFix extends AbstractMigration {

	/**
	 * Migrate Up.
	 */
	public function up() {
		$content = <<<SQL
ALTER TABLE `sandbox_ratings` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT;
SQL;

		$this->query($content);
	}

	/**
	 * Migrate Down.
	 */
	public function down() {

	}

}
