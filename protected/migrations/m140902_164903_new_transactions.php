<?php

class m140902_164903_new_transactions extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `transactions`
ADD COLUMN `status`  enum(\'pending\',\'rejected\',\'approved\') NOT NULL DEFAULT \'pending\' AFTER `id`;

            ALTER TABLE `transactions_info`
ADD COLUMN `memo`  text NULL AFTER `details_of_payment`,
ADD COLUMN `status_comment`  text NULL AFTER `memo`;

            ALTER TABLE `transactions_info`
MODIFY COLUMN `sender`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT \'Admin can change this data, but transfer_outgoing or transfer_incoming have a data from user forms\' AFTER `type`,
MODIFY COLUMN `recipient`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT \'Admin can change this data, but transfer_outgoing or transfer_incoming have a data from user forms\' AFTER `sender`;

            DROP TRIGGER `transactions_UUID`;

            CREATE DEFINER=`root`@`%` TRIGGER `transactions_UUID` BEFORE INSERT ON `transactions`
            FOR EACH ROW begin
             SET NEW.url = UUID_SHORT();
            end;

            ALTER TABLE `transactions`
ADD COLUMN `execution_time`  int(11) UNSIGNED NULL AFTER `created_at`;

            ALTER TABLE `transactions_categories_links` ADD CONSTRAINT `fk_transaction_to_kat` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

            ALTER TABLE `transactions_categories_links` ADD CONSTRAINT `fk_transactions_category` FOREIGN KEY (`category_id`) REFERENCES `transactions_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;





        ');
	}

	public function down()
	{
		echo "m140902_164903_new_transactions does not support migration down.\n";
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