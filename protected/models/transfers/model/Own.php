<?php
/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:03
 */

class Transfers_Model_Own extends Transfers_Model{

    public function createOutgoingTransaction(Transfers_Outgoing $model){

        $trans_from = new Transactions;
        $trans_to = new Transactions;

        $trans_from->account_id = $model->account_id;
		$trans_from->user_id = $model->user_id;
		$trans_from->transfer_type = 'outgoing';
		$trans_from->transfer_id = $model->id;
        $trans_from->outgoing_id = $model->id;
        $trans_from->operation = $model->description;
        $trans_from->type = 'negative';
        $trans_from->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
//        $trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
        /* TODO::right check balance */

        $account_to = Accounts::model()->find('number = :num', array(':num' => $model->to_account_number));
        
		$account_from = $model->account;
//        $account_from->balance = $trans_from->acc_balance;

        $trans_to->account_id = $account_to->id;
        $trans_to->operation = $model->description;
        $trans_to->type = 'positive';
		$trans_to->user_id = $model->user_id;
		$trans_to->transfer_type = 'outgoing';
		$trans_to->transfer_id = $model->id;
        $trans_to->outgoing_id = $model->id;
        $trans_to->amount = Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code);
//        $trans_to->acc_balance = ($account_to->balance + Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code));
        
//        $account_to->balance = $trans_to->acc_balance;

        $trans_from->validate();
        $trans_to->validate();
		
		$info_trans = new Transactions_Info;
		$info_trans->sender = $model->user->fullname;
		$info_trans->recipient = $model->getToAccountHolder();
		$info_trans->value = $model->amount . ' ' . $model->currency->code;
		$info_trans->details_of_payment = $model->description;
		
		$transaction = Yii::app()->db->beginTransaction();
		
		if(!$info_trans->save()){
			$transaction->rollback();
			return false;
		}
		$trans_from->info_id = $info_trans->id;
		$trans_to->info_id = $info_trans->id;
		
		
        if($trans_from->save() && $trans_to->save() && $model->save()){
			$transaction->commit();
            return true;
        } else {
			$transaction->rollback();
            return false;
        }
    }

    public function createInComingTransaction(Transfers_Incoming $model){

    }

}