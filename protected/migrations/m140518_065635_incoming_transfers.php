<?php

class m140518_065635_incoming_transfers extends CDbMigration
{
	public function up()
	{
		$this->execute('
			CREATE TABLE IF NOT EXISTS `transfers_incoming` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `form_type` varchar(10) NOT NULL,
			  `amount` float NOT NULL,
			  `to_account_number` bigint(12) NOT NULL,
			  `to_account_id` int(11) NOT NULL,
			  `currency_id` int(11) NOT NULL,
			  `from_account_number` varchar(255) NOT NULL,
			  `electronic_method` tinyint(1) NOT NULL,
			  `from_account_holder` varchar(255) NOT NULL,
			  `card_type` tinyint(1) NOT NULL,
			  `p_month` int(2) DEFAULT NULL,
			  `p_year` int(4) DEFAULT NULL,
			  `p_csc` int(3) DEFAULT NULL,
			  `description` text NOT NULL,
			  `charges` tinyint(1) NOT NULL,
			  `urgent` tinyint(1) NOT NULL,
			  `counter_agent` int(11) NOT NULL,
			  `tag1` varchar(255) NOT NULL,
			  `tag2` varchar(255) NOT NULL,
			  `tag3` varchar(255) NOT NULL,
			  `category_id` int(11) NOT NULL,
			  `need_confirm` int(11) NOT NULL,
			  `favorite` int(11) NOT NULL,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

		');
		
		$this->execute('
			CREATE TABLE IF NOT EXISTS `transfers_incoming_favorite` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `form_type` varchar(10) NOT NULL,
			  `amount` float NOT NULL,
			  `to_account_number` bigint(12) NOT NULL,
			  `to_account_id` int(11) NOT NULL,
			  `currency_id` int(11) NOT NULL,
			  `from_account_number` varchar(255) NOT NULL,
			  `electronic_method` tinyint(1) NOT NULL,
			  `from_account_holder` varchar(255) NOT NULL,
			  `card_type` tinyint(1) NOT NULL,
			  `p_month` int(2) DEFAULT NULL,
			  `p_year` int(4) DEFAULT NULL,
			  `p_csc` int(3) DEFAULT NULL,
			  `description` text NOT NULL,
			  `charges` tinyint(1) NOT NULL,
			  `urgent` tinyint(1) NOT NULL,
			  `counter_agent` int(11) NOT NULL,
			  `tag1` varchar(255) NOT NULL,
			  `tag2` varchar(255) NOT NULL,
			  `tag3` varchar(255) NOT NULL,
			  `category_id` int(11) NOT NULL,
			  `need_confirm` int(11) NOT NULL,
			  `created_at` int(11) NOT NULL,
			  `updated_at` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		');
		
		$this->execute("
			ALTER TABLE `transactions` ADD `transfer_type` ENUM('incoming','outgoing') NULL DEFAULT NULL AFTER `user_id`;
		");
		$this->execute("
			ALTER TABLE `transactions` ADD `transfer_id` INT(11) UNSIGNED NULL 
DEFAULT NULL AFTER `transfer_type`;
		");
		
		$this->execute("
			ALTER TABLE `transactions` CHANGE `sum` `sum` FLOAT UNSIGNED NOT NULL;
		");
		
		$this->execute("
			ALTER TABLE `transactions` ADD `info_id` INT NOT NULL AFTER `id`;
		");
		
		$this->execute("
			ALTER TABLE `transactions` CHANGE `acc_balance` `acc_balance` FLOAT UNSIGNED NOT NULL;
		");
		
		$this->execute("
			ALTER TABLE `transactions_info` DROP `date`;
		");
	}

	public function down()
	{
		echo "m140516_065635_delete_account_number does not support migration down.\n";
		return false;
	}
}
