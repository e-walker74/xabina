<?php

class m141003_095032_dialogs_msg_to_user_keys extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Constraints for table `dialogs_msg_to_user`
			--
			ALTER TABLE `dialogs_msg_to_user`
			  ADD CONSTRAINT `dialogs_msg_to_user_ibfk_1` FOREIGN KEY (`msg_id`) REFERENCES `dialogs_msg` (`id`),
			  ADD CONSTRAINT `dialogs_msg_to_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
			  ADD CONSTRAINT `dialogs_msg_to_user_ibfk_3` FOREIGN KEY (`dialog_id`) REFERENCES `dialogs_list` (`id`);	
		');	
	}

	public function down()
	{
		echo "m141003_095032_dialogs_msg_to_user_keys does not support migration down.\n";
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