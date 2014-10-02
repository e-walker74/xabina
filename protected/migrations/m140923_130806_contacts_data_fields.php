<?php

class m140923_130806_contacts_data_fields extends CDbMigration
{
	public function up()
	{
        $this->execute(
            'ALTER TABLE `users_contacts_data`
            ADD COLUMN `field1`  varchar(255) NULL AFTER `category_id`,
            ADD COLUMN `field2`  varchar(255) NULL AFTER `field1`;'
        );
	}

	public function down()
	{
		echo "m140923_130806_contacts_data_fields does not support migration down.\n";
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