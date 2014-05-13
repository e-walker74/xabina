<?php
/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:03
 */

class Admin_Transfers_Own extends Admin_Transfers{

    public function createOutgoingTransaction(Transfers_Outgoing $model){

        $trans_from = new Transactions;
        $trans_to = new Transactions;
        $info_from = new Transactions_Info;
        $info_to = new Transactions_Info;

        $model->user_id; //from user
        $model->account_id; //from account_id
        $model->status = 1; //set ok!
        $model->amount; //
        $model->currency_id; //
        $model->account_number; //from account_number
        $model->to_account_number; //to account number
        $model->description;
        $model->urgent;
        $model->frequency_type;
        $model->execution_date;
        $model->remaining_balance;
        $model->start_date;
        $model->end_date;
        $model->each_period;
        $model->period;
        $model->counter_agent;
        $model->tag1;
        $model->tag2;
        $model->tag3;
        $model->category_id;

        d($model);
        die;

        $trans_from->account_id = $model->account_id;
        $trans_from->operation = $model->description;
        $trans_from->type = 'negative';
        $trans_from->sum = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
        $trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
        $info_from->date = date('m.d.Y', time());
        $info_from->type = 'OV';
        $info_from->value = $model->amount . ' ' . $model->currency->code;
        $info_from->bic = 'n/a';
        $info_from->data_bank = 'n/a';
        $info_from->sender = $model->user->fullName;
        $info_from->details_of_payment = 'n/a';
        $info_from->status = 'processed OK';

        $account_to = Accounts::model()->findByPk($model->own_account_id);
        $account_from = $model->account;
        $account_from->balance = $trans_from->acc_balance;
        $info_from->sender_account_number = $account_from->number;

        $info_from->recipient = $account_to->user->fullName;
        $info_from->recipient_account = $account_to->number;
        $info_from->recipient_bic = 'n/a';
        $info_from->charges = $model->charges;
        $info_from->urgent = ($model->urgent) ? 'Yes' : 'No';


        $account_to = Accounts::model()->findByPk($model->own_account_id);
        $trans_to->account_id = $model->own_account_id;
        $trans_to->operation = $model->description;
        $trans_to->type = 'positive';
        $trans_to->sum = Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code);
        $trans_to->acc_balance = ($account_to->balance + Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code));
        $info_to->date = date('m.d.Y', time());
        $info_to->type = 'OV';
        $info_to->value = $model->amount . ' ' . $model->currency->code;
        $info_to->bic = 'n/a';
        $info_to->data_bank = 'n/a';
        $info_to->sender = $model->user->fullName;
        $info_to->details_of_payment = 'n/a';
        $info_to->status = 'processed OK';
        $info_to->sender_account_number = $account_from->number;
        $info_to->recipient = $account_to->user->fullName;
        $info_to->recipient_account = $account_to->number;
        $info_to->recipient_bic = 'n/a';
        $info_to->charges = $model->charges;
        $info_to->urgent = ($model->urgent) ? 'Yes' : 'No';
        $account_to->balance = $trans_to->acc_balance;

        $trans_from->validate();
        $info_from->validate();
        $trans_to->validate();
        $info_to->validate();

        $return = true;
        $transaction = Yii::app()->db->beginTransaction();
        if($trans_from->save() && $trans_to->save() && $model->save()){
            $info_from->transaction_id = $trans_from->id;
            $info_to->transaction_id = $trans_to->id;
            if($info_from->save()
                && $info_to->save()
                && $account_to->save()
                && $account_from->save()
            ){

                $transaction->commit();
                $return = false;
            }
        }
        if($return){
            $transaction->rollback();
        }
    }

    public function createInComingTransaction(){

    }

}