<?php

class TransfersController extends Controller
{

	public function actionOutgoing(){
	
		//$model = //Transfers_Outgoing::model()->findAll('status = 0 AND need_confirm = 0');
		$model = new Transfers_Outgoing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transfers_Outgoing'])){
			$model->attributes=$_GET['Transfers_Outgoing'];
		}
		$this->render('outgoing', array('model' => $model));
	}
	
	public function actionUpdate($id){
		$model = Transfers_Outgoing::model()->findByPk($id);
		$this->render('update', array('model' => $model));
	}
	
	public function actionAuthorise($id){
		$model = Transfers_Outgoing::model()->findByPk($id);
		if(!$model->status && !$model->need_confirm){
			$model->status = 1;
			if($model->send_to == "own"){
				$trans_from = new Transactions;
				$trans_to = new Transactions;
				$info_from = new Transactions_Info;
				$info_to = new Transactions_Info;
				
				
				$trans_from->account_id = $model->account_id;
				$trans_from->operation = $model->description;
				$trans_from->type = 'negative';
				$trans_from->sum = $model->amount;
				$trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
				$info_from->date = date('m.d.Y', time());
				$info_from->type = 'OV';
				$info_from->value = $model->amount . ' ' . $model->currency->code;
				$info_from->bic = 'n/a';
				$info_from->data_bank = 'n/a';
				$info_from->sender = $model->user->fullName;
				$info_from->details_of_payment = 'n/a';
				$account_from = $model->account;
				$account_from->balance = $trans_from->acc_balance;
				
				$account_to = Accounts::model()->findByPk($model->own_account_id);
				$trans_to->account_id = $model->own_account_id;
				$trans_to->operation = $model->description;
				$trans_to->type = 'positive';
				$trans_to->sum = $model->amount;
				$trans_to->acc_balance = ($account_to->balance + Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code));
				$info_to->date = date('m.d.Y', time());
				$info_to->type = 'OV';
				$info_to->value = $model->amount . ' ' . $model->currency->code;
				$info_to->bic = 'n/a';
				$info_to->data_bank = 'n/a';
				$info_to->sender = $model->user->fullName;
				$info_to->details_of_payment = 'n/a';
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
				
				/*d($model->getErrors());
				d($trans_from->getErrors());
				d($trans_to->getErrors());
				d($info_from->getErrors());
				d($info_to->getErrors());
				die();*/
			} elseif($model->send_to == "xabina"){
				$trans_from = new Transactions;
				$trans_to = new Transactions;
				$info_from = new Transactions_Info;
				$info_to = new Transactions_Info;
				
				
				$account_to = Accounts::model()->find('number = :numb', array(':numb' => $model->account_number));
				if(!$account_to){
					$this->redirect(array('/admin/transfers/outgoing'));
					Yii::app()->end();
				}
				
				
				$trans_from->account_id = $model->account_id;
				$trans_from->operation = $model->description;
				$trans_from->type = 'negative';
				$trans_from->sum = $model->amount;
				$trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
				$info_from->date = date('m.d.Y', time());
				$info_from->type = 'OV';
				$info_from->value = $model->amount . ' ' . $model->currency->code;
				$info_from->bic = 'n/a';
				$info_from->data_bank = 'n/a';
				$info_from->sender = $model->user->fullName;
				$info_from->details_of_payment = 'n/a';
				$account_from = $model->account;
				$account_from->balance = $trans_from->acc_balance;
				
				//$account_to = Accounts::model()->find('number = :numb', array(':numb' => $model->account_number));
				$trans_to->account_id = $account_to->id;
				$trans_to->operation = $model->description;
				$trans_to->type = 'positive';
				$trans_to->sum = $model->amount;
				$trans_to->acc_balance = ($account_to->balance + Currencies::convert($model->amount, $model->currency->code, $account_to->currency->code));
				$info_to->date = date('m.d.Y', time());
				$info_to->type = 'OV';
				$info_to->value = $model->amount . ' ' . $model->currency->code;
				$info_to->bic = 'n/a';
				$info_to->data_bank = 'n/a';
				$info_to->sender = $model->user->fullName;
				$info_to->details_of_payment = 'n/a';
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
			} elseif($model->send_to == "external"){
				$trans_from = new Transactions;
				$trans_to = new Transactions;
				$info_from = new Transactions_Info;
				$info_to = new Transactions_Info;
				
				$trans_from->account_id = $model->account_id;
				$trans_from->operation = $model->description;
				$trans_from->type = 'negative';
				$trans_from->sum = $model->amount;
				$trans_from->acc_balance = ($model->account->balance - Currencies::convert($model->amount, $model->currency->code, $model->account->currency->code));
				$info_from->date = date('m.d.Y', time());
				$info_from->type = 'OV';
				$info_from->value = $model->amount . ' ' . $model->currency->code;
				$info_from->bic = $model->swift;
				$info_from->data_bank = $model->bank_beneficiary;
				$info_from->sender = $model->user->fullName;
				$info_from->details_of_payment = $model->description;
				$account_from = $model->account;
				$account_from->balance = $trans_from->acc_balance;
				
				$return = true;
				$transaction = Yii::app()->db->beginTransaction();
				if($trans_from->save() && $model->save()){
					$info_from->transaction_id = $trans_from->id;
					if($info_from->save() 
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
			$this->redirect(array('/admin/transfers/outgoing'));
			Yii::app()->end();
		}
		$this->redirect(array('/admin/transfers/outgoing'));
			Yii::app()->end();
	}
	
	public function actionCreate(){
		
		$model = new Transactions('admin');
		$info = new Transactions_Info('admin');
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'transfer-form') {
            $validate = CActiveForm::validate($model);
			$validateInfo = CActiveForm::validate($info);
			if($validate != '[]'){
				echo $validate;
			} elseif($validateInfo != '[]'){
				echo $validateInfo;
			} else {
				echo '[]';
			}
            Yii::app()->end();
        }
		
		if(isset($_POST['Transactions'])){ 
			$toAcc = Accounts::model()->find('number = :num', array(':num' => $_POST['Transactions']['account_number']));
			$model->attributes = $_POST['Transactions'];
			$info->attributes = $_POST['Transactions_Info'];
			if($model->type == 'positive'){
				$model->acc_balance = $toAcc->balance + $model->sum;
			} else {
				$model->acc_balance = $toAcc->balance - $model->sum;
			}
			$toAcc->balance = $model->acc_balance;
			$model->account_id = $toAcc->id;
			
			//$info->transaction_id = $model->id;
			$info->date = date('m.d.Y', time());
			$info->value = $model->sum . ' ' . $toAcc->currency->code;
			
			if($model->validate() && $info->validate()){
				$transaction = Yii::app()->db->beginTransaction();
				$ret = false;
				if($model->save()){
					$info->transaction_id = $model->id;
					if($info->save() && $toAcc->save()){
						$transaction->commit();
					} else {
						$ret = true;
					}
				} else {
					$ret = true;	
				}
				if($ret){
					$transaction->rollback();
				}
				
				$this->redirect(array('/admin/accounts/index/'));
			} else {
				dd($model->getErrors());
				dd($info->getErrors());
				die;
			}
		}
	
		$this->render('create', array('model' => $model, 'info' => $info));
	}
	
}
