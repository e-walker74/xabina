<?php

class m141003_095143_dialogs_files_keys extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Constraints for table `dialogs_files`
			--
			ALTER TABLE `dialogs_files`
			  ADD CONSTRAINT `dialogs_files_ibfk_1` FOREIGN KEY (`msg_id`) REFERENCES `dialogs_msg` (`id`),
			  ADD CONSTRAINT `dialogs_files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
		');	
	}

	public function down()
	{
		echo "m141003_095143_dialogs_files_keys does not support migration down.\n";
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