<?php

class m140611_161227_personal_manager_table_update extends CDbMigration
{

    public function safeUp()
    {
        $this->addColumn('personal_managers', 'is_default', 'tinyint(1)');
    }

    public function safeDown()
    {
        $this->dropColumn('personal_managers', 'is_default');
    }
}