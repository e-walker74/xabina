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
                'actions' => array('login', 'index', 'error', 'registration', 'remind', 'registrationsuccess', 'remindsuccess'),
                'users' => array('*')
            ),
			array('allow', // allow readers only access to the view file
                'actions' => array('logout'),
                'roles' => array('administrator')
            ),
			array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'roles' => array('administrator')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionIndex(){
		$this->render('index');
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