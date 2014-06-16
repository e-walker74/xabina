<?php

class m140606_181717_personal_manager_table extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('personal_managers', array(
            'id' => 'pk',
            'manager_name' => 'text',
            'manager_state' => 'int',
            'phone' => 'text',
            'email' => 'text',
            'language' => 'tinytext',
            'created_at' => 'int',
            'updated_at' => 'int'
        ));

        $this->createTable('users_personal_managers', array(
            'manager_id' => 'int',
            'user_id' => 'int',
            'widget_state' => 'tinyint(1)'
        ));


        $this->addForeignKey('usersPersonalMenager_manager_fk_constraint', 'users_personal_managers', 'manager_id', 'personal_managers', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('usersPersonalMenager_user_fk_constraint', 'users_personal_managers', 'user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('usersPersonalMenager_manager_fk_constraint', 'users_personal_managers');
        $this->dropForeignKey('usersPersonalMenager_user_fk_constraint', 'users_personal_managers');

        $this->dropTable('personal_managers');
        $this->dropTable('users_personal_managers');
    }
}