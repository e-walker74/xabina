<?php

class m140724_210519_online_user_status extends CDbMigration
{
    public function safeUp()
    {
        $this->execute('
            ALTER TABLE `users` ADD COLUMN activity_status tinyint(1);
        ');
    }

    public function safeDown()
    {
        $this->execute('
            ALTER TABLE `users` DROP COLUMN activity_status;
        ');

        return false;
    }
}