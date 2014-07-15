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
                    'SMSRegisterVerify',
					'registrationsuccess', 
					'remindsuccess',
                    'remindSupportCall',
					'SMSLogin',
					'SMSConfirm',
					'SMSConfirm',
					'SMSPhoneChange',
					'resendloginsms',
					'disclaime',
                    'ResendVerifySMS',
                    'SMSVerifyPhoneChange',
                    'RegisterPrepaid',
                    'RegisterPrepaidPass',
                    'ChangeLostPhone',
                    'ChangeLostPhoneVerify',
                    'CheckLostPhone',
                    'changeLostPhoneEmail',
                    'ResetSMSLogin'
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
	
	public function actionDisclaime($tourl){
		$this->layout = 'main';
		$this->render('disclaime');
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

        if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}

		$model = new Form_Smslogin('login');
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-login') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Smslogin'])){
			$model->userId = $_POST['Form_Smslogin']['userId'];
            $user = Users::model()->findByAttributes(array("login"=>$model->userId));
            if ($user != null && $user->status == Users::USER_IS_PREPAID) {
                Yii::app()->session['user_login'] = $user->login;
                $this->redirect(array('/site/RegisterPrepaidPass'));
            }
			elseif($model->smsSendCode())
				$this->redirect(array('/site/SMSConfirm'));
		}

		$this->render('frm/_smslogin', array('model' => $model));
	}
	
	public function actionSMSConfirm(){

        if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}

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

                    Yii::app()->session['user_phone'] = $model->phone;
					Yii::app()->session['user_code'] = rand(100000,999999);
					$this->redirect(array('/site/SMSRegisterVerify/'));
				}
			}
        }
        $this->render('frm/_registration', array('model' => $model));
    }

    public function actionRegisterPrepaid() {
		if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}
        if (!isset(Yii::app()->session['user_login'])) {
		    $this->redirect(array('/site/SMSLogin'));
        }
        if (!isset(Yii::app()->session['user_pass'])) {
		    $this->redirect(array('/site/RegisterPrepaidPass'));
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
            $user = Users::model()->find('login = :p', array(':p' => Yii::app()->session['user_login']));
            if ($user != null) {
                $model->role = $user->role;
            }
			if($model->validate() && $user != null){

                $user->phone = $model->phone;
                $user->login = $model->login;
                $user->email = $model->email;
                $user->save();
                Yii::app()->session['user_phone'] = $model->phone;
                Yii::app()->session['user_code'] = rand(100000,999999);
                $this->redirect(array('/site/SMSRegisterVerify/'));
			}
        }
        $model->prepaid_login = Yii::app()->session['user_login'];
        $this->render('frm/_registerprepaid', array('model' => $model));
    }

    public function actionRegisterPrepaidPass() {
		if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}
        if (!isset(Yii::app()->session['user_login'])) {
		    $this->redirect(array('/site/SMSLogin'));
        }
        $model = new Form_Login;
        Yii::app()->session['user_pass'] = '';
        // if it is ajax validation request
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'registration-from') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['Form_Login'])) {
            $model->attributes = $_POST['Form_Login'];
            $model->login = Yii::app()->session['user_login'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() ){

                Yii::app()->session['user_pass'] = $model->password;
				$this->redirect(array('/site/RegisterPrepaid'));
            }
        }
        $this->render('frm/_registerprepaidpass', array('model' => $model));
    }

	public function actionSMSRegisterVerify(){

        if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}
		$model = new Form_Smsregisterverify('confirm');
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/account'));
		}

        if (!Yii::app()->session['user_code']) {
            Yii::app()->session['user_code'] = rand(100000,999999);
        }

		$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
		$model->userId = $user->login;


		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-confirm') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Form_Smsregisterverify'])){

			$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
			$model->code = $_POST['Form_Smsregisterverify']['code'];

			if(!$user->phone_confirm){
				$user->phone_confirm = 1;
				$user->status = 1;
				$newPhone = new Users_Phones;
				$newPhone->user_id = $user->id;
				$newPhone->email_type_id = 3; // TODO: email types
				$newPhone->phone = $user->phone;
				$newPhone->status = 1;
				$newPhone->is_master = 1;
				$newPhone->withOutHash = true;
				$newPhone->save();
				$user->save();
                $mail = new Mail();
                $mail->send(
                    $user, // this user
                    'registration', // sys mail code
                    array(	// params
                          '{:userPhone}' => '+'.$user->phone,
                          '{:date}' => date('Y m d', time()),
                          '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/emailconfirm/'.$user->hash,
                ));
			}

            if($model->validate() && $model->login()){
                    $this->redirect(array('banking/index', 'language' => Yii::app()->user->getLanguage()));
            }
		}

		$this->render('frm/_smsregisterverify', array('model' => $model, 'user' => $user));
	}

	public function actionResendVerifySMS(){
		if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/account'));
		}

		$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));
		$model = new Form_Smsregisterverify('login');

		$model->userId = $user->login;
        ;
		if($model->smsSendCode()){
			echo CJSON::encode(array('success' => true));
		}
	}

	public function actionSMSVerifyPhoneChange(){

		$model = new Form_Smslogin('change');
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/site/smslogin'));
		}
		$user = Users::model()->find('phone = :p', array(':p' => Yii::app()->session['user_phone']));

		$model->userId = $user->login;
		if($user->phone_confirm){
			//throw new CHttpException(404, Yii::t('Page not found'));
		}

		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-change-phone') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Form_Smslogin'])){
			$user->phone = $_POST['Form_Smslogin']['phone'];
			if($model->validate() && $user->save()){
                Yii::app()->session['user_phone'] = $user->phone;
				$this->redirect(array('/site/SMSRegisterVerify'));

			}
		}

		$this->render('frm/_registerchangephone', array('model' => $model, 'user' => $user));
	}

	public function actionRegistrationSuccess(){
		$this->render('registrationSuccess');
	}

	public function actionRemindSuccess(){
		$this->render('remindEmailSend');
	}

	public function actionRemindSupportCall(){
		$this->render('remindSupportCall');
	}

    public function actionRemind(){

        if(!Yii::app()->user->getIsGuest()){
            $this->redirect(array('banking/index'));
        }
		
		$form = new Form_Remind();

		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'remind-from') {
            $form = new Form_Remind($_GET['type']);
			echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        if (isset($_POST['Form_Remind'])) {
            $form->attributes = $_POST['Form_Remind'];

            if ($form->validate() && in_array($form->formtype, $form->remind_types)) {

                $user = Users::model()->findByAttributes(array($form->formtype => $form->login));

                if($user){
                    if ($form->formtype == 'login') {
                        Yii::app()->session['user_login'] = $form->login;
                        $this->redirect(array('/site/CheckLostPhone'));
                    }
                    $mail = new Mail();
                    $mail->send(
                        $user, // this user
                        'remindPassWithLink', // sys mail code
                        array(	// params
                              '{:userPhone}' => '+'.$user->phone,
                              '{:date}' => date('Y m d', time()),
                              '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/site/SMSLogin',
                              )

                    );

                }
                $this->redirect(array('/remindsuccess'));
            }
        }

        if (isset($_GET['type'])) {
            $form = new Form_Remind($_GET['type']);
            $form->formtype = $_GET['type'];
		    $this->render('frm/_remind', array('model' => $form));
        } else {

            $this->render('frm/_remindtype', array('model' => $form));
        }
    }

    public function actionCheckLostPhone(){

        if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}

		$model = new Form_Changelostphone('change');
		if(!isset(Yii::app()->session['user_login'])){
			$this->redirect(array('/site/smslogin'));
		}
		$user = Users::model()->find('login = :p', array(':p' => Yii::app()->session['user_login']));

		$model->userId = $user->login;
		if($user->phone_confirm){
			//throw new CHttpException(404, Yii::t('Page not found'));
		}

		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-change-phone') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Form_Changelostphone'])){
            $model->attributes = $_POST['Form_Changelostphone'];
            if($model->validate()){

                $user->createHash();
                $user->update();
                $mail = new Mail();
                $mail->send(
                    $user, // this user
                    'remindPhone', // sys mail code
                    array(	// params
                          '{:userPhone}' => '+'.$user->phone,
                          '{:date}' => date('Y m d', time()),
                          '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/site/ChangeLostPhone/?login='.$user->login.'&confirm='.$user->hash,
                ));

                $this->redirect(array('/site/changeLostPhoneEmail'));
            }
		}

		$this->render('frm/_checklostphone', array('model' => $model, 'user' => $user));
	}

	public function actionChangeLostPhoneEmail(){
		$this->render('changeLostPhoneEmail');
	}

	public function actionChangeLostPhone(){

        if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}

		$model = new Form_Smslogin('change');
		if(!isset($_REQUEST['login'])){
			$this->redirect(array('/site/smslogin'));
		}
		$user = Users::model()->find('login = :p && hash = :h', array(':p' => $_REQUEST['login'],':h' => $_REQUEST['confirm']));

		$model->userId = $user->login;
		if($user->phone_confirm){
			//throw new CHttpException(404, Yii::t('Page not found'));
		}

		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-change-phone') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Form_Smslogin'])){
            $model->attributes = $_POST['Form_Smslogin'];
            if ($model->validate()) {
                Yii::app()->session['user_phone'] = $model->phone;
                Yii::app()->session['user_login'] = $user->login;
                Yii::app()->session['user_code'] = rand(100000,999999);
                $this->redirect(array('/site/ChangeLostPhoneVerify'));
            }
		}

		$this->render('frm/_changelostphone', array('model' => $model, 'user' => $user));
	}

	public function actionResetSMSLogin(){

		if(!isset($_REQUEST['login'])){
			$this->redirect(array('/site/smslogin'));
		}
		$user = Users::model()->find('login = :p && hash = :h', array(':p' => $_REQUEST['login'],':h' => $_REQUEST['confirm']));

		if (!$user) {
            $this->redirect(array('/site/smslogin'));
        }
		Yii::app()->cache->set('sms_auth_trying_user_'.$user->login, 0, 3600);

        $this->render('accountUnblock');
	}

	public function actionChangeLostPhoneVerify(){

        if(!Yii::app()->user->isGuest){
			$this->redirect(array('/banking/index'));
		}

		$model = new Form_Smsregisterverify('confirm');
		if(!isset(Yii::app()->session['user_phone'])){
			$this->redirect(array('/site/ChangeLostPhone'));
		}

		$user = Users::model()->find('login = :p', array(':p' => Yii::app()->session['user_login']));
        $user->phone = Yii::app()->session['user_phone'];

		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-confirm') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Form_Smsregisterverify'])){
            $model->attributes = $_POST['Form_Smsregisterverify'];
            $model->userId = $user->login;
			if ($model->validate()) {
                $user->phone = Yii::app()->session['user_phone'];
                $user->update();
                $mail = new Mail();
                $mail->send(
                    $user, // this user
                    'remindNewPhone', // sys mail code
                    array(	// params
                          '{:userPhone}' => '+'.$user->phone,
                          '{:date}' => date('Y m d', time()),
                          '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/site/ChangeLostPhone/?login='.$user->login.'&confirm='.$user->hash,
                ));
                $this->render('remindSuccess');
            } else {
                $this->render('frm/_smsregisterverify', array('model' => $model, 'user' => $user));
            }

		}
        else {
		    $this->render('frm/_smsregisterverify', array('model' => $model, 'user' => $user));
        }
	}

}