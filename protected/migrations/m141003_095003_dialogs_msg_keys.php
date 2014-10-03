<?php

class m141003_095003_dialogs_msg_keys extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Constraints for table `dialogs_msg`
			--
			ALTER TABLE `dialogs_msg`
			  ADD CONSTRAINT `dialogs_msg_ibfk_1` FOREIGN KEY (`dialog_id`) REFERENCES `dialogs_list` (`id`),
			  ADD CONSTRAINT `dialogs_msg_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
		');	
	}

	public function down()
	{
		echo "m141003_095003_dialogs_msg_keys does not support migration down.\n";
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