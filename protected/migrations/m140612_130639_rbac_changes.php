<?php

class m140612_130639_rbac_changes extends CDbMigration
{
	public function up()
	{
        //is_system - for rbac_right
        //добавить данные, стереть старые данные
	}

	public function down()
	{
		echo "m140612_130639_rbac_changes does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}