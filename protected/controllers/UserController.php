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
			
				$model = new Form_Login;
				$model->login = $user->email;
				$model->password = $user->password;
				if ($model->login()){
					Yii::app()->user->addNotification('activate_your_account', 'Welcome, <span>:userName!</span></br> Activate your account', 'critical', 'yellow');
					Yii::log('User was loging and confirm email. Email: '.Yii::app()->user->email.' UserID: '.Yii::app()->user->id, CLogger::LEVEL_INFO);
					$this->redirect(array('banking/index'));
				}
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
