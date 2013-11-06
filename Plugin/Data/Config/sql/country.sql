-- countries
CREATE TABLE IF NOT EXISTS `{prefix}countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ori_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `iso2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `iso3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` int(4) unsigned NOT NULL DEFAULT '0',
  `eu_member` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Member of the EU',
  `special` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `zip_length` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'if > 0 validate on this length',
  `zip_regexp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `lat` float(10,6) NOT NULL DEFAULT '0.000000' COMMENT 'forGoogleMap',
  `lng` float(10,6) NOT NULL DEFAULT '0.000000' COMMENT 'forGoogleMap',
  `address_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci