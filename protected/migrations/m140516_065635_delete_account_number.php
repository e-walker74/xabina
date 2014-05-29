<?php

class m140516_065635_delete_account_number extends CDbMigration
{
	public function up()
	{
		$this->execute('
            DROP TABLE IF EXISTS transactions_info_attachments;');
		$this->execute('
            DROP TABLE IF EXISTS transfers_outgoing_old;');
	}

	public function down()
	{
		echo "m140516_065635_delete_account_number does not support migration down.\n";
		return false;
	}
}