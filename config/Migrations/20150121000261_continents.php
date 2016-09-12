<?php

use Phinx\Migration\AbstractMigration;

class Continents extends AbstractMigration {

	/**
	 * Migrate Up.
	 *
	 * @return void
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `continents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ori_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rght` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `continents`
--

INSERT INTO `continents` (`id`, `name`, `ori_name`, `parent_id`, `lft`, `rght`, `status`, `modified`) VALUES
(1, 'Eurasia', '', 0, 1, 6, 0, '2011-07-15 19:55:33'),
(2, 'Europe', '', 1, 2, 3, 0, '2011-07-15 19:55:40'),
(3, 'Asia', '', 1, 4, 5, 0, '2011-07-15 19:55:47'),
(4, 'America', '', 0, 7, 12, 0, '2011-07-15 19:56:06'),
(5, 'South America', '', 4, 8, 9, 0, '2011-07-15 19:56:16'),
(6, 'North America', '', 4, 10, 11, 0, '2011-07-15 19:56:22'),
(7, 'Antarctica', '', 0, 13, 14, 0, '2011-07-15 19:56:39'),
(8, 'Australia', '', 0, 15, 16, 0, '2011-07-15 19:56:48');

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
