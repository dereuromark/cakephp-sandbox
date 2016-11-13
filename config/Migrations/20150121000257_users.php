<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration {

	/**
	 * Migrate Up.
	 *
	 * @return void
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SQL;
		$this->query($content);

		$content = <<<'SQL'
INSERT INTO `users` (`id`, `active`, `last_login`, `created`, `modified`, `logins`, `username`, `password`, `email`, `role_id`) VALUES
(1, 1, NULL, '2015-02-16 09:56:56', '2015-02-16 09:56:56', 0, 'user', '$2y$10$wo7.YGG1t8JStBooeqBEMeVsL/HgTJ8dJ6M6U1MtoZpZZgtS893W.', '', 4),
(2, 1, NULL, '2015-02-16 10:00:32', '2015-02-16 10:00:32', 0, 'admin', '$2y$10$9Zo2pVUHZiPpo0tzMCm9nOnMUWeMPFAcixOh4ppPcJPPLnw9NAAHm', '', 1),
(3, 1, NULL, '2015-02-16 10:00:38', '2015-02-16 10:00:38', 0, 'mod', '$2y$10$C1Y0PhjcdQ1QR9ZwQ8VwiuF0E/FS7jSEdblVJKTgWWHK8vm2VaBfi', '', 3);
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
