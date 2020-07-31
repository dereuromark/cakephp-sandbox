<?php
use Migrations\AbstractMigration;

class MigrationExposedUsers extends AbstractMigration
{
	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
	 * @return void
	 */
	public function change()
	{
		$table = $this->table('exposed_users');
		$table->addColumn('name', 'string', [
			'default' => null,
			'limit' => 100,
			'null' => false,
		]);

		// This is the field the plugin needs per entity to work
		$table->addColumn('uuid', 'binaryuuid', [
			'default' => null,
			'null' => false, // Add it as true for existing entities first, then fill/populate, then set to false afterwards.
		]);

		$table->addColumn('created', 'datetime', [
			'default' => null,
			'null' => false,
		]);
		$table->addColumn('modified', 'datetime', [
			'default' => null,
			'null' => false,
		]);

		// Besides primary key we will also want to have a unique index for quicker lookup on this exposed lookup field.
		$table->addIndex(['uuid'], ['unique' => true]);

		$table->create();
	}
}
