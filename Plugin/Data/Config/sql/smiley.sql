-- smileys
CREATE TABLE IF NOT EXISTS `{prefix}smileys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `smiley_cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `smiley_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `prim_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sec_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `is_base` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'is part of the main smiley group (displayed first)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;