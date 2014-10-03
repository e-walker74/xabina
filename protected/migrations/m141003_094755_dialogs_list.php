<?php

class m141003_094755_dialogs_list extends CDbMigration
{
	public function up()
	{
		$this->execute('
		--
		-- Table structure for table `dialogs_users`
		--
		CREATE TABLE IF NOT EXISTS `dialogs_list` (
		  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT `id`,
		  `type` varchar(255) NOT NULL COMMENT `тип диалога`,
		  `type_id` int(11) NOT NULL COMMENT `id привязки типа`,
		  `type_url` varchar(255) NOT NULL COMMENT `url привязки типа`,
		  `user_id` int(11) unsigned NOT NULL COMMENT `id создателя`,
		  `add_time` int(11) NOT NULL COMMENT `время добавления`,
		  `name` varchar(255) DEFAULT NULL COMMENT `стандартное название`,
		  `created_at` int(11) NOT NULL,
		  `updated_at` int(11) NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `user_id` (`user_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT=`Список диалогов` AUTO_INCREMENT=1 ;				
		');	
	}

	public function down()
	{
		echo "m141003_094755_dialogs_list does not support migration down.\n";
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