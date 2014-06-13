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
                'actions' => array(
						'index', 
						'accountsactivation',
						'uploadactivationfile',
						'accountsactivationback', 
						'savefiles'
				),
                'roles' => array('client'),
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
		//$this->breadcrumbs[Yii::t('Front', 'Overview!!!!!!')] = '';

		$accounts = Accounts::model();
		$accounts->user_id = Yii::app()->user->getCurrentId();
		
		$transactions = new Transactions('search');
		$transactions->user_id = Yii::app()->user->getCurrentId();
		
		$this->render('index', array('accounts' => $accounts, 'transactions' => $transactions));
    }

	public function actionAccountsActivation()
    {
		
		$this->breadcrumbs[Yii::t('Front', 'Overview')] = array('/banking/index');
		$this->breadcrumbs[Yii::t('Front', 'Account activation')] = '';
		
		if(Yii::app()->request->isAjaxRequest && isset($_POST['deleteFile'])){
			$activation = Users_Activation::model()->findByPk(Yii::app()->user->id);
			if($activation->step == 2){
				$file = Users_Files::model()->find('name = :name AND user_id = :user_id', 
					array(':name' => $_POST['deleteFile'], ':user_id' => Yii::app()->user->id)
				);
				if($file){
					$file->deleted = 1;
					$file->save();
				}
			}
			Yii::app()->end();
		}
		
		if(Yii::app()->user->status != Users::USER_EMAIL_IS_ACTIVE){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
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
		} elseif($activation->step == 3){
			$this->activationStepThree($activation);
		} elseif($activation->step == 4){
			$this->activationStepFour($activation);
		}else{
			$this->redirect(array('/banking'));
			Yii::app()->end();
			throw new CHttpException(404, Yii::t('Font', 'Page not found'));
		}
	}

	protected function activationStepOne($activation, $partial = false)
    {
		$activationForm = new Form_Activation();
		$activationForm->attributes = $activation->attributes;
		$activationForm->setUserId(Yii::app()->user->id);
		$activationForm->setPhone(Yii::app()->user->phone);
		
		$countries = Countries::model()->findAll(array('order' => 'name asc'));
		$countries = CHtml::listData($countries, 'id', 'name');		
		$countries = array('' => Yii::t('Front', 'Select')) + $countries;
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'activation-from-first-step') {
            echo CActiveForm::validate($activationForm);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Activation']) && Yii::app()->request->isAjaxRequest){
			$validate = CActiveForm::validate($activationForm);
			if($validate !== '[]'){
				echo $validate;
			} else {
				$activationForm->attributes = $_POST['Form_Activation'];
				if($activationForm->firstStep($activation)){
					$this->activationStepTwo($activation, true);
					Yii::app()->end();
				} else {
					d($activation->getErrors());
				}
			}
			Yii::app()->end();
		}
		
		if($partial){            
            $this->cleanResponseJs();	
            $html = $this->renderPartial('activation/step_one', array('model' => $activationForm, 'activation' => $activation, 'countries' => $countries), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		
		$user = Users::model()->findByPk(Yii::app()->user->id);
		$activationForm->attributes = $user->attributes;
		
		$this->render('activation', array('model' => $activationForm, 'activation' => $activation, 'countries' => $countries));
		
		
	}
	
	protected function activationStepTwo($activation, $partial = false)
    {
		if($activation->step != 2 || $activation->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$model = new Form_Activation_File;
		
		if(Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('success') == 'true'){
			$success = false;
			if(Users_Files::model()->count('user_id = :uid AND deleted = 0 AND form = "Users_Activation"', array(':uid' => Yii::app()->user->id)) > 1){
				$success = true;
			}

			if($success){
				$activation->step = 3;
				$activation->save();
				$this->activationStepThree($activation, true);
			}
			Yii::app()->end();
		}

		if($partial){            
			$html = $this->renderPartial('activation/step_two', array('activation' => $activation, 'model' => $model), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		
		$this->render('activation', array('activation' => $activation, 'model' => $model));
	}
	
	public function activationStepThree($activation, $partial = false)
    {
		// term and conditions from
		$activation->scenario = 'terms';
		
		if(Yii::app()->request->isAjaxRequest && isset($_POST['Users_Activation']) && Yii::app()->request->getParam('ajax') == 'activation-form-step-3'){
			echo CActiveForm::validate($activation);
            Yii::app()->end();
		}
		
		if(isset($_POST['Users_Activation']) && Yii::app()->request->isAjaxRequest){
			$validate = CActiveForm::validate($activation);
			if($validate !== '[]'){
				echo $validate;
			} else {
				$activation->attributes = $_POST['Users_Activation'];
				if($activation->save()){
					$activation->step = 4;
					$activation->save();
					$this->activationStepFour($activation, true);
				} else {
					d($activation->getErrors());
					die;
				}
			}
			Yii::app()->end();
		}
		
		if($partial){
			$html = $this->renderPartial('activation/step_three', array('activation' => $activation), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		
		$this->render('activation', array('activation' => $activation));
	}
	
	public function activationStepFour($activation, $partial = false)
    {
		Yii::app()->user->removeNotification('activate_your_account');
		Yii::log('User was loging and confirm email. Email: '.Yii::app()->user->email.' UserID: '.Yii::app()->user->id, CLogger::LEVEL_INFO);
		if($partial){
			$html = $this->renderPartial('activation/step_four', array('activation' => $activation), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		$this->render('activation', array('activation' => $activation));
	}

	public function actionUploadActivationFile()
    {
		Yii::import("application.ext.EAjaxUpload.qqFileUploader");
		$documentNum = Yii::app()->request->getParam('doc','int');
		$countFiles = Users_Files::model()->count('form = "activation" AND document = :docNumb AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id, ':docNumb' => $documentNum));
		if($countFiles >= 2){
			echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Many files')));
			Yii::app()->end();
		}

		$folder=Yii::app()->getBasePath(true) . '/../documents/'.Yii::app()->user->id.'/'; // folder for uploaded files
		$allowedExtensions = array("jpg","jpeg","gif","png","pdf"); //array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 20 *1024 * 1024; // maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$oldUmask = umask ();
		umask ( 0 );
		$res = @mkdir ( $folder, 0777, 1);
		umask ( $oldUmask );
		$oldUmask = umask ();
		$uploader->setFileName(mb_substr(md5(Yii::app()->user->name . time()), 5, 10));
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

		$fileSize=filesize($folder.$result['filename']); //GETTING FILE SIZE
		$fileName=$result['filename']; //GETTING FILE NAME

		if($result['success'] == true){
			$file = new Users_Files();
			$file->user_id = Yii::app()->user->id;
			$file->name = $result['filename'];
			$file->ext = $uploader->getFileExt();
			$file->form = 'activation';
			$file->user_file_name = $uploader->getUserFileName();
			$file->document = $documentNum;
			if(!$file->save()){
				dd($file->getErrors());
			}
		}

		echo $return;// it's array
		Yii::app()->end();
	}

	public function actionSaveFiles()
    {
		$model = new Form_Activation_File;
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'activation-from-two') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		$result = array();
		
		$activation = Users_Activation::model()->findByPk(Yii::app()->user->id);
		if($activation->step != 2){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		
		if(isset($_POST['Form_Activation_File']) && Yii::app()->request->isAjaxRequest){
			if(CActiveForm::validate($model) != '[]'){
				echo CActiveForm::validate($model);
			} else {
				foreach($_POST['Form_Activation_File']['files'] as $file){
					$document = $_POST['Form_Activation_File']['document'];
					$fileModel = Users_Files::model()->find('user_id = :uid AND name = :name AND document = :document', array(':uid' => Yii::app()->user->id, ':name' => $file, ':document' => $document));
					if($fileModel){
						$fileModel->description = $model->description;
						$fileModel->document_type = $model->file_type;
						$fileModel->document = $model->document;
						$fileModel->save();
					}
				}
				echo CJSON::encode(array('success' => true));
			}
			Yii::app()->end();
		}
	}

	public function actionAccountsActivationBack()
    {
		if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$activation = Users_Activation::model()->findByPk(Yii::app()->user->id);
		if(!$activation || $activation->step != 2){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		} elseif($activation->step == 2) {
			$activation->step = 1;
			$activation->save();
			$this->activationStepOne($activation, true);
			Yii::app()->end();
		}
	}    
}