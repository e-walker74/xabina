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
            DROP TABLE transfers_outgoing_old;');
		$this->execute('
            ALTER TABLE `transfers_outgoing_favorite` DROP `favorite`;');
	}

	public function down()
	{
		echo "m140516_065635_delete_account_number does not support migration down.\n";
		return false;
	}
}