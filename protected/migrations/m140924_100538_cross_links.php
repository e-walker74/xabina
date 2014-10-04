<?php

class m140924_100538_cross_links extends CDbMigration
{
	public function up()
	{
        $this->execute('
            CREATE TABLE `cross_links` (
            `id`  int(11) NOT NULL AUTO_INCREMENT,
            `user_id`  int(11) NOT NULL ,
            `entity_name`  varchar(255) NOT NULL ,
            `entity_id`  int(11) NOT NULL ,
            `link_table_name`  varchar(255) NOT NULL ,
            `link_table_id`  int(11) NOT NULL ,
            `category_id`  int(11) NULL ,
            `comment`  varchar(255) NULL ,
            PRIMARY KEY (`id`)
            )
            ;
        ');

        $this->execute('
            ALTER TABLE `cross_links`
            MODIFY COLUMN `user_id`  int(11) UNSIGNED NOT NULL AFTER `id`;

            ALTER TABLE `cross_links` ADD CONSTRAINT `fk_cross_link_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ');
	}

	public function down()
	{
		echo "m140924_100538_cross_links does not support migration down.\n";
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