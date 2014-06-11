<?php

class m140514_223113_alerts_data extends CDbMigration
{
	public function up()
	{
        $this->insert('alerts', array(
                'code' => 'news',
                'name' => 'News',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
            ));
        $this->insert('alerts', array(
                'code' => 'partner_marketing',
                'name' => 'Partner marketing',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
            ));
        $this->insert('alerts', array(
                'code' => 'development',
                'name' => 'Development',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
            ));
        $this->insert('alerts', array(
                'code' => 'policy_updates',
                'name' => 'Policy updates',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 0,
            ));
        $this->insert('alerts', array(
                'code' => 'incoming_transaction',
                'name' => 'Incoming transaction',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 1,
            ));
        $this->insert('alerts', array(
                'code' => 'outgoing_transaction',
                'name' => 'Outgoing transaction',
                'desc' => 'Узнайте новости и выгодные предложения банка',
                'use_rules' => 1,
            ));
	}

	public function down()
	{
        $this->delete('alerts', array('code' => 'news'));
        $this->delete('alerts', array('code' => 'partner_marketing'));
        $this->delete('alerts', array('code' => 'development'));
        $this->delete('alerts', array('code' => 'policy_updates'));
	}
}