<?php
/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:03
 */

class Transfers_Model_Request extends Transfers_Model{

    public function createOutgoingTransaction(Transfers_Outgoing $model){

    }

    public function createInComingTransaction(Transfers_Incoming $model){
	
		$trans_to = new Transactions;
		
		$trans_to->account_id = $model->to_account_id;
		$trans_to->operation = $model->description;
		$trans_to->type = 'positive';
		$trans_to->user_id = $model->user_id;
		$trans_to->transfer_type = 'incoming';
		$trans_to->transfer_id = $model->id;
        $trans_to->incoming_id = $model->id;
		$trans_to->amount = Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code);
//		$trans_to->acc_balance = ($model->account->balance + Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
		
		$account_to = $model->account;
		
//		$account_to->balance = $trans_to->acc_balance;

		$info_trans = new Transactions_Info;
		$info_trans->sender = $model->getFromHolder();
		$info_trans->recipient = $model->user->fullname;
		$info_trans->value = $model->amount . ' ' . $model->currency->code;
		$info_trans->details_of_payment = $model->description;
		
		$transaction = Yii::app()->db->beginTransaction();
		
		if(!$info_trans->save()){
			$transaction->rollback();
			return false;
		}
		$trans_to->info_id = $info_trans->id;
		
		
		if($trans_to->save() && $model->save()){
			$transaction->commit();
            return true;
		} else {
			$transaction->rollback();
            return false;
		}
    }

}