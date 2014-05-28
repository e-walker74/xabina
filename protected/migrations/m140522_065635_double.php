<?php

class m140522_065635_double extends CDbMigration
{
	public function up()
	{
		$this->execute('
			ALTER TABLE `transfers_outgoing_standing` CHANGE `amount` `amount` DOUBLE UNSIGNED NOT NULL;
			ALTER TABLE `transfers_incoming_favorite` CHANGE `amount` `amount` DOUBLE UNSIGNED NOT NULL;
			ALTER TABLE `transfers_incoming` CHANGE `amount` `amount` DOUBLE UNSIGNED NOT NULL;
			ALTER TABLE `transactions` CHANGE `sum` `sum` DOUBLE UNSIGNED NOT NULL;
			ALTER TABLE `accounts` CHANGE `balance` `balance` DOUBLE UNSIGNED NOT NULL;
			ALTER TABLE `transfers_outgoing_favorite` CHANGE `amount` `amount` DOUBLE UNSIGNED NOT NULL;
			ALTER TABLE `transfers_outgoing` CHANGE `amount` `amount` DOUBLE UNSIGNED NOT NULL;

		');
	}

	public function down()
	{
		echo "m140516_065635_delete_account_number does not support migration down.\n";
		return false;
	}
}