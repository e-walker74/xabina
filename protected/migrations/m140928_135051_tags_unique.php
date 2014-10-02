<?php

class m140928_135051_tags_unique extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `cross_links`
            ADD UNIQUE INDEX `unique_cross_index`
            USING BTREE (`link_table_id`, `entity_name`, `entity_id`, `link_table_name`) ;
        ');
	}

	public function down()
	{
		echo "m140928_135051_tags_unique does not support migration down.\n";
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