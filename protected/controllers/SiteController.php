<?php

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array(
					'login', 
					'terms', 
					'index', 
					'error', 
					'registration', 
					'remind', 
					'registrationsuccess', 
					'remindsuccess',
					'SMSLogin',
					'SMSConfirm',
					'SMSConfirm',
					'SMSPhoneChange',
					'resendloginsms',
				),
                'users' => array('*')
            ),
			array('allow', // allow readers only access to the view file
                'actions' => array('logout'),
                'users' => array('*')
            ),
			array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionIndex(){
		$this->render('index');
    }
	
	public function actionTerms(){
		$this->renderPartial('terms');
	}

    public function actionError() {
        $this->layout = false;
		if(isset($_GET['debug']) && YII_DEBUG){
			d(Yii::app()->errorHandler->error);
			die;
		}
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {

		if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}
		
		$this->redirect(array('/site/SMSLogin'));

        $model = new Form_Login;

        // if it is ajax validation request
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'login-from') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['Form_Login'])) {
            $model->attributes = $_POST['Form_Login'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()){
				Yii::log('User was loging. Email: '.Yii::app()->user->email.' UserID: '.Yii::app()->user->id, CLogger::LEVEL_INFO);
				$this->redirect(array('banking/index'));
            }
        }

        $this->render('frm/_login', array('model' => $model));
    }
	
	public function actionResendLoginSMS(){
		if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/site/smslogin'));
		}
		
		$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
		$model = new Form_Smslogin('login');
		$model->userId = $user->login;
		if($model->smsSendCode()){
			echo CJSON::encode(array('success' => true));
		}
	}
	
	public function actionSMSLogin(){
	
		$model = new Form_Smslogin('login');
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-login') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Smslogin'])){
			$model->userId = $_POST['Form_Smslogin']['userId'];
			if($model->smsSendCode())
				$this->redirect(array('/site/SMSConfirm'));
		}

		$this->render('frm/_smslogin', array('model' => $model));
	}
	
	public function actionSMSConfirm(){
	
		$model = new Form_Smslogin('confirm');
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/site/smslogin'));
		}
		$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
		$model->userId = $user->login;

		if(!Yii::app()->cache->get('sms_auth_code_user_'.$model->userId)){
			$this->redirect(array('/site/smslogin'));
		}
	
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-confirm') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Smslogin'])){
			if(!isset(Yii::app()->session['user_phone'])){
				$this->redirect(array('/site/smslogin'));
			}
			$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
			$model->code = $_POST['Form_Smslogin']['code'];
			
			if(!$user->phone_confirm){
				$user->phone_confirm = 1;
				$newPhone = new Users_Phones;
				$newPhone->user_id = $user->id;
				$newPhone->email_type_id = 3; // TODO: email types
				$newPhone->phone = $user->phone;
				$newPhone->status = 1;
				$newPhone->is_master = 1;
				$newPhone->withOutHash = true;
				$newPhone->save();
				$user->save();
			}
			
			if($model->login()){
				$this->redirect(array('banking/index', 'language' => Yii::app()->user->getLanguage()));
			}
		}
	
		$this->render('frm/_smsconfirm', array('model' => $model, 'user' => $user));
	}
	
	public function actionSMSPhoneChange(){
	
		$model = new Form_Smslogin('change');
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/site/smslogin'));
		}
		$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
		$model->userId = $user->login;
		if($user->phone_confirm){
			throw new CHttpException(404, Yii::t('Page not found'));
		}
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-change-phone') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Smslogin'])){
			$user->phone = $_POST['Form_Smslogin']['phone'];
			if($user->save() && $model->smsSendCode()){
				$this->redirect(array('/site/SMSConfirm'));
				
			}
		}
		
		$this->render('frm/_smsnewphone', array('model' => $model));
	}

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
		$this->redirect(Yii::app()->getBaseUrl(true));
    }

    public function actionRegistration() {
		if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}
        $model = new Form_Registration;
		$this->layout = 'main';
        // if it is ajax validation request
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'registration-from') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (!empty($_POST['Form_Registration'])) {
			$model->attributes = $_POST['Form_Registration'];
			if($model->validate()){
				if($model->registration()){
					$this->redirect(array('/registrationsuccess'));
				}
			}
        }
        $this->render('frm/_registration', array('model' => $model));
    }

	public function actionRegistrationSuccess(){
		$this->render('registrationSuccess');
	}

	public function actionRemindSuccess(){
		$this->render('remindEmailSend');
	}

    public function actionRemind(){
        if(!Yii::app()->user->getIsGuest()){
            throw new CHttpException(404, 'Страница не найдена');
        }
		
		$form = new Form_Remind();
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'remind-from') {
			echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        if (isset($_POST['Form_Remind'])) {
            $form->attributes = $_POST['Form_Remind'];
			$user = Users::model()->find('email = :email', array(':email' => $form->login));
			if(!$user){
				$user = Users::model()->find('login = :login', array(':login' => $form->login));
			}
			if($user){
				if($user->hash){
					$pass = substr(md5(time() . 'xabina_pass' . $user->login), 2, 8);
					$user->password = md5($pass);
					$user->createHash();
					$user->save();
					$mail = new Mail();
					$mail->send(
						$user, // this user
						'remindPassWithLink', // sys mail code
						array(	// params
							'{:userPassword}' => $pass,
							'{:date}' => date('Y m d', time()),
							'{:activateUrl}' => Yii::app()->getBaseUrl(true).'/emailconfirm/'.$user->hash,
						)
					);
				} else {
					$pass = substr(md5(time() . 'xabina_pass' . $user->login), 2, 8);
					$user->password = md5($pass);
					$user->save();
					$mail = new Mail();
					$mail->send(
						$user, // this user
						'remindPassWithoutLink', // sys mail code
						array(	// params
							'{:userPassword}' => $pass,
							'{:date}' => date('Y m d', time()),
						)
					);
				}
				
			}
            $this->redirect(array('/remindsuccess'));
        }
		
		$this->render('frm/_remind', array('model' => $form));
    }
}