<?php

use Migrations\AbstractMigration;

class AddColumnsToBidinfo extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('bidinfo');
        $table->addColumn('modified', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->addColumn('receiver_name', 'string', [
            'default' => null,
            'limit' => 100,
        ]);
        $table->addColumn('receiver_address', 'string', [
            'default' => null,
            'limit' => 100,
        ]);
        $table->addColumn('receiver_phone_number', 'string', [
            'default' => null,
            'limit' => 13,
        ]);
        $table->addColumn('is_shipped', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('is_received', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
