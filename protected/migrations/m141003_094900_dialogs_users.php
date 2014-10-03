<?php

class m141003_094900_dialogs_users extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Table structure for table `dialogs_users`
			--

			CREATE TABLE IF NOT EXISTS `dialogs_users` (
			  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT `id`,
			  `user_id` int(11) unsigned NOT NULL COMMENT `id пользователя`,
			  `dialog_id` int(11) NOT NULL COMMENT `id диалога`,
			  `name` varchar(255) NOT NULL COMMENT `название диалога у пользователя`,
			  `add_time` int(11) NOT NULL COMMENT `время добавления в диалог`,
			  `delete_time` int(11) NOT NULL COMMENT `время удаления (если удалил кто-то)`,
			  `delete_last_time` int(11) NOT NULL COMMENT `time last delete`,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `dialog_id` (`dialog_id`),
			  KEY `dialog_id_2` (`dialog_id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;	
		');	
	}

	public function down()
	{
		echo "m141003_094900_dialogs_users does not support migration down.\n";
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