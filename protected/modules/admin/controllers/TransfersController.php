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
	
	public function actionIncoming(){
	
		//$model = //Transfers_Outgoing::model()->findAll('status = 0 AND need_confirm = 0');
		$model = new Transfers_Incoming('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transfers_Incoming'])){
			$model->attributes=$_GET['Transfers_Incoming'];
		}
		$this->render('incoming', array('model' => $model));
	}
	
	public function actionUpdateInc($id){
		$model = Transfers_Incoming::model()->findByPk($id);
		$this->render('incoming/update', array('model' => $model));
	}
	
	public function actionUpdate($id){
		$model = Transfers_Outgoing::model()->findByPk($id);
		$this->render('update', array('model' => $model));
	}
	
	public function actionAuthorise($id){

        $model = Transfers_Outgoing::model()->findByPk($id);

        if(!$model->status && !$model->need_confirm){
            if(!$model->account->checkBalance($model->amount, $model->currency_id)){
                die('Not enough money!');
            }
			
			if(isset($_POST['action'])){
				switch($_POST['action']){
					case 'Authorise':
						$model->status = Transfers_Outgoing::APPROVED_STATUS;
						$admin_transfer = Admin_Transfers::model($model->form_type);
						$admin_transfer->createOutgoingTransaction($model);
						break;
					case 'Reject':
						$model->status = Transfers_Outgoing::REJECTED_STATUS;
						$model->save();
						break;
				}
			}
			
        }
			
		$this->redirect(array('/admin/transfers/outgoing'));
			Yii::app()->end();
	}
	
	public function actionAuthoriseInc($id){

        $model = Transfers_Incoming::model()->findByPk($id);

        if(!$model->status){
			if(isset($_POST['action'])){
				switch($_POST['action']){
					case 'Authorise':
						$model->status = Transfers_Incoming::APPROVED_STATUS;
						$admin_transfer = Admin_Transfers::model($model->form_type);
						$admin_transfer->createIncomingTransaction($model);
						break;
					case 'Reject':
						$model->status = Transfers_Incoming::REJECTED_STATUS;
						$model->save();
						break;
				}
			}
        }
			
		$this->redirect(array('/admin/transfers/incoming'));
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
