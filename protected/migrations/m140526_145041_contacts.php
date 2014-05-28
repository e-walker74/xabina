<?php

class m140526_145041_contacts extends CDbMigration
{
	public function up()
	{
		$this->execute('
			CREATE TABLE IF NOT EXISTS `users_contacts` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `xabina_id` int(11) NOT NULL,
			  `fullname` varchar(60) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		');
		
		$this->execute('
			CREATE TABLE IF NOT EXISTS `users_contacts_data` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `contact_id` int(11) NOT NULL,
			  `data_type` varchar(30) NOT NULL,
			  `value` text NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		');
		
		/*$this->execute('
			ALTER TABLE `users_contacts` ADD INDEX `user` (`user_id`);
			ALTER TABLE `users_contacts_data` ADD INDEX `contact` (`contact_id`);
			ALTER TABLE `users_contacts` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
			ALTER TABLE `users_contacts_data` ADD FOREIGN KEY (`contact_id`) REFERENCES `users_contacts`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
		');*/
	}

	public function down()
	{
		echo "m140526_145041_contacts does not support migration down.\n";
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