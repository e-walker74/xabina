<?php

class m140908_111624_accounts extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `accounts`
            MODIFY COLUMN `number`  bigint(12) UNSIGNED ZEROFILL NOT NULL AFTER `id`,
            ADD COLUMN `prefix`  enum(\'mca\',\'ba\') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'mca\' COMMENT \'ba - basic account, mca - multicurrency account\' AFTER `id`,
            DROP INDEX `number`,
            ADD UNIQUE INDEX `number` USING BTREE (`number`, `currency_id`),
            ADD COLUMN `sub_type`  enum(\'personal\',\'anonymous\') NOT NULL DEFAULT \'personal\' AFTER `type_id`,
            MODIFY COLUMN `status`  tinyint(4) UNSIGNED NOT NULL DEFAULT 0 AFTER `user_id`,
            ADD COLUMN `basic`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 AFTER `status`,
            ADD COLUMN `status_comment`  varchar(255) NULL AFTER `status`,
            ADD COLUMN `credit_facility`  double(11,0) UNSIGNED NOT NULL DEFAULT 0 AFTER `name`;

        ');

        $this->execute('CREATE TABLE `accounts_names` (
            `id`  int(11) NOT NULL AUTO_INCREMENT ,
            `user_id`  int(11) UNSIGNED NULL ,
            `name`  varchar(255) NOT NULL ,
            `lang`  varchar(2) NOT NULL ,
            PRIMARY KEY (`id`)
            );');
	}

	public function down()
	{
		echo "m140908_111624_accounts does not support migration down.\n";
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