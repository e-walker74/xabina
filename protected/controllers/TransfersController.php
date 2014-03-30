<?php

class TransfersController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
			array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array('outgoing', 'overview', 'delete', 'smsverivicaiton', 'smsconfirm', 'success'),
                'roles' => array('administrator')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }
	
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionOutgoing()
    {

		if(Yii::app()->user->role > Users::USER_IS_ACTIVATED){
			throw new CHttpException(403, Yii::t('Front', 'You have no permissions'));
		}
		$number = Yii::app()->request->getParam('account', '', 'int');
		$transfer = Yii::app()->request->getParam('transfer', '', 'int');
		if($transfer){
			$model = Transfers_Outgoing::model()->findByPk($transfer);
			if(!$model || $model->user_id != Yii::app()->user->id || $model->need_confirm != 1){
				throw new CHttpException(404, Yii::t('Front', 'Page not found'));
			}
			$number = $model->account->number;
		} else {
			$model = new Transfers_Outgoing;
		}
		
		$currencies = Currencies::model()->findAll();
		$countries = Countries::model()->findAll();
		$accounts = Accounts::model()->findAll('user_id = :uid', array(':uid' => Yii::app()->user->id));
		if(empty($accounts)){
			throw new CHttpException(404, Yii::t('Front', 'You have not any accounts'));
		}
		if($number){
			$selectedAcc = Accounts::model()->find('user_id = :uid AND number = :number', array(':uid' => Yii::app()->user->id, ':number' => $number));
		} else {
			$selectedAcc = $accounts[0];
			foreach($accounts as $acc){
				if($acc->balance > 0){
					$this->redirect(array('/transfers/outgoing', 'account' => $acc->number));
					Yii::app()->end();
				}
			}
			$this->redirect(array('/transfers/outgoing', 'account' => $selectedAcc->number));
			Yii::app()->end();
		}
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'transfer-outgoint-from') {
            if(isset($_POST['Transfers_Outgoing']['send_to'])){
				switch($_POST['Transfers_Outgoing']['send_to']){
					case 'own':
						$model->scenario = 'own';
						break;
					case 'xabina':
						$model->scenario = 'xabina';
						$model->execution_time = $model->xabina_execution_time;
						break;
					case 'external':
						$model->scenario = 'external';
						$model->execution_time = $model->external_execution_time;
						break;
				}
			}
			$model->attributes = $_POST['Transfers_Outgoing'];
			switch($model->scenario){
				case 'own':
					break;
				case 'xabina':
					$model->start_time = $model->xabina_start_time;
					$model->end_time = $model->xabina_end_time;
					$model->execution_time = $model->xabina_execution_time;
					break;
				case 'external':
					$model->start_time = $model->external_start_time;
					$model->end_time = $model->external_end_time;
					$model->execution_time = $model->external_execution_time;
					break;
			}
			if($model->start_time){
				$model->start_time = strtotime($model->start_time);
			}
			if($model->end_time){
				$model->end_time = strtotime($model->end_time);
			}
			if($model->execution_time){
				$model->execution_time = strtotime($model->execution_time);
			}
			echo CActiveForm::validate($model, null, false);
			Yii::app()->end();
        }
		
		if(isset($_POST['Transfers_Outgoing']) && Yii::app()->request->isAjaxRequest){
			if(isset($_POST['Transfers_Outgoing']['send_to'])){
				switch($_POST['Transfers_Outgoing']['send_to']){
					case 'own':
						$model->scenario = 'own';
						break;
					case 'xabina':
						$model->scenario = 'xabina';
						$model->execution_time = $model->xabina_execution_time;
						break;
					case 'external':
						$model->scenario = 'external';
						$model->execution_time = $model->external_execution_time;
						break;
				}
			}
			$model->attributes = $_POST['Transfers_Outgoing'];
			switch($model->scenario){
				case 'own':
					break;
				case 'xabina':
					$model->start_time = $model->xabina_start_time;
					$model->end_time = $model->xabina_end_time;
					$model->execution_time = $model->xabina_execution_time;
					break;
				case 'external':
					$model->start_time = $model->external_start_time;
					$model->end_time = $model->external_end_time;
					$model->execution_time = $model->external_execution_time;
					break;
			}
			if($model->start_time){
				$model->start_time = strtotime($model->start_time);
			}
			if($model->end_time){
				$model->end_time = strtotime($model->end_time);
			}
			if($model->execution_time){
				$model->execution_time = strtotime($model->execution_time);
			}
			if($model->validate()){
				$model->need_confirm = 1;
				if($model->save()){
					if(isset($_GET['next'])){
						echo CJSON::encode(array('success' => true, 'clean' => false, 'url' => Yii::app()->createUrl('/transfers/overview')));
					} else {
						echo CJSON::encode(array('success' => true, 'clean' => true));
					}
					Yii::app()->end();
				}
			}
			echo CActiveForm::validate($model, null, false);
			Yii::app()->end();
		}
		
		if($model->isNewRecord){
			$model->currency_id = 1; //default EUR currency
			$model->each_transfer = 1;
			$model->each_period = 3;
			$model->execution_time = date('m/d/Y', time()); //default
			$model->start_time = date('m/d/Y', time()); //default
			$model->end_time = date('m/d/Y', time()+3600*24*365); //default
			$model->xabina_execution_time = date('m/d/Y', time()); //default
			$model->xabina_start_time = date('m/d/Y', time()); //default
			$model->xabina_end_time = date('m/d/Y', time()+3600*24*365); //default
			$model->external_execution_time = date('m/d/Y', time()); //default
			$model->external_start_time = date('m/d/Y', time()); //default
			$model->external_end_time = date('m/d/Y', time()+3600*24*365); //default
			$model->country_id = 3205;
		} else {
			if(!$model->start_time){
				$model->start_time = time();
			}
			if(!$model->end_time){
				$model->end_time = time();
			}
			if(!$model->execution_time){
				$model->execution_time = time();
			}
			$model->xabina_start_time = date('m/d/Y', $model->start_time);
			$model->xabina_end_time = date('m/d/Y', $model->end_time);
			$model->xabina_execution_time = date('m/d/Y', $model->execution_time);
			$model->external_start_time = date('m/d/Y', $model->start_time);
			$model->external_end_time = date('m/d/Y', $model->end_time);
			$model->external_execution_time = date('m/d/Y', $model->execution_time);
			$model->start_time = date('m/d/Y', $model->start_time);
			$model->end_time = date('m/d/Y', $model->end_time);
			$model->execution_time = date('m/d/Y', $model->execution_time);
		}
		
		$this->render('outgoing', array(
			'model' => $model,
			'currencies' => $currencies,
			'countries' => $countries,
			'accounts' => $accounts,
			'selectedAcc' => $selectedAcc,
		));
    }
	
	public function actionOverview(){
		$transfers = Transfers_Outgoing::model()->findAll('user_id = :uid AND need_confirm = 1', array('uid' => Yii::app()->user->id));
		
		if(isset($_POST['transfer']) && Yii::app()->request->isAjaxRequest){
			$return = false;
			$arr = explode('_', $_POST['transfer']);
			if(count($arr) != 2){
				throw new CHttpException(404, Yii::t('Front', 'Page not found'));
			}
			$confirmations = Transfers_Confirmation::model()->findAll('(group_id != :gid OR transfer_id = :tid) AND user_id = :uid AND active = 0', array(':gid' => $arr[0], ':uid' => Yii::app()->user->id, ':tid' => $arr[1]));
			foreach($confirmations as $conf){
				if($conf->transfer_id == $arr[1] && $conf->group_id == $arr[0]){
					$return = true;
				}
				$conf->delete();
			}
			$success = false;
			if(!$return){
				$confirmation = new Transfers_Confirmation;
				$confirmation->group_id = $arr[0];
				$confirmation->transfer_id = $arr[1];
				$confirmation->user_id = Yii::app()->user->id;
				$confirmation->active = 0;
				if($confirmation->save()){
					$success = true;
				}
			} else {
				$success = true;
			}
			$trans = Transfers_Confirmation::model()->with('transfer')->findAll('t.user_id = :uid AND group_id = :gid', array(':uid' => Yii::app()->user->id, ':gid' => $arr[0]));
			$transes = array();
			foreach($trans as $tr){
				if(!isset($transes[$tr->transfer->currency->code])){
					$transes[$tr->transfer->currency->code] = array(
						'amount' => $tr->transfer->amount,
						'count' => 1,
					);
				} else {
					$transes[$tr->transfer->currency->code] = array(
						'amount' => $transes[$tr->transfer->currency->code]['amount'] + $tr->transfer->amount,
						'count' => $transes[$tr->transfer->currency->code]['count']+1,
					);
				} 
			}
			$html = $this->renderPartial('_checked', array('transes' => $transes), true, false);
			echo CJSON::encode(array('success'=>$success, 'html' => $html));
			Yii::app()->end();
		}
		
		$this->render('overview', array('transfers' => $transfers));
	}
	
	public function actionSuccess(){
		$this->render('success');
	}
	
	public function actionDelete($id){
		$transfers = Transfers_Outgoing::model()->findByPk($id);
		if($transfers && $transfers->user_id == Yii::app()->user->id && $transfers->need_confirm == 1){
			$transfers->delete();
			echo CJSON::encode(array('success' => true));
			Yii::app()->end();
		}
		echo CJSON::encode(array('success' => false));
	}
	
	public function actionSmsConfirm(){
	
		$form = new Form_Smsconfirm();
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-confirmation-code') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Smsconfirm']) && Yii::app()->request->isAjaxRequest ){
			$confs = Transfers_Confirmation::model()->findAll('user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			if(count($confs)){
				$smsshot = Yii::app()->cache->get('transferSmsShot'.$confs[0]->group_id.Yii::app()->user->id);
				if($smsshot > 3){
					echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Try in a hour')));
					Yii::app()->end();
				}elseif($confs[0]->confirm_code != (int)$_POST['Form_Smsconfirm']['code']){
					//Yii::app()->cache->set('transferSmsShot'.$confs[0]->group_id.Yii::app()->user->id, $smsshot, 3600);
					echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Code is incorrect')));
					Yii::app()->end();
				} else{
					foreach($confs as $conf){
						if($conf->confirm_code == (int)$_POST['Form_Smsconfirm']['code']){
							$conf->transfer->need_confirm = 0;
							$conf->transfer->save();
							$conf->delete();
						}
					}
					echo CJSON::encode(array('success' => true, 'url' => $this->createUrl('/transfers/success')));
					Yii::app()->end();
				}
				if(!$smsshot){
					$smsshot = 1;
				} else {
					$smsshot++;
				}
			} else {
				throw new CHttpException(404, Yii::t('Page not found'));
			}
		}
	
		$code = rand(1000, 9999);
		if(Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('type') == 'all'){
			Transfers_Confirmation::model()->deleteAll('user_id = :uid', array(':uid' => Yii::app()->user->id));
			$transfers = Transfers_Outgoing::model()->findAll('user_id = :uid AND need_confirm = 1', array(':uid' => Yii::app()->user->id));
			foreach($transfers as $transfer){
				$ntc = new Transfers_Confirmation;
				$ntc->group_id = substr(time()+$code, 5, 11);
				$ntc->transfer_id = $transfer->id;
				$ntc->user_id = Yii::app()->user->id;
				$ntc->confirm_code = $code;
				$ntc->active = 1;
				$ntc->save();
			}
			if(Yii::app()->sms->to($user->phone)->body('Confirmation code for transfer: {code}', array('{code}' => $code))->send() != 1){
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			}
			echo CJSON::encode(array('success' => true));
			Yii::app()->end();
		}
	
		$newConfirmations = Transfers_Confirmation::model()->findAll('user_id = :uid AND active = 0', array(':uid' => Yii::app()->user->id));
		$user = Users::model()->findByPk(Yii::app()->user->id);
		if(count($newConfirmations)){
			Transfers_Confirmation::model()->deleteAll('user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			Transfers_Confirmation::model()->updateAll(array('confirm_code' => $code, 'active' => 1), 'user_id = :uid AND active = 0', array(':uid' => Yii::app()->user->id));
			
			if(Yii::app()->sms->to($user->phone)->body('Confirmation code for transfer: {code}', array('{code}' => $code))->send() != 1){
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			}
		} else {
			$confirmations = Transfers_Confirmation::model()->findAll('user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			if(empty($confirmations)){
				throw new CHttpEcxeption(404, Yii::t('Page not found'));
			}
		}
		$num = substr($user->phone, -3, 3);
		
		
		$this->render('smsconfirm', array('model' => $form, 'num' => $num));
	}
}