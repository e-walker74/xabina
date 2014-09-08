<?php

/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:08
 */
abstract class Admin_Transfers extends CModel
{

    public $account_id;
    public $user_id; //user, who initiated the transfer
    public $operation;
    public $type;
    public $sum;
    public $acc_balance;
    public $info_date; //Transaction_Info.date = created_at TIME FIELD
    public $info_type; //default OV - i don`t not what is it
    public $info_sender_name; //sender
    public $info_sender_account_number;
    public $info_sender_bic;
    public $info_detail_of_payment;

//    abstract public function approveOutgoingTransaction(Transfers_Outgoing $transfer);
//
//    abstract public function rejectOutgoingTransaction(Transfers_Outgoing $model);
//
//    abstract public function approveIncomingTransaction(Transfers_Incoming $transfer);
//
//    abstract public function rejectIncomingTransaction(Transfers_Incoming $model);

    public function rejectTransaction(Transfers_Outgoing $model)
    {

        $dbTransaction = Yii::app()->db->beginTransaction();

        if (empty($model->transactions)) {
            throw new CHttpException(404, 'Страница не найдена');
            return false;
        }

        foreach ($model->transactions as $transaction) {
            $transaction->status = Transactions::STATUS_REJECTED;
            if (isset($_POST['Transactions_Info'])) {
                $transaction->info->attributes = $_POST['Transactions_Info'];
            }
            if (!$transaction->save() || !$transaction->info->save()) {
                $dbTransaction->rollback();
                return false;
            }
        }

        if ($model->save()) {
            $dbTransaction->commit();
            return true;
        }
        $dbTransaction->rollback();
        return false;
    }

    public function approveOutgoingTransaction(Transfers_Outgoing $model)
    {
        if (empty($model->transactions)) {
            throw new CHttpException(404, 'Страница не найдена');
            return false;
        }

        $dbTransaction = Yii::app()->db->beginTransaction();

        foreach ($model->transactions as $transaction) {
            $transaction->status = Transactions::STATUS_APPROVED;
            $transaction->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
            $transaction->execution_time = time();

            if ($transaction->type == 'positive') {

                $account_to = Accounts::model()->find('number = :num', array(':num' => $model->to_account_number));

                $transaction->amount = Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code);

                $model->account->balance += Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);

                if(!$account_to->save()){
                    $dbTransaction->rollback();
                    return false;
                }

            } elseif ($transaction->type == 'negative') {
                $transaction->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);

                $model->account->balance -= Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
            }

            $transaction->acc_balance = $model->account->balance;
            if (isset($_POST['Transactions_Info'])) {
                foreach ($_POST['Transactions_Info'] as $attr => $value) {
                    if ($value) {
                        $transaction->info->$attr = $_POST['Transactions_Info'][$attr];
                    }
                }
            }


            if (!$transaction->save() || !$transaction->info->save() || !$model->account->save()) {
                $dbTransaction->rollback();
                return false;
            }
        }

        if ($model->save()) {
            $dbTransaction->commit();
            return true;
        }
        $dbTransaction->rollback();
        return false;
    }

    public function approveIncomingTransaction(Transfers_Incoming $model){

        if (empty($model->transactions)) {
            throw new CHttpException(404, 'Страница не найдена');
            return false;
        }

        $dbTransaction = Yii::app()->db->beginTransaction();

        foreach ($model->transactions as $transaction) {
            $transaction->status = Transactions::STATUS_APPROVED;
            $transaction->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
            $transaction->execution_time = time();

            if ($transaction->type == 'positive') {

                $transaction->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
                $model->account->balance += $transaction->amount;

                $transaction->acc_balance = $model->account->balance;
            }

            $transaction->acc_balance = $model->account->balance;
            if (isset($_POST['Transactions_Info'])) {
                foreach ($_POST['Transactions_Info'] as $attr => $value) {
                    if ($value) {
                        $transaction->info->$attr = $_POST['Transactions_Info'][$attr];
                    }
                }
            }

            if (!$transaction->save() || !$transaction->info->save() || !$model->account->save()) {
                $dbTransaction->rollback();
                return false;
            }
        }

        if ($model->save()) {
            $dbTransaction->commit();
            return true;
        }
        $dbTransaction->rollback();
        return false;

    }

    public function attributeNames()
    {
        return array();
    }

    public static function model($className = __CLASS__)
    {
        if ($className != __CLASS__) {
            $className = __CLASS__ . '_' . $className;
        }
        return new $className;
    }

}