<?php

use Phinx\Migration\AbstractMigration;

class Cat extends AbstractMigration {

	/**
	 * Migrate Up.
	 */
	public function up() {
		$content = <<<SQL
CREATE TABLE IF NOT EXISTS `sandbox_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rght` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `sandbox_categories` (`id`, `parent_id`, `name`, `description`, `status`, `lft`, `rght`, `created`, `modified`) VALUES
(1, NULL, 'Alpha', 'First One', NULL, 1, 2, '2015-05-21 10:14:01', '2015-05-21 10:14:01'),
(2, NULL, 'Beta', 'Second One', NULL, 3, 8, '2015-05-21 10:14:01', '2015-05-21 10:14:01'),
(3, NULL, 'Gamma', 'Third One', NULL, 9, 10, '2015-05-21 10:14:01', '2015-05-21 10:14:01'),
(4, NULL, 'Delta', 'Forth One', NULL, 11, 14, '2015-05-21 10:14:01', '2015-05-21 10:14:01'),
(5, 2, 'Child of 2nd one', 'Fifth One', NULL, 4, 7, '2015-05-21 10:14:01', '2015-05-21 10:14:01'),
(6, 5, 'Child of child', 'Sixth One', NULL, 5, 6, '2015-05-21 10:14:01', '2015-05-21 10:14:01'),
(7, 4, 'Child of 4th one', 'Seventh One', NULL, 12, 13, '2015-05-21 10:14:01', '2015-05-21 10:14:01');
SQL;

		$this->query($content);
	}

	/**
	 * Migrate Down.
	 */
	public function down() {

	}

}
