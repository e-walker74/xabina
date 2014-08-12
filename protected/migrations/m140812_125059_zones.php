<?php

class m140812_125059_zones extends CDbMigration
{
	public function up()
	{
        $this->execute("
          ALTER TABLE `zone`
            ADD COLUMN `offset`  varchar(10) NOT NULL AFTER `zone_name`,
            ADD COLUMN `offset_time`  int(11) NOT NULL AFTER `offset`;
        ");
	}

	public function down()
	{

        return $this->execute("
          ALTER TABLE `zone`
            DROP COLUMN `offset`,
            DROP COLUMN `offset_time`;
        ");
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