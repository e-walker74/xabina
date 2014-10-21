<?php

class m141016_185752_multi_balance extends CDbMigration
{
	public function up()
	{
        $this->execute('
          ALTER TABLE `accounts`
            ADD COLUMN `multi_balance` double NULL AFTER `credit_facility`,
            MODIFY COLUMN `credit_facility`  double UNSIGNED NOT NULL DEFAULT 0 AFTER `name`;

            ALTER TABLE `accounts`
MODIFY COLUMN `status`  tinyint(4) NOT NULL DEFAULT 0 AFTER `user_id`;

            UPDATE accounts SET status = "-1" WHERE status = 1;


        ');
	}

	public function down()
	{
		echo "m141016_185752_multi_balance does not support migration down.\n";
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