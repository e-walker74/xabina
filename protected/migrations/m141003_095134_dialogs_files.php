<?php

class m141003_095134_dialogs_files extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Table structure for table `dialogs_files`
			--

			CREATE TABLE IF NOT EXISTS `dialogs_files` (
			  `id` int(11) NOT NULL COMMENT `id`,
			  `msg_id` int(11) NOT NULL COMMENT `id сообщения`,
			  `user_id` int(11) unsigned NOT NULL COMMENT `id пользователя`,
			  `name` varchar(255) CHARACTER SET cp1251 NOT NULL COMMENT `имя файла`,
			  `url` varchar(255) CHARACTER SET cp1251 NOT NULL COMMENT `путь до файла`,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  KEY `msg_id` (`msg_id`,`user_id`),
			  KEY `user_id` (`user_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		');	
	}

	public function down()
	{
		echo "m141003_095134_dialogs_files does not support migration down.\n";
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