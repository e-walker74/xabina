<?php

class m141007_134140_users_tags_user_null extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `users_tags`
            MODIFY COLUMN `user_id`  int(11) UNSIGNED NULL AFTER `id`;
        ');
	}

	public function down()
	{
		echo "m141007_134140_users_tags_user_null does not support migration down.\n";
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