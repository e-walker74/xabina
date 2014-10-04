<?php

class m141003_095150_dialogs_comet extends CDbMigration
{
	public function up()
	{
		$this->execute('
			--
			-- Table structure for table `dialogs_comet`
			--

			CREATE TABLE IF NOT EXISTS `dialogs_comet` (
			  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT "id",
			  `add_time` int(11) NOT NULL COMMENT "время добавления",
			  `type` varchar(255) CHARACTER SET cp1251 NOT NULL COMMENT "тип  (наппример, сообщение в диалогах - msg)",
			  `type_id` int(11) NOT NULL COMMENT "id типа (например, id сообщения в диалогах)",
			  `params` text NOT NULL COMMENT "Other params",
			  `author_id` int(11) unsigned NOT NULL,
			  `user_id` int(11) unsigned NOT NULL COMMENT "кому",
			  `create_at` int(11) NOT NULL,
			  `update_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `user_id` (`user_id`),
			  KEY `user_id_2` (`user_id`),
			  KEY `author_id` (`author_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		');	
	}

	public function down()
	{
		echo "m141003_095150_dialogs_comet does not support migration down.\n";
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