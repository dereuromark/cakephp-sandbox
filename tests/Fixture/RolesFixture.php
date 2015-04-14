<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RolesFixture
 *
 */
class RolesFixture extends TestFixture
{

	/**
	 * Fields
	 *
	 * @var array
	 */
	// @codingStandardsIgnoreStart
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null],
		'name' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
		'alias' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
		],
		'_options' => [
			'engine' => 'MyISAM', 'collation' => 'utf8_unicode_ci'
		],
	];
	// @codingStandardsIgnoreEnd

	/**
	 * Records
	 *
	 * @var array
	 */
	public $records = [
		[
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 3,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 4,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 5,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 6,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 7,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 8,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 9,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
		[
			'id' => 10,
			'name' => 'Lorem ipsum dolor sit amet',
			'alias' => 'Lorem ipsum dolor ',
			'created' => '2015-03-29 00:18:50',
			'modified' => '2015-03-29 00:18:50'
		],
	];
}
