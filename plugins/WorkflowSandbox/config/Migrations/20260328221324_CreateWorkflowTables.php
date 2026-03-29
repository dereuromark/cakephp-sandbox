<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Create all workflow demo tables.
 */
class CreateWorkflowTables extends BaseMigration {

	/**
	 * @return void
	 */
	public function change(): void {
		// Registrations table
		$this->table('workflow_registrations')
			->addColumn('user_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('session_id', 'string', [
				'limit' => 255,
				'null' => true,
			])
			->addColumn('status', 'string', [
				'limit' => 50,
				'default' => 'pending',
			])
			->addColumn('notes', 'text', [
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'null' => true,
			])
			->addIndex(['user_id'])
			->addIndex(['status'])
			->create();

		// Orders table
		$this->table('workflow_orders')
			->addColumn('user_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('order_number', 'string', [
				'limit' => 50,
				'null' => false,
			])
			->addColumn('status', 'string', [
				'limit' => 50,
				'default' => 'pending',
			])
			->addColumn('total', 'decimal', [
				'precision' => 10,
				'scale' => 2,
				'default' => 0,
			])
			->addColumn('payment_method', 'string', [
				'limit' => 50,
				'null' => true,
			])
			->addColumn('shipping_address', 'text', [
				'null' => true,
			])
			->addColumn('paid_at', 'datetime', [
				'null' => true,
			])
			->addColumn('shipped_at', 'datetime', [
				'null' => true,
			])
			->addColumn('delivered_at', 'datetime', [
				'null' => true,
			])
			->addColumn('cancelled_at', 'datetime', [
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'null' => true,
			])
			->addIndex(['user_id'])
			->addIndex(['order_number'], ['unique' => true])
			->addIndex(['status'])
			->create();

		// Contents table
		$this->table('workflow_contents')
			->addColumn('user_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('reviewer_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('title', 'string', [
				'limit' => 255,
				'null' => false,
			])
			->addColumn('body', 'text', [
				'null' => true,
			])
			->addColumn('status', 'string', [
				'limit' => 50,
				'default' => 'draft',
			])
			->addColumn('rejection_reason', 'text', [
				'null' => true,
			])
			->addColumn('published_at', 'datetime', [
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'null' => true,
			])
			->addIndex(['user_id'])
			->addIndex(['reviewer_id'])
			->addIndex(['status'])
			->create();

		// Tickets table
		$this->table('workflow_tickets')
			->addColumn('user_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('assignee_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('ticket_number', 'string', [
				'limit' => 50,
				'null' => false,
			])
			->addColumn('subject', 'string', [
				'limit' => 255,
				'null' => false,
			])
			->addColumn('description', 'text', [
				'null' => true,
			])
			->addColumn('priority', 'string', [
				'limit' => 20,
				'default' => 'medium',
			])
			->addColumn('status', 'string', [
				'limit' => 50,
				'default' => 'open',
			])
			->addColumn('escalated_at', 'datetime', [
				'null' => true,
			])
			->addColumn('resolved_at', 'datetime', [
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'null' => true,
			])
			->addIndex(['user_id'])
			->addIndex(['assignee_id'])
			->addIndex(['ticket_number'], ['unique' => true])
			->addIndex(['status'])
			->addIndex(['priority'])
			->create();

		// Documents table
		$this->table('workflow_documents')
			->addColumn('user_id', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('title', 'string', [
				'limit' => 255,
				'null' => false,
			])
			->addColumn('file_path', 'string', [
				'limit' => 500,
				'null' => true,
			])
			->addColumn('status', 'string', [
				'limit' => 50,
				'default' => 'draft',
			])
			->addColumn('current_approver_level', 'integer', [
				'default' => 0,
			])
			->addColumn('approved_by', 'text', [
				'null' => true,
			])
			->addColumn('rejected_by', 'integer', [
				'null' => true,
				'signed' => false,
			])
			->addColumn('rejection_reason', 'text', [
				'null' => true,
			])
			->addColumn('created', 'datetime', [
				'null' => true,
			])
			->addColumn('modified', 'datetime', [
				'null' => true,
			])
			->addIndex(['user_id'])
			->addIndex(['status'])
			->create();
	}

}
