<?php

class AlertCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $sql = 'insert into alerts_send_log (transaction_id)
          select t.id
            from transactions t
            left join alerts_send_log s on t.id=s.transaction_id
            where s.id is null and t.account_id in (
              select account_id
                from users_alerts_rules ar
                inner join alerts a on ar.alert_id = a.id
                where a.use_rules = 1 and ar.user_id = t.user_id
              )
        ';

        $cmd = Yii::app()->db->getCommandBuilder()->createSqlCommand($sql);
        $cmd->execute();

        $condition = new CDbCriteria();
        $condition->alias = 'ar';
        $condition->with = array(
            'user',
            'alert'=>array(
                'alias'=>'a',
                'joinType'=>'inner join'
            ),
            'transactions'=>array(
                'alias'=>'tr',
                'joinType'=>'inner join',
                'join' => 'inner join alerts_send_log s on tr.id=s.transaction_id'
            )
        );

        $condition->addCondition('s.end_send is null');
        $condition->addCondition('a.use_rules = 1');

        /** @var Users_AlertsRules[] $result */
        $result = Users_AlertsRules::model()->findAll($condition);

        if(count($result) == 0) {
            return 0;
        }

        foreach ($result as $key => $alertRules) {
            /** @var Transactions[] $transForSend */
            $transForSend = array();
            $sysMailCode  = '';
            switch($alertRules->alert->code) {
                case 'outgoingTransaction':
//                    break;
                case 'incomingTransaction':
                    $sysMailCode  = 'alert'.ucfirst($alertRules->alert->code);
                    foreach ($alertRules->transactions as $trans) {
                        $send = false;
                        if( $trans->transfer_type == str_replace('Transaction', '', $alertRules->alert->code) &&
                            (
                                ($alertRules->greater && $alertRules->greater <= $trans->sum) ||
                                ($alertRules->less && $alertRules->less >= $trans->sum) ||
                                ($alertRules->equal && $alertRules->equal == $trans->sum)
                            )) {
                            $send = true;
                        }
                        if($send) {
                            $transForSend[$trans->id] = $trans;
                        }
                    }
                break;
                case 'balance':
                    $sysMailCode  = 'alertBalance';
                    foreach ($alertRules->transactions as $trans) {
                        $send = false;
                        if( ($alertRules->greater && $alertRules->greater <= $trans->acc_balance) ||
                            ($alertRules->less && $alertRules->less >= $trans->acc_balance) ||
                            ($alertRules->equal && $alertRules->equal == $trans->acc_balance)
                        ) {
                            $send = true;
                        }
                        if($send) {
                            $transForSend[$trans->id] = $trans;
                        }
                    }
                    break;
            }
            Yii::app()->language = $alertRules->user->settings->language;
            foreach ($transForSend as $transId => $trans) {
                $criteria = new CDbCriteria();
                $criteria->alias = 't';
                $criteria->with = 'email';
                $criteria->condition = 't.alert_rule_id = :alert_id and t.user_id = :uid';
                $criteria->params[':uid'] = $alertRules->user_id;
                $criteria->params[':alert_id'] = $alertRules->id;
                // отправка на email
                /** @var Users_AlertsEmail[] $emails */
                $emails = Users_AlertsEmail::model()->findAll($criteria);
                $ruleName = 'UNKNOWN';
                if($alertRules->greater) {
                    $ruleName = 'greater';
                } elseif($alertRules->less) {
                    $ruleName = 'less';
                } elseif($alertRules->equal) {
                    $ruleName = 'equal';
                }

                foreach ($emails as $email) {
                    $mail = new Mail();
                    $mail->send(
                        $alertRules->user, // this user
                        $sysMailCode, // sys mail code
                        array( // params
                            '{:transactionID}' => $transId,
                            '{:transactionSum}' => $trans->sum,
                            '{:accountBalance}' => $trans->acc_balance,
                            '{:ruleName}' => $ruleName,
                            '{:ruleValue}' => $ruleName != 'UNKNOWN' ? $alertRules->{$ruleName} : 'UNKNOWN'
                        ),
                        $email->email->email
                    );
                }

                // отправка на телефон
                /** @var Users_AlertsPhone[] $phones */
                $criteria->with = 'phone';
                $phones = Users_AlertsPhone::model()->findAll($criteria);
                foreach ($phones as $phone) {
                    $params = array();
                    Yii::app()->sms->to($phone->phone->phone)->body($sysMailCode, $params)->send();
                    Yii::log('phone: '.$phone->phone->phone.'. code: '.$sysMailCode, CLogger::LEVEL_INFO, 'alert_sms');
                }
                $updateSQL = 'update alerts_send_log set end_send = current_timestamp where transaction_id = :transId';
                $cmd = Yii::app()->db->getCommandBuilder()->createSqlCommand($updateSQL);
                $cmd->bindParam(':transId', $transId);
                $cmd->execute();

            }
        }

    }

} 