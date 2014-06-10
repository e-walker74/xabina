<?php
/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:03
 */

class Admin_Transfers_External extends Admin_Transfers{

    public function createOutgoingTransaction(Transfers_Outgoing $model){

        $trans_from = new Transactions;
		
		$trans_from->account_id = $model->account_id;
		$trans_from->operation = $model->description;
		$trans_from->type = 'negative';
		$trans_from->user_id = $model->user_id;
		$trans_from->transfer_type = 'outgoing';
		$trans_from->transfer_id = $model->id;
		$trans_from->sum = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
		$trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
		
		$account_from = $model->account;
		$account_from->balance = $trans_from->acc_balance;
		
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
		
		
		if($trans_from->save() && $model->save() && $account_from->save()){
			$transaction->commit();
		} else {
			$transaction->rollback();
		}
    }

    public function createInComingTransaction(Transfers_Incoming $model){

    }

}