<?php

class m140527_210309_alerts_send_log extends CDbMigration
{

	public function safeUp()
	{
        $this->createTable('alerts_send_log', array(
                'id' => 'pk',
                'transaction_id' => 'char(36) not null',
                'start_send' => 'timestamp default current_timestamp',
                'end_send' => 'timestamp null default null'
            ), 'engine=innodb default charset=utf8');

        $this->addForeignKey('fk_alerts_send_log_transactions_transaction_id', 'alerts_send_log', 'transaction_id', 'transactions', 'id', 'cascade', 'cascade');
	}

	public function safeDown()
	{
        $this->dropTable('alerts_send_log');
	}

}