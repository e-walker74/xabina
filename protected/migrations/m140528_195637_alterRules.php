<?php

class m140528_195637_alterRules extends CDbMigration
{
	public function safeUp()
	{
        $this->alterColumn('users_alerts_rules', 'greater', 'float null default null');
        $this->alterColumn('users_alerts_rules', 'less', 'float null default null');
        $this->alterColumn('users_alerts_rules', 'equal', 'float null default null');
	}

	public function safeDown()
	{
        echo "m140528_195637_alterRules does not support migration down.\n";
        return false;
	}

}