<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateDemoArticles extends BaseMigration {

	/**
	 * Change Method.
	 *
	 * More information on this method is available here:
	 * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
	 *
	 * @return void
	 */
	public function change(): void {
		$table = $this->table('demo_articles');
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
		$table->addColumn('created', 'datetime', [
			'default' => null,
			'null' => false,
		]);
		$table->addColumn('modified', 'datetime', [
			'default' => null,
			'null' => false,
		]);
		$table->create();

		// Shadow table for translations (parallel structure with locale)
		$translationsTable = $this->table('demo_articles_translations', [
			'id' => false,
			'primary_key' => ['id', 'locale'],
		]);
		$translationsTable->addColumn('id', 'integer', [
			'default' => null,
			'null' => false,
			'signed' => false,
		]);
		$translationsTable->addColumn('locale', 'string', [
			'default' => null,
			'limit' => 6,
			'null' => false,
		]);
		$translationsTable->addColumn('title', 'string', [
			'default' => null,
			'limit' => 255,
			'null' => true,
		]);
		$translationsTable->addColumn('content', 'text', [
			'default' => null,
			'null' => true,
		]);
		$translationsTable->create();
	}

}
