<?php

class m140929_062734_users_files_folder extends CDbMigration
{
	public function up()
	{
        $this->execute('
          ALTER TABLE `users_files`
          ADD COLUMN `parent_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `id`,
          ADD COLUMN `file_size`  int(11) NULL AFTER `description`;
        ');
	}

	public function down()
	{
		echo "m140929_062734_users_files_folder does not support migration down.\n";
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