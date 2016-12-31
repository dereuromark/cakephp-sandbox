<?php
use Migrations\AbstractMigration;

class CreateEvents extends AbstractMigration
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
        $table = $this->table('events');
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('location', 'string', [
            'default' => null,
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('lat', 'float', [
            'default' => null,
			'length' => 10,
			'precision' => 6,
            'null' => true,
        ]);
		$table->addColumn('lng', 'float', [
			'default' => null,
			'length' => 10,
			'precision' => 6,
			'null' => true,
		]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('beginning', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('end', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
