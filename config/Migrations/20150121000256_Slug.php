<?php

use Phinx\Migration\AbstractMigration;

class Slug extends AbstractMigration {

	/**
	 * Migrate Up.
	 *
	 * @return void
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `sandbox_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
SQL;

		$this->query($content);
	}

	/**
	 * Migrate Down.
	 *
	 * @return void
	 */
	public function down() {
	}

}
