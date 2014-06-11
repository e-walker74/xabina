<?php

class m140525_221610_update_alerts extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->truncateTable('alerts');

        // 'static' alerts
        $this->insert('alerts', array(
                'code' => 'news',
                'name' => 'News',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
                'required_account'=>0
            ));
        $this->insert('alerts', array(
                'code' => 'partner_marketing',
                'name' => 'Partner marketing',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
                'required_account'=>0
            ));
        $this->insert('alerts', array(
                'code' => 'development',
                'name' => 'Development',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
                'required_account'=>0
            ));
        $this->insert('alerts', array(
                'code' => 'policy_updates',
                'name' => 'Policy updates',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
                'required_account'=>0
            ));
        // end 'static' alerts

        $this->insert('alerts', array(
                'name'=>'Outgoing transaction',
                'code'=>'outgoingTransaction',
                'use_rules'=>1,
                'required_account'=>1
            ));
        $this->insert('alerts', array(
                'name'=>'Incoming transaction',
                'code'=>'incomingTransaction',
                'use_rules'=>1,
                'required_account'=>1
            ));
        $this->insert('alerts', array(
                'name'=>'Balance',
                'code'=>'balance',
                'use_rules'=>1,
                'required_account'=>1
            ));
        $this->insert('alerts', array(
                'name'=>'Monthly Summary',
                'code'=>'monthlySummary',
                'use_rules'=>0,
                'required_account'=>1
            ));
        $this->insert('alerts', array(
                'name'=>'Transaction rejected',
                'code'=>'transactionRejected',
                'use_rules'=>0,
                'required_account'=>1
            ));
        $this->insert('alerts', array(
                'name'=>'Transaction approved',
                'code'=>'transactionApproved',
                'use_rules'=>0,
                'required_account'=>1
            ));
	}

	public function safeDown()
	{
        echo 'transaction has no down method';
	}

}