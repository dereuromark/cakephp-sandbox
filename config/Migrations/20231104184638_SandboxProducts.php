<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class SandboxProducts extends BaseMigration {

	/**
	 * Up Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
	 * @return void
	 */
	public function change(): void {
		$this->table('sandbox_products')
			->addColumn('title', 'string', [
				'default' => null,
				'null' => false,
				'limit' => 100,
			])
			->addColumn('price', 'decimal', [
				'default' => null,
				'null' => false,
				'precision' => 10,
				'scale' => 2,
				'signed' => true,
			])
			->addColumn('created', 'datetime', [
				'default' => 'current_timestamp',
				'limit' => null,
				'null' => false,
			])
			->addColumn('modified', 'datetime', [
				'default' => 'current_timestamp',
				'limit' => null,
				'null' => false,
			])
			->create();
	}

	/**
	 * @return void
	 */
	public function down(): void {
	}

}
