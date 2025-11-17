<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddUserIdToSandboxArticles extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('sandbox_articles');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addIndex([
            'user_id',
        
            ], [
            'name' => 'BY_USER_ID',
            'unique' => false,
        ]);
        $table->update();
    }
}
