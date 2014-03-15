<?php

class BankingController extends Controller
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
                'actions' => array('index', 'accountsactivation'),
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
    public function actionIndex()
    {
		$accounts = Accounts::model();
		$accounts->user_id = Yii::app()->user->id;
		
		$transactions = Transactions::model();
		$transactions->user_id = Yii::app()->user->id;
		$this->render('index', array('accounts' => $accounts, 'transactions' => $transactions));
    }

	public function actionAccountsActivation(){
		if(Yii::app()->user->status != Users::USER_EMAIL_IS_ACTIVE){
			throw new CHttpException(404, Yii::t('Front', 'This page not found'));
		}
		
		$activation = Users_Activation::model()->findByPk(Yii::app()->user->id);
		if(!$activation){
			$activation = new Users_Activation();
			$activation->step = 1;
		}
		if($activation->step == 1){
			$this->activationStepOne($activation);
			Yii::app()->end();
		}elseif($activation->step == 2){
			$this->activationStepTwo($activation);
			Yii::app()->end();
		}
		
		

		
	}
	
	protected function activationStepOne($activation){
		$activationForm = new Form_Activation();
		$activationForm->setUserId(Yii::app()->user->id);
		$activationForm->setPhone(Yii::app()->user->phone);
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'activation-from-first-step') {
            echo CActiveForm::validate($activationForm);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Activation'])){
			$validate = CActiveForm::validate($activationForm);
			if($validate !== '[]'){
				echo $validate;
			} else {
				$activationForm->attributes = $_POST['Form_Activation'];
				if($activationForm->firstStep($activation)){
					$this->activationStepTwo($activation, true);
					Yii::app()->end();
				};
			}
			die;
		}
		
		$user = Users::model()->findByPk(Yii::app()->user->id);
		$activationForm->attributes = $user->attributes;
		
		$this->render('activation', array('model' => $activationForm, 'activation' => $activation));
		
		
	}
	
	protected function activationStepTwo($activation, $next = false){
		if($next){
			$html = $this->renderPartial('activation/step_two', array('activation' => $activation), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		
		$this->render('activation', array('activation' => $activation));
		
	}
	
}