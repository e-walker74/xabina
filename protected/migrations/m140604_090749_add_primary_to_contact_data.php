<?php

class m140604_090749_add_primary_to_contact_data extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('users_contacts_data', 'is_primary', 'BOOLEAN NOT NULL DEFAULT FALSE');
	}

	public function down()
	{
		echo "m140604_090749_add_primary_to_contact_data does not support migration down.\n";
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