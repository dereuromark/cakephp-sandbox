-- currencies
CREATE TABLE IF NOT EXISTS `{prefix}currencies` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;