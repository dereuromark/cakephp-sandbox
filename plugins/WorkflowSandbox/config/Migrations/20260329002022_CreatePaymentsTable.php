<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePaymentsTable extends BaseMigration {

	/**
	 * @return void
	 */
	public function change(): void {
		$this->table('workflow_sandbox_payments')
			->addColumn('user_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('transaction_id', 'string', [
				'limit' => 100,
				'null' => false,
			])
			->addColumn('amount', 'decimal', [
				'precision' => 10,
				'scale' => 2,
				'null' => false,
			])
			->addColumn('currency', 'string', [
				'limit' => 3,
				'default' => 'USD',
			])
			->addColumn('provider', 'string', [
				'limit' => 50,
				'null' => true,
			])
			->addColumn('provider_reference', 'string', [
				'limit' => 255,
				'null' => true,
			])
			->addColumn('status', 'string', [
				'limit' => 50,
				'default' => 'pending',
			])
			->addColumn('retry_count', 'integer', [
				'default' => 0,
			])
			->addColumn('failure_reason', 'text', [
				'null' => true,
			])
			->addColumn('verified_at', 'datetime', [
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'null' => true,
			])
			->addIndex(['user_id'])
			->addIndex(['transaction_id'], ['unique' => true])
			->addIndex(['status'])
			->addIndex(['provider'])
			->create();
	}

}
