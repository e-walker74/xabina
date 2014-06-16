<?php

class m140612_075118_account_type_update extends CDbMigration
{
    public function safeUp()
    {

        $this->addColumn('accounts_types', 'bet', 'float');
        $this->addColumn('accounts_types', 'payments', 'text');
        $this->addColumn('accounts_types', 'term', 'text');
        $this->addColumn('accounts_types', 'category_id', 'int');
        $this->addColumn('accounts_types', 'currency_id', 'int');
        $this->addColumn('accounts_types', 'color', 'tinytext');

        $this->addColumn('accounts', 'name', 'tinytext');

        $this->createTable('accounts_category', array(
            'id' => 'pk',
            'title' => 'text',
            'description' => 'text',
        ));

    }

    public function safeDown()
    {
        $this->dropColumn('accounts', 'name');
        $this->dropColumn('accounts_types', 'bet');
        $this->dropColumn('accounts_types', 'payments');
        $this->dropColumn('accounts_types', 'term');
        $this->dropColumn('accounts_types', 'category_id');
        $this->dropColumn('accounts_types', 'currency_id');
        $this->dropColumn('accounts_types', 'color');

        $this->dropTable('accounts_category');
    }
}