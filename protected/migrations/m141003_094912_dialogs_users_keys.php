<?php

class m141003_094912_dialogs_users_keys extends CDbMigration
{
	public function up()
	{		
		$this->execute('
			--
			-- Constraints for table `dialogs_users`
			--
			ALTER TABLE `dialogs_users`
			  ADD CONSTRAINT `dialogs_users_ibfk_1` FOREIGN KEY (`dialog_id`) REFERENCES `dialogs_list` (`id`),
			  ADD CONSTRAINT `dialogs_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
		');	
	}

	public function down()
	{
		echo "m141003_094912_dialogs_users_keys does not support migration down.\n";
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