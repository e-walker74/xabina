<?php

class m140530_013037_alterRules extends CDbMigration
{
	public function safeUp()
	{
        $this->alterColumn('users_alerts_rules', 'greater', 'double null default null');
        $this->alterColumn('users_alerts_rules', 'less', 'double null default null');
        $this->alterColumn('users_alerts_rules', 'equal', 'double null default null');
	}

	public function safeDown()
	{
        echo "m140528_195637_alterRules does not support migration down.\n";
        return false;
	}

}