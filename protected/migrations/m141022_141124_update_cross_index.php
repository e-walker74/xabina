<?php

class m141022_141124_update_cross_index extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE  `admin_xabina_main`.`cross_links` DROP INDEX  `unique_cross_index` ,
ADD UNIQUE  `unique_cross_index` (  `link_table_id` ,  `entity_name` ,  `entity_id` ,  `link_table_name` ,  `user_id` );
        ');
	}

	public function down()
	{
		echo "m141022_141124_update_cross_index does not support migration down.\n";
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