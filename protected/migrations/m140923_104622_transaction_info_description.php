<?php

class m140923_104622_transaction_info_description extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `transactions_info`
            ADD COLUMN `sender_description`  varchar(255) NULL AFTER `sender`,
            ADD COLUMN `recipient_description`  varchar(255) NULL AFTER `recipient`;
        ');
	}

	public function down()
	{
		echo "m140923_104622_transaction_info_description does not support migration down.\n";
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