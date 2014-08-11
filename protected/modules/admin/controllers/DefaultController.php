<?php

class DefaultController extends Controller
{
	public function allowedActions(){
		return 'login, error, logout';
	}

	public function actionIndex()
	{
		$users = Users::model()->findAll(array('limit' => 6, 'order' => 'created_at desc'));
		$this->render('index', array('statistics' => '', 'users' => $users));
	}

	public function actionLogin(){
        $model = new Admin_Form_Login;

        // if it is ajax validation request
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'login-from') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['Admin_Form_Login'])) {
            $model->attributes = $_POST['Admin_Form_Login'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()){
				$this->redirect(array('/admin'));
            }
        }
        $this->layout = 'login';
        $this->render('login', array('model' => $model));
	}

	public function actionLogout(){
        Yii::app()->user->logout();
		$this->redirect(Yii::app()->getBaseUrl(true));
	}

	public function actionError(){
        if(Yii::app()->user->isGuest){
            $this->layout = false;
        }
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
}