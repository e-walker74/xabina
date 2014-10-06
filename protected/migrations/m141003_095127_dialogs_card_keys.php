<?php

class m141003_095127_dialogs_card_keys extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Constraints for table `dialogs_card`
			--
			ALTER TABLE `dialogs_card`
			  ADD CONSTRAINT `dialogs_card_ibfk_1` FOREIGN KEY (`msg_id`) REFERENCES `dialogs_msg` (`id`),
			  ADD CONSTRAINT `dialogs_card_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
			  ADD CONSTRAINT `dialogs_card_ibfk_3` FOREIGN KEY (`book_id`) REFERENCES `users_contacts` (`id`);
		');	
	}

	public function down()
	{
		echo "m141003_095127_dialogs_card_keys does not support migration down.\n";
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