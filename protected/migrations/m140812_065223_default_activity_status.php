<?php

class m140812_065223_default_activity_status extends CDbMigration
{
	public function up()
	{
        $this->execute("
          ALTER TABLE `users`
MODIFY COLUMN `activity_status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 - activity status' AFTER `gift`;
          UPDATE users SET users.activity_status = 1 WHERE users.activity_status = 0;
        ");

	}

	public function down()
	{
		echo "m140812_065223_default_activity_status does not support migration down.\n";
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