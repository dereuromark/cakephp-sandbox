<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Add missing columns for workflow commands.
 */
class AddMissingWorkflowColumns extends BaseMigration {

	/**
	 * @return void
	 */
	public function change(): void {
		// Add refunded_at to orders
		$this->table('workflow_orders')
			->addColumn('refunded_at', 'datetime', [
				'null' => true,
				'after' => 'cancelled_at',
			])
			->update();

		// Add payment tracking columns to registrations
		$this->table('workflow_registrations')
			->addColumn('payment_requested_at', 'datetime', [
				'null' => true,
				'after' => 'notes',
			])
			->addColumn('confirmation_sent_at', 'datetime', [
				'null' => true,
				'after' => 'payment_requested_at',
			])
			->update();
	}

}
