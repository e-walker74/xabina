<?php

class m140609_130229_alter_users_payment_instruments extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `users_payment_instruments` ADD COLUMN deleted tinyint(1);
        ');
	}

	public function down()
	{
	    $this->execute('
            ALTER TABLE `users_payment_instruments` DROP COLUMN deleted;
        ');

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