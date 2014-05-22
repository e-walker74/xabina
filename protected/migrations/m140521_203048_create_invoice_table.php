<?php

class m140521_203048_create_invoice_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('invoices', array(
            'id' => 'pk',
            'user_id' => 'int',
            'currency_id' => 'int',
            'number' => 'text',
            'date' => 'DATETIME NOT NULL',
            'due_data' => 'DATETIME NOT NULL',
            'reference' => 'text',
            'email' => 'text',
            'discount' => 'float',
            'terms' => 'text',
            'note' => 'text'
        ));

        $this->createTable('invoices_options', array(
            'id' => 'pk',
            'invoice_id' => 'int',
            'name' => 'text',
            'quantity' => 'int',
            'price' => 'float',
            'tax' => 'int',
            'description' => 'text'
        ));
    }

    public function safeDown()
    {
        $this->dropTable('invoices');
        $this->dropTable('invoices_options');
    }
}