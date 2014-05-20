<?php

class m140516_091115_users_files extends CDbMigration
{
	public function up()
	{
		$this->execute('
            ALTER TABLE `users_files` ADD `model_id` INT NOT NULL AFTER `form`;');
	}

	public function down()
	{
		$this->execute('
            ALTER TABLE `users_files` DROP `model_id`;');
		return false;
	}
}