<?php

class m140812_111605_delete_ideal extends CDbMigration
{
	public function up()
	{
        $this->execute("
          Delete from users_payment_instruments where electronic_method = 2
        ");
	}

	public function down()
	{
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