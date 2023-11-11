<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class InitSandbox extends AbstractMigration {

	/**
	 * Up Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
	 * @return void
	 */
	public function up(): void {
		$this->table('bitmasked_records')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('flag_optional', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('flag_required', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => false,
				'signed' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('continents')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 64,
				'null' => false,
			])
			->addColumn('ori_name', 'string', [
				'default' => null,
				'limit' => 64,
				'null' => false,
			])
			->addColumn('parent_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('lft', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('rght', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('status', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 2,
				'null' => true,
			])
			->create();

		$this->table('countries')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 64,
				'null' => false,
			])
			->addColumn('ori_name', 'string', [
				'default' => null,
				'limit' => 64,
				'null' => false,
			])
			->addColumn('iso2', 'string', [
				'default' => null,
				'limit' => 2,
				'null' => false,
			])
			->addColumn('iso3', 'string', [
				'default' => null,
				'limit' => 3,
				'null' => false,
			])
			->addColumn('eu_member', 'boolean', [
				'comment' => 'Member of the EU',
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('special', 'string', [
				'default' => null,
				'limit' => 40,
				'null' => false,
			])
			->addColumn('zip_length', 'tinyinteger', [
				'comment' => 'if > 0 validate on this length',
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('zip_regexp', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('sort', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('lat', 'float', [
				'comment' => 'latitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
				'signed' => true,
			])
			->addColumn('lng', 'float', [
				'comment' => 'longitude',
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
				'signed' => true,
			])
			->addColumn('address_format', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('status', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('timezone', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('phone_code', 'string', [
				'default' => null,
				'limit' => 20,
				'null' => true,
			])
			->create();

		$this->table('currencies')
			->addColumn('name', 'string', [
				'default' => '',
				'limit' => 255,
				'null' => false,
			])
			->addColumn('code', 'char', [
				'default' => '',
				'limit' => 3,
				'null' => false,
			])
			->addColumn('symbol_left', 'string', [
				'default' => '',
				'limit' => 12,
				'null' => true,
			])
			->addColumn('symbol_right', 'string', [
				'default' => '',
				'limit' => 12,
				'null' => true,
			])
			->addColumn('decimal_places', 'char', [
				'default' => '',
				'limit' => 1,
				'null' => true,
			])
			->addColumn('value', 'float', [
				'default' => '0.0000',
				'null' => true,
				'precision' => 9,
				'scale' => 4,
				'signed' => true,
			])
			->addColumn('base', 'boolean', [
				'comment' => 'is base currency',
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('database_logs')
			->addColumn('type', 'string', [
				'default' => null,
				'limit' => 50,
				'null' => false,
			])
			->addColumn('summary', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('message', 'text', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('context', 'text', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('ip', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => true,
			])
			->addColumn('hostname', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => true,
			])
			->addColumn('uri', 'text', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('refer', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('user_agent', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('count', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => true,
			])
			->create();

		$this->table('events')
			->addColumn('title', 'string', [
				'default' => null,
				'limit' => 200,
				'null' => false,
			])
			->addColumn('location', 'string', [
				'default' => null,
				'limit' => 200,
				'null' => false,
			])
			->addColumn('lat', 'float', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('lng', 'float', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('description', 'text', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('beginning', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('end', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->create();

		$this->table('exposed_users')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('uuid', 'binaryuuid', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addIndex(
				[
					'uuid',
				],
				[
					'name' => 'uuid',
					'unique' => true,
				],
			)
			->create();

		$this->table('languages')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 40,
				'null' => false,
			])
			->addColumn('ori_name', 'string', [
				'default' => null,
				'limit' => 40,
				'null' => false,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 6,
				'null' => false,
			])
			->addColumn('iso3', 'char', [
				'default' => null,
				'limit' => 3,
				'null' => false,
			])
			->addColumn('iso2', 'char', [
				'default' => null,
				'limit' => 2,
				'null' => false,
			])
			->addColumn('locale', 'string', [
				'default' => null,
				'limit' => 30,
				'null' => false,
			])
			->addColumn('locale_fallback', 'string', [
				'default' => null,
				'limit' => 30,
				'null' => false,
			])
			->addColumn('status', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('sort', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('registrations')
			->addColumn('session_id', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('user_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => false,
				'signed' => true,
			])
			->addColumn('status', 'string', [
				'default' => 'pending',
				'limit' => 100,
				'null' => false,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('roles')
			->addColumn('name', 'string', [
				'default' => '',
				'limit' => 64,
				'null' => false,
			])
			->addColumn('alias', 'string', [
				'default' => null,
				'limit' => 20,
				'null' => false,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('sandbox_animals')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('sandbox_categories')
			->addColumn('parent_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 180,
				'null' => false,
			])
			->addColumn('description', 'text', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('status', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('lft', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('rght', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => false,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->create();

		$this->table('sandbox_posts')
			->addColumn('title', 'string', [
				'default' => null,
				'limit' => 180,
				'null' => false,
			])
			->addColumn('content', 'text', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('rating_count', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('rating_sum', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->create();

		$this->table('sandbox_profiles')
			->addColumn('username', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('balance', 'decimal', [
				'default' => '0.00',
				'null' => false,
				'precision' => 10,
				'scale' => 2,
				'signed' => true,
			])
			->addColumn('extra', 'decimal', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 2,
				'signed' => true,
			])
			->create();

		$this->table('sandbox_ratings')
			->addColumn('user_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('foreign_key', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('model', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('value', 'float', [
				'default' => '0.0000',
				'null' => false,
				'precision' => 8,
				'scale' => 4,
				'signed' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addIndex(
				[
					'user_id',
					'foreign_key',
					'model',
				],
				[
					'name' => 'UNIQUE_RATING',
					'unique' => true,
				],
			)
			->addIndex(
				[
					'user_id',
				],
				[
					'name' => 'user_id',
				],
			)
			->addIndex(
				[
					'foreign_key',
				],
				[
					'name' => 'foreign_key',
				],
			)
			->create();

		$this->table('sandbox_users')
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('username', 'string', [
				'default' => null,
				'limit' => 30,
				'null' => false,
			])
			->addColumn('slug', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('password', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('email', 'string', [
				'default' => null,
				'limit' => 80,
				'null' => false,
			])
			->addColumn('role_id', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => true,
			])
			->addColumn('status', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => true,
			])
			->create();

		$this->table('states')
			->addColumn('country_id', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'limit' => 3,
				'null' => false,
			])
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 40,
				'null' => false,
			])
			->addColumn('lat', 'float', [
				'default' => '0.000000',
				'null' => false,
				'precision' => 10,
				'scale' => 6,
				'signed' => true,
			])
			->addColumn('lng', 'float', [
				'default' => '0.000000',
				'null' => false,
				'precision' => 10,
				'scale' => 6,
				'signed' => true,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->create();

		$this->table('timezones')
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('offset', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('offset_dst', 'string', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('type', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('country_code', 'string', [
				'comment' => 'ISO_3166-2',
				'default' => null,
				'limit' => 2,
				'null' => true,
			])
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('lat', 'float', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
				'signed' => true,
			])
			->addColumn('lng', 'float', [
				'default' => null,
				'null' => true,
				'precision' => 10,
				'scale' => 6,
				'signed' => true,
			])
			->addColumn('covered', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('notes', 'string', [
				'default' => null,
				'limit' => 190,
				'null' => true,
			])
			->addColumn('linked_id', 'integer', [
				'default' => null,
				'limit' => null,
				'null' => true,
				'signed' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->create();

		$this->table('users')
			->addColumn('active', 'boolean', [
				'default' => false,
				'limit' => null,
				'null' => false,
			])
			->addColumn('last_login', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => null,
				'limit' => null,
				'null' => false,
			])
			->addColumn('logins', 'integer', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => false,
			])
			->addColumn('username', 'string', [
				'default' => null,
				'limit' => 30,
				'null' => false,
			])
			->addColumn('password', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => false,
			])
			->addColumn('email', 'string', [
				'default' => null,
				'limit' => 80,
				'null' => false,
			])
			->addColumn('role_id', 'tinyinteger', [
				'default' => '0',
				'limit' => null,
				'null' => false,
				'signed' => true,
			])
			->create();
	}

	/**
	 * Down Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
	 * @return void
	 */
	public function down(): void {
		/*
		$this->table('state_machine_item_state_logs')
			->dropForeignKey(
				'state_machine_item_state_id',
			)->save();

		$this->table('state_machine_item_states')
			->dropForeignKey(
				'state_machine_process_id',
			)->save();

		$this->table('state_machine_timeouts')
			->dropForeignKey(
				'state_machine_item_state_id',
			)
			->dropForeignKey(
				'state_machine_process_id',
			)->save();

		$this->table('state_machine_transition_logs')
			->dropForeignKey(
				'state_machine_item_id',
			)
			->dropForeignKey(
				'state_machine_process_id',
			)->save();
		*/

		$this->table('bitmasked_records')->drop()->save();
		$this->table('continents')->drop()->save();
		$this->table('countries')->drop()->save();
		$this->table('currencies')->drop()->save();
		$this->table('database_logs')->drop()->save();
		$this->table('events')->drop()->save();
		$this->table('exposed_users')->drop()->save();
		$this->table('languages')->drop()->save();
		$this->table('registrations')->drop()->save();
		$this->table('roles')->drop()->save();
		$this->table('sandbox_animals')->drop()->save();
		$this->table('sandbox_categories')->drop()->save();
		$this->table('sandbox_posts')->drop()->save();
		$this->table('sandbox_profiles')->drop()->save();
		$this->table('sandbox_ratings')->drop()->save();
		$this->table('sandbox_users')->drop()->save();
		/*
		$this->table('state_machine_item_state_logs')->drop()->save();
		$this->table('state_machine_item_states')->drop()->save();
		$this->table('state_machine_items')->drop()->save();
		$this->table('state_machine_locks')->drop()->save();
		$this->table('state_machine_processes')->drop()->save();
		$this->table('state_machine_timeouts')->drop()->save();
		$this->table('state_machine_transition_logs')->drop()->save();
		*/
		$this->table('states')->drop()->save();
		$this->table('timezones')->drop()->save();
		$this->table('users')->drop()->save();
	}

}
