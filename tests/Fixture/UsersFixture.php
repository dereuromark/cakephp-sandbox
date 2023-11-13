<?php
/**
 * UserFixture
 */

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture {

	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer', 'null' => false, 'default' => null],
		'active' => ['type' => 'boolean', 'null' => false, 'default' => '0'],
		'last_login' => ['type' => 'datetime', 'null' => true, 'default' => null],
		'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
		'modified' => ['type' => 'datetime', 'null' => true, 'default' => null],
		'logins' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10],
		'username' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'password' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 255, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'email' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 80, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'],
		'role_id' => ['type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]],
		'_options' => ['charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM'],
	];

	/**
	 * Records
	 *
	 * @var array
	 */
	public array $records = [
		[
			'active' => 1,
			'last_login' => '2014-04-13 05:10:28',
			'created' => '2014-04-13 05:10:28',
			'modified' => '2014-04-13 05:10:28',
			'logins' => 1,
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'role_id' => 1,
		],
	];

}
