<?php

class m140813_151003_newpin extends CDbMigration
{
	public function up()
	{
        $this->execute("
          INSERT INTO `mail_templates` (`code`) VALUES ('newPin');
          UPDATE `mail_templates` SET `fromName`='XABINA', `template`='newPin.txt', `params`='{:pass},{:date}' WHERE (`id`='15');

          INSERT INTO `mail_templates` (`code`, `sender`, `subject`, `fromName`, `template`) VALUES ('new_user_id', 'noreply@xabina.intwall.com', 'XABINA', 'XABINA', 'new_user_id.txt');

        ");

	}

	public function down()
	{
		echo "m140813_151003_newpin does not support migration down.\n";
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