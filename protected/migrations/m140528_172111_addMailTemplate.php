<?php

class m140528_172111_addMailTemplate extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->insert('mail_templates', array(
                'code' => 'alertBalance',
                'sender' => 'noreply@xabina.intwall.com',
                'subject' => 'XABINA',
                'fromName' => 'XABINA',
                'template' => 'alertBalance.txt',
                'params' => '{:transactionID},{:transactionSum},{:accountBalance},{:sender},{:ruleName},{:ruleValue}'
            ));
        $this->insert('mail_templates', array(
                'code' => 'alertOutgoingTransaction',
                'sender' => 'noreply@xabina.intwall.com',
                'subject' => 'XABINA',
                'fromName' => 'XABINA',
                'template' => 'alertOutgoingTransaction.txt',
                'params' => '{:transactionID},{:transactionSum},{:accountBalance},{:sender},{:ruleName},{:ruleValue}'
            ));
        $this->insert('mail_templates', array(
                'code' => 'alertIncomingTransaction',
                'sender' => 'noreply@xabina.intwall.com',
                'subject' => 'XABINA',
                'fromName' => 'XABINA',
                'template' => 'alertIncomingTransaction.txt',
                'params' => '{:transactionID},{:transactionSum},{:accountBalance},{:sender},{:ruleName},{:ruleValue}'
            ));
	}

	public function safeDown()
	{
        $this->delete('mail_templates', array('code' => 'alertBalance'));
        $this->delete('mail_templates', array('code' => 'alertOutgoingTransaction'));
        $this->delete('mail_templates', array('code' => 'alertIncomingTransaction'));
	}
}