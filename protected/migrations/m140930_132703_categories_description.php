<?php

class m140930_132703_categories_description extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `categories`
            ADD COLUMN `description`  text NULL AFTER `title`,
            ADD COLUMN `created_at`  int(11) NOT NULL AFTER `description`;
		');
	}

	public function down()
	{
		echo "m140930_132703_categories_description does not support migration down.\n";
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