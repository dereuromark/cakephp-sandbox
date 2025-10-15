<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSandboxArticles extends BaseMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change(): void {
		$table = $this->table('sandbox_articles');
		$table->addColumn('title', 'string', [
			'default' => null,
			'limit' => 255,
			'null' => false,
		]);
		$table->addColumn('content', 'text', [
			'default' => null,
			'null' => false,
		]);
		$table->addColumn('status', 'string', [
			'default' => null,
			'limit' => 255,
			'null' => false,
		]);
		$table->create();
	}

}
