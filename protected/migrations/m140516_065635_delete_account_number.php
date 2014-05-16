<?php

class m140516_065635_delete_account_number extends CDbMigration
{
	public function up()
	{
		$this->execute('
            DROP TABLE transactions_info;');
		$this->execute('
            DROP TABLE transactions_info_attachments;');
		$this->execute('
            ALTER TABLE `transfers_outgoing` DROP `account_id`;');
		$this->execute('
            ALTER TABLE `transfers_outgoing_favorite` DROP `account_id`;');
		$this->execute('
            DROP TABLE transfers_outgoing_old;');
		$this->execute('
            ALTER TABLE `accounts` ADD PRIMARY KEY(`number`);');
		$this->execute('
            ALTER TABLE  `transactions` CHANGE  `account_id`  `account_id` BIGINT( 12 ) UNSIGNED ZEROFILL NOT NULL;');
		$this->execute('
            ALTER TABLE `transfers_outgoing_favorite` DROP `favorite`;');
		$this->execute('
            UPDATE transactions SET account_id = 487552202375 WHERE account_id = 3');
		$this->execute('
            UPDATE transactions SET account_id = 487552202474 WHERE account_id = 5');
	}

	public function down()
	{
		echo "m140516_065635_delete_account_number does not support migration down.\n";
		return false;
	}
}