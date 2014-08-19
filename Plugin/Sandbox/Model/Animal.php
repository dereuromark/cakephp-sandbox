<?php
App::uses('SandboxAppModel', 'Sandbox.Model');
/**
 * Description of Animal
 *
 * @author David Yell <neon1024@gmail.com>
 */
class Animal extends SandboxAppModel {
}

/**
This model relies on having some data to search. Included here is the example
table used for the jQueryUI autocomplete example.

DROP TABLE IF EXISTS `animals`;

CREATE TABLE `animals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `animals` (`id`, `name`)
VALUES
	(1,'Alpaca'),
	(2,'Armadillo'),
	(3,'Badger'),
	(4,'Butterfly'),
	(5,'Cheetah'),
	(6,'Chicken'),
	(7,'Dog'),
	(8,'Dragonfly'),
	(9,'Eagle'),
	(10,'Elephant'),
	(11,'Frog'),
	(12,'Fox'),
	(13,'Giraffe'),
	(14,'Goat'),
	(15,'Hawk'),
	(16,'Hornet'),
	(17,'Ibex'),
	(18,'Ibis'),
	(19,'Jackal'),
	(20,'Jellyfish'),
	(21,'Koala'),
	(22,'Kookabura'),
	(23,'Lion'),
	(24,'Llama'),
	(25,'Mantis'),
	(26,'Meerkat'),
	(27,'Narwhal'),
	(28,'Newt'),
	(29,'Octopus'),
	(30,'Ostrich'),
	(31,'Parrot'),
	(32,'Penguin'),
	(33,'Quetzal'),
	(34,'Quail'),
	(35,'Raven'),
	(36,'Rhinoceros'),
	(37,'Scorpion'),
	(38,'Snake'),
	(39,'Tiger'),
	(40,'Toad'),
	(41,'Viper'),
	(42,'Vulture'),
	(43,'Wasp'),
	(44,'Whale'),
	(45,'Yak'),
	(46,'Zebra');


 */