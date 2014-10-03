<?php

class m141003_095122_dialogs_card extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Table structure for table `dialogs_card`
			--

			CREATE TABLE IF NOT EXISTS `dialogs_card` (
			  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT `id`,
			  `msg_id` int(11) NOT NULL COMMENT `id сообщения`,
			  `user_id` int(11) unsigned NOT NULL COMMENT `id отправилеля`,
			  `book_id` int(11) unsigned NOT NULL COMMENT `id в адресной книге`,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `msg_id` (`msg_id`,`user_id`,`book_id`),
			  KEY `user_id` (`user_id`),
			  KEY `user_id_2` (`user_id`),
			  KEY `book_id` (`book_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		');	
	}

	public function down()
	{
		echo "m141003_095122_dialogs_card does not support migration down.\n";
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