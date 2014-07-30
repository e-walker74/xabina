<?php

class m140623_111819_alerts_fk extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `users_alerts_email`
            ADD CONSTRAINT `fk_user_email`
            FOREIGN KEY (`email_id`) REFERENCES `users_emails` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ');
        $this->execute('ALTER TABLE `users_alerts_phone`
          ADD CONSTRAINT `fk_users_phone`
          FOREIGN KEY (`phone_id`) REFERENCES `users_phones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ');
	}

	public function down()
	{
		echo "m140623_111819_alerts_fk does not support migration down.\n";
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