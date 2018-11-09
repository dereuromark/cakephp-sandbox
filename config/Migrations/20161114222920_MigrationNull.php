<?php
use Migrations\AbstractMigration;

class MigrationNull extends AbstractMigration
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
        $table = $this->table('sandbox_categories');
        $table->changeColumn('name', 'string', [
            'default' => null,
            'limit' => 180,
            'null' => false,
        ]);
        $table->update();

		$table = $this->table('sandbox_posts');
		$table->changeColumn('title', 'string', [
			'default' => null,
			'limit' => 180,
			'null' => false,
		]);
		$table->update();

		$table = $this->table('users');
		$table->changeColumn('created', 'datetime', [
			'default' => null,
			'null' => false,
		]);
		$table->changeColumn('modified', 'datetime', [
			'default' => null,
			'null' => false,
		]);
		$table->update();
    }
}
