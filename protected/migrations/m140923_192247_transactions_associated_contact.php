<?php

class m140923_192247_transactions_associated_contact extends CDbMigration
{
	public function up()
	{
        $this->execute('
          ALTER TABLE `transactions`
		  
		  ADD COLUMN `execution_time`  int(11) NULL AFTER `created_at`,
          ADD COLUMN `associated_contact`  int(11) NULL AFTER `execution_time`;
        ');
	}

	public function down()
	{
		echo "m140923_192247_transactions_associated_contact does not support migration down.\n";
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