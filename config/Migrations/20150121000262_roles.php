<?php

use Phinx\Migration\AbstractMigration;

class Roles extends AbstractMigration {

	/**
	 * Migrate Up.
	 *
	 * @return void
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `name`, `alias`, `created`, `modified`) VALUES
(1, 'Admin', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Moderator', 'mod', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'User', 'user', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Guest', 'guest', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Super-Admin', 'superadmin', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
