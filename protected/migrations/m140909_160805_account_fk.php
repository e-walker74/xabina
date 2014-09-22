<?php

class m140909_160805_account_fk extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `accounts_names` ADD CONSTRAINT `fk_accounts_names_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
	}

	public function down()
	{
		echo "m140909_160805_account_fk does not support migration down.\n";
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