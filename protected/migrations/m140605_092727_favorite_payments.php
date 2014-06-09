<?php

class m140605_092727_favorite_payments extends CDbMigration
{
	public function up()
	{
        $this->execute('
            CREATE TABLE `users_payment_instruments` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `status` tinyint(1) NOT NULL,
              `from_account_number` varchar(255) NOT NULL,
              `from_account_holder` varchar(255) NOT NULL,
              `electronic_method` tinyint(1) NOT NULL,
              `card_type` tinyint(1) NOT NULL,
              `p_month` int(2) DEFAULT NULL,
              `p_year` int(4) DEFAULT NULL,
              `p_csc` int(3) DEFAULT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
        ');
	}

	public function down()
	{
        $this->execute('
            DROP TABLE IF EXISTS `users_payment_instruments`;
        ');
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