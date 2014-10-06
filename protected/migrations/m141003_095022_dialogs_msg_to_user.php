<?php

class m141003_095022_dialogs_msg_to_user extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Table structure for table `dialogs_msg_to_user`
			--

			CREATE TABLE IF NOT EXISTS `dialogs_msg_to_user` (
			  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT "id",
			  `msg_id` int(11) NOT NULL COMMENT "id сообщения",
			  `dialog_id` int(11) NOT NULL COMMENT "id диалога",
			  `user_id` int(11) unsigned NOT NULL COMMENT "id пользователя",
			  `status` int(11) NOT NULL COMMENT "статус сообщения (1 - прочитано, 2 - не прочитано, 3 - принудительно не прочитано)",
			  `group` varchar(255) NOT NULL COMMENT "Группа (цвет) сообщения",
			  `add_time` int(11) NOT NULL COMMENT "время добавления",
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `msg_id` (`msg_id`),
			  KEY `user_id` (`user_id`),
			  KEY `user_id_2` (`user_id`),
			  KEY `user_id_3` (`user_id`),
			  KEY `dialog_id` (`dialog_id`),
			  KEY `dialog_id_2` (`dialog_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;		
		');	
	}

	public function down()
	{
		echo "m141003_095022_dialogs_msg_to_user does not support migration down.\n";
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