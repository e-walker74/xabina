<?php

class m140525_221507_alter_alerts extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn('alerts', 'required_account', 'tinyint not null default 0');

        $this->createIndex('idx_alerts_code', 'alerts', 'code', true);
        $this->createIndex('idx_alerts_use_rules', 'alerts', 'use_rules', false);
        $this->createIndex('idx_alerts_required_account', 'alerts', 'required_account', false);
	}

	public function safeDown()
	{
        $this->dropColumn('alerts', 'required_account');

        $this->dropIndex('idx_alerts_code', 'alerts');
        $this->dropIndex('idx_alerts_use_rules', 'alerts');
        $this->dropIndex('idx_alerts_required_account', 'alerts');
	}

}