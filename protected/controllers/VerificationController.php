<?php

class VerificationController extends Controller
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
                'actions' => array('index', 'accountsactivation','uploadactivationfile','accountsactivationback'),
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
		if(Users::USER_IS_ACTIVATED !== 2) {
			throw new CHttpException(404, Yii::t('Front', 'This page not found'));
		}
		$this->render('index', array(
			//'accounts' => $accounts, 
			//'transactions' => $transactions
		));
    }

	public function actionAccountsActivation(){
		if(Yii::app()->request->isAjaxRequest && isset($_POST['deleteFile'])){
			$activation = Users_Activation::model()->findByPk(Yii::app()->user->id);
			if($activation->step == 2){
				$file = Users_Files::model()->find('name = :name AND user_id = :user_id', array(':name' => $_POST['deleteFile'], ':user_id' => Yii::app()->user->id));
				if($file){
					$file->deleted = 1;
					$file->save();
				}
			}
			Yii::app()->end();
		}
		
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
		} elseif($activation->step == 3){
			$this->activationStepThree($activation);
		}
		
		

		
	}
	
	protected function activationStepOne($activation, $partial = false){
		$activationForm = new Form_Activation();
		$activationForm->attributes = $activation->attributes;
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
				} else {
					d($activation->getErrors());
				}
			}
			Yii::app()->end();
		}
		
		if($partial){
			$html = $this->renderPartial('activation/step_one', array('model' => $activationForm, 'activation' => $activation), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		
		$user = Users::model()->findByPk(Yii::app()->user->id);
		$activationForm->attributes = $user->attributes;
		
		$this->render('activation', array('model' => $activationForm, 'activation' => $activation));
		
		
	}
	
	protected function activationStepTwo($activation, $partial = false){
		$files = Users_Files::model()->findAll('form = "activation" AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id));
		$model = new Form_Activation_File;
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'activation-from-two') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Activation_File']) && Yii::app()->request->isAjaxRequest){
			if(CActiveForm::validate($model) != '[]'){
				echo CActiveForm::validate($model);
			} else {
				foreach($_POST['Form_Activation_File']['files'] as $file){
					$fileModel = Users_Files::model()->find('user_id = :uid AND name = :name', array(':uid' => Yii::app()->user->id, ':name' => $file));
					if($fileModel){
						$fileModel->description = $model->description;
						$fileModel->document_type = $model->file_type;
						$fileModel->save();
					}
					
				}
				$activation->step = 3;
				$activation->save();
				$this->activationStepThree($activation, true);
			}
			Yii::app()->end();
		}
	
		if($partial){
			$html = $this->renderPartial('activation/step_two', array('files' => $files, 'activation' => $activation, 'model' => $model), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		
		$this->render('activation', array('files' => $files, 'activation' => $activation, 'model' => $model));
		
	}
	
	public function activationStepThree($activation, $partial = false){
		if($partial){
			$html = $this->renderPartial('activation/step_three', array('activation' => $activation), true, true);
			$arr = array('html' => $html, 'success' => true);
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
		$this->render('activation', array('activation' => $activation));
	}
	
	public function actionUploadActivationFile(){
		Yii::import("application.ext.EAjaxUpload.qqFileUploader");
		$countFiles = Users_Files::model()->count('form = "activation" AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id));
		if($countFiles >= 2){
			echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Many files')));
			Yii::app()->end();
		}
		
		$folder=Yii::app()->getBasePath(true) . '/../../documents/'.Yii::app()->user->id.'/'; // folder for uploaded files
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
			$file->save();
		}

		echo $return;// it's array
		Yii::app()->end();
	}
	
	public function actionAccountsActivationBack(){
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