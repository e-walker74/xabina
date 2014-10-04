<?php

class m140827_120147_create_notify_files_table extends CDbMigration
{
	public function up()
	{
        $this->createTable("users_notifications_files", array(
            "id" => "pk",
            "notification_id" => "int not null",
            "file" => "string not null",
        ));

	}

	public function down()
	{
		$this->dropTable("users_notifications_files");
	}
}