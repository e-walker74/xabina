<?php

class m140924_102135_users_tags extends CDbMigration
{
	public function up()
	{
        $this->execute('
            CREATE TABLE `users_tags` (
            `id`  int(11) NOT NULL AUTO_INCREMENT ,
            `user_id`  int(11) UNSIGNED NOT NULL ,
            `title`  varchar(255) NOT NULL ,
            PRIMARY KEY (`id`)
            )
            ;
        ');
	}

	public function down()
	{
		echo "m140924_102135_users_tags does not support migration down.\n";
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