<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class SandboxCleanup extends AbstractMigration {

	/**
	 * Up Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
	 * @return void
	 */
	public function up(): void {
		$this->table('users')
			->changeColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'null' => false,
				'signed' => false,
			])
			->update();

		$this->table('bitmasked_records')
			->changeColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'null' => false,
				'signed' => false,
			])
			->update();
		$this->table('events')
			->changeColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'null' => false,
				'signed' => false,
			])
			->update();
		$this->table('exposed_users')
			->changeColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'null' => false,
				'signed' => false,
			])
			->update();
		$this->table('sandbox_ratings')
			->changeColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'null' => false,
				'signed' => false,
			])
			->changeColumn('user_id', 'integer', [
				'default' => null,
				'null' => true,
				'signed' => false,
			])
			->update();
		$this->table('sandbox_users')
			->changeColumn('id', 'integer', [
				'autoIncrement' => true,
				'default' => null,
				'null' => false,
				'signed' => false,
			])
			->update();

		/*
		 $this->table('sandbox_ratings')
			->addForeignKey('user_id', 'users', ['id'], ['delete' => 'SET_NULL'])
			->update();
		 */
	}

	/**
	 * @return void
	 */
	public function down(): void {
	}

}
