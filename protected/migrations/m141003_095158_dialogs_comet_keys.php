<?php

class m141003_095158_dialogs_comet_keys extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Constraints for table `dialogs_comet`
			--
			ALTER TABLE `dialogs_comet`
			  ADD CONSTRAINT `dialogs_comet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
			  ADD CONSTRAINT `dialogs_comet_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);
		');	
	}

	public function down()
	{
		echo "m141003_095158_dialogs_comet_keys does not support migration down.\n";
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