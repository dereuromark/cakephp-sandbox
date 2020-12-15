<?php

use Phinx\Migration\AbstractMigration;

class Currencies extends AbstractMigration {

	/**
	 * Migrate Up.
	 *
	 * @return void
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `symbol_left` varchar(12) COLLATE utf8_unicode_ci DEFAULT '',
  `symbol_right` varchar(12) COLLATE utf8_unicode_ci DEFAULT '',
  `decimal_places` char(1) COLLATE utf8_unicode_ci DEFAULT '',
  `value` float(9,4) DEFAULT '0.0000',
  `base` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'is base currency',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol_left`, `symbol_right`, `decimal_places`, `value`, `base`, `active`, `modified`) VALUES
(1, 'US Dollar', 'USD', '$', '', '2', 1.4146, 0, 1, '2011-07-16 15:12:33'),
(2, 'Euro', 'EUR', '€', '', '2', 1.0000, 1, 1, '2009-11-23 12:45:15'),
(3, 'British Pounds', 'GBP', '£', '', '2', 0.8775, 0, 1, '2011-07-16 15:12:33'),
(4, 'Schweizer Franken', 'CHF', '', 'Fr.', '2', 1.1577, 0, 1, '2011-07-16 15:12:33'),
(5, 'Australien Dollar', 'AUD', '', '', '2', 1.3264, 0, 0, '2011-07-16 15:12:33'),
(6, 'Canadian Dollar', 'CAD', '', '', '2', 1.3549, 0, 0, '2011-07-16 15:12:33'),
(7, 'Japanese Yen', 'JPY', '', '', '2', 111.9700, 0, 0, '2011-07-16 15:12:33'),
(9, 'Mexican Peso', 'MXN', '', '', '2', 16.5510, 0, 0, '2011-07-16 15:12:33'),
(10, 'Norwegian Krone', 'NOK', '', '', '2', 7.8665, 0, 0, '2011-07-16 15:12:33'),
(11, 'Swedish Krona', 'SEK', '', '', '2', 9.2121, 0, 0, '2011-07-16 15:12:33'),
(12, 'Bitcoin', 'BTC', '', 'BTC', '2', 0.1011, 0, 1, '2011-07-16 15:16:23');

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
