<?php

class m140827_124515_create_notify_tables extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `users_notifications` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `type` enum('promotion','information','warning','emergency','note') NOT NULL,
			  `code` varchar(30) NOT NULL,
			  `moderator_id` int(11) NOT NULL DEFAULT '0',
			  `manager_id` int(11) NOT NULL DEFAULT '0',
			  `title` varchar(255) NOT NULL DEFAULT '',
			  `announce` text NOT NULL,
			  `text` text,
			  `section` varchar(30) NOT NULL DEFAULT '',
			  `section_link` varchar(255) NOT NULL DEFAULT '',
			  `button` varchar(30) NOT NULL DEFAULT '',
			  `button_link` varchar(255) NOT NULL DEFAULT '',
			  `published_at` int(11) NOT NULL,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `users_notifications_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `notification_id` int(11) NOT NULL,
  `status` enum('new','see','hidden','done') NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `pinned` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


			");
	}

	public function down()
	{
		echo "m140827_124515_create_notify_tables does not support migration down.\n";
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