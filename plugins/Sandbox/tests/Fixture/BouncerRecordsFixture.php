<?php
declare(strict_types=1);

namespace Sandbox\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BouncerRecordsFixture
 */
class BouncerRecordsFixture extends TestFixture {

	/**
	 * @var string
	 */
	public string $table = 'bouncer_records';

	/**
	 * Fields
	 *
	 * @var array<string, mixed>
	 */
	public array $fields = [
		'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'autoIncrement' => true],
		'source' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null],
		'primary_key' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => true, 'default' => null],
		'user_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null],
		'user_display' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null],
		'reviewer_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => true, 'default' => null],
		'reviewer_display' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null],
		'status' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => 'pending'],
		'data' => ['type' => 'text', 'length' => 16777215, 'null' => false, 'default' => null],
		'original_data' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null],
		'note' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null],
		'original_modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null],
		'reason' => ['type' => 'text', 'null' => true, 'default' => null],
		'reviewed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null],
		'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null],
		'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id']],
		],
		'_indexes' => [
			'idx_source' => ['type' => 'index', 'columns' => ['source']],
			'idx_primary_key' => ['type' => 'index', 'columns' => ['primary_key']],
			'idx_user_id' => ['type' => 'index', 'columns' => ['user_id']],
			'idx_reviewer_id' => ['type' => 'index', 'columns' => ['reviewer_id']],
			'idx_status' => ['type' => 'index', 'columns' => ['status']],
			'idx_created' => ['type' => 'index', 'columns' => ['created']],
			'idx_source_primary_status' => ['type' => 'index', 'columns' => ['source', 'primary_key', 'status']],
		],
	];

	/**
	 * Init method
	 *
	 * @return void
	 */
	public function init(): void {
		$this->records = [];
		parent::init();
	}

}
