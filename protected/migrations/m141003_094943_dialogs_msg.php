<?php

class m141003_094943_dialogs_msg extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Table structure for table `dialogs_msg`
			--

			CREATE TABLE IF NOT EXISTS `dialogs_msg` (
			  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT `id`,
			  `text` text NOT NULL COMMENT `текст сообщения`,
			  `add_time` int(11) NOT NULL COMMENT `время добавления`,
			  `user_id` int(11) unsigned NOT NULL COMMENT `отправитель`,
			  `dialog_id` int(11) NOT NULL COMMENT `id диалога`,
			  `for` varchar(255) NOT NULL COMMENT `for: all, me, group`,
			  `edit_time` int(11) NOT NULL COMMENT `время редактирования`,
			  `delete_time` int(11) NOT NULL COMMENT `время удаления`,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `dialog_id` (`dialog_id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		');	
	}

	public function down()
	{
		echo "m141003_094943_dialogs_msg does not support migration down.\n";
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