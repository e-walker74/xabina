<?php

class UserController extends Controller
{

    public $layout = 'user';
    public $title  = '';

    public function filters()
    {
        return array(
            //'accessControl',
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
                'actions' => array(),
                'users' => array('*')
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
    public function actionIndex()
    {
		$this->render('index');
    }
	
	public function actionEmailConfirm($hash){
		$user = Users::model()->find(array('condition' => 'hash = :hash', 'limit' => 1, 'params' => array(':hash' => $hash)));
		if($user){
			$user->status = Users::USER_EMAIL_IS_ACTIVE;
			$user->hash = '';
			
			if($user->save()){
				$account = new Accounts();
				$account->user_id = $user->id;
				$account->balance = $user->gift;
				$account->save();
				
				$personal = new Users_Personal_Edit;
				$personal->user_id = $user->id;
				$personal->first_name = $user->first_name;
				$personal->last_name = $user->last_name;
				$personal->save();
				
				/*if(Yii::app()->sms->to($phone->phone)->body('Activation Code: {code} Xabina welcomes you! Please, activate mobile phone in the Settings tab of online banking.', array('{code}' => $phone->hash))->send() != 1){
					Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
				}*/
				
				$email = new Users_Emails;
				$email->user_id = $user->id;
				$email->email_type_id = 3; // TODO: email types
				$email->email = $user->email;
				$email->status = 1;
				$email->is_master = 1;
				$email->save();
				
				$this->redirect(array('/site/SMSLogin'));
				/*
				$model = new Form_Login;
				$model->login = $user->email;
				$model->password = $user->password;
				if ($model->login()){
					Yii::app()->user->addNotification('activate_your_account', 'Welcome, <span>:userName!</span></br> Activate your account', 'critical', 'red');
					Yii::log('User was loging and confirm email. Email: '.Yii::app()->user->email.' UserID: '.Yii::app()->user->id, CLogger::LEVEL_INFO);
					Yii::app()->user->addNotification('mobile_activation', 'To activate the mobile click <a href="'.Yii::app()->createUrl('personal/editphones').'">here</a>', 'critical', 'red');
					$this->redirect(array('banking/index'));
				}
				*/
			}
		} else {
			throw new CHttpException(404, Yii::t('Error', 'Page not found. This is disposable link.'));
		}
	}
	
	public function actionDeleteNotification($code){
		if(Yii::app()->user->removeNotification($code)){
			echo CJSON::encode(array('success' => true));
		} else {
			echo CJSON::encode(array('success' => false));
		}
	}
}
