<?php
/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:03
 */

class Transfers_Model_External extends Transfers_Model{

    public function createOutgoingTransaction(Transfers_Outgoing $model){

        $trans_from = new Transactions;

		$trans_from->account_id = $model->account_id;
		$trans_from->operation = $model->description;
		$trans_from->type = 'negative';
		$trans_from->user_id = $model->user_id;
		$trans_from->transfer_type = 'outgoing';
		$trans_from->transfer_id = $model->id;
        $trans_from->outgoing_id = $model->id;
		$trans_from->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
//		$trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
		
		$account_from = $model->account;
//		$account_from->balance = $trans_from->acc_balance;
		
		$info_trans = new Transactions_Info;
		$info_trans->sender = $model->user->fullname;
        $info_trans->sender_description = number_format($model->account_number, 0, '.', ' ');
		$info_trans->recipient = $model->getToAccountHolder();
        $info_trans->recipient_description = $model->to_account_number;
		$info_trans->value = $model->amount . ' ' . $model->currency->code;
		$info_trans->details_of_payment = $model->description;
		
		$transaction = Yii::app()->db->beginTransaction();
		
		if(!$info_trans->save()){
			$transaction->rollback();
			return false;
		}
		$trans_from->info_id = $info_trans->id;
		
		
		if($trans_from->save() && $model->save()){
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