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
                'actions' => array('index', 'notary', 'getnotaryfile', 'uploadfile', 'creditcard'),
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
		if(Users::USER_IS_ACTIVATED !== Users::USER_IS_ACTIVATED) {
			throw new CHttpException(404, Yii::t('Front', 'This page not found'));
		}
		$this->render('index', array(
			//'accounts' => $accounts, 
			//'transactions' => $transactions
		));
    }

	public function actionNotary(){
		$verification = Users_Verification::model()->find('user_id = :uId AND type = "notary"', array(':uId' => Yii::app()->user->id));
		if($verification && $verification->status == Users_Verification::REQUIRES_MODERATION){
			$this->render('completed');
			Yii::app()->end();
		} elseif(Yii::app()->user->status == Users::USER_IS_VERIFICATED){
			$this->redirect('/banking/index');
		}
		$files = Users_Files::model()->findAll('user_id = :uid AND form = "notary" AND deleted = 0', array(':uid' => Yii::app()->user->id));
		
		$model = new Form_Activation_File;
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'verification-notary') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Form_Activation_File'])){
			$valid = CActiveForm::validate($model);
			if($valid == '[]'){
				if($verification->notary){
					$notary = $verification->notary;
				} else {
					$notary = new Users_Verification_Notary();
					$notary->save();
					$verification->rel_id = $notary->id;
					$verification->save();
				}
				$verification->notary->description = $model->description;
				$verification->notary->save();
				$verification->status = Users_Verification::REQUIRES_MODERATION;
				$verification->save();
				$html = $this->renderPartial('completed', array(), true, false);
				echo CJSON::encode(array('success' => true, 'html' => $html));
				Yii::app()->end();
			} else {
				echo $valid;
				Yii::app()->end();
			}
		}
		
		$this->render('notary', array(
			'verification' => $verification, 
			'model' => $model,
			'files' => $files,
		));
	}
	
	public function actionGetNotaryFile(){
		$verification = Users_Verification::model()->find('user_id = :uId AND type = "notary"', array(':uId' => Yii::app()->user->id));
		if(!$verification){
			$notary = new Users_Verification_Notary();
			$notary->save();
			$verification = new Users_Verification();
			$verification->user_id = Yii::app()->user->id;
			$verification->type = 'notary';
			$verification->rel_id = $notary->id;
			$verification->save();
		}
		$file=Yii::app()->getBasePath(true) . '/../publicdocs/public.doc';
		if (file_exists($file)) {
			// ñáğàñûâàåì áóôåğ âûâîäà PHP, ÷òîáû èçáåæàòü ïåğåïîëíåíèÿ ïàìÿòè âûäåëåííîé ïîä ñêğèïò
			// åñëè ıòîãî íå ñäåëàòü ôàéë áóäåò ÷èòàòüñÿ â ïàìÿòü ïîëíîñòüş!
			if (ob_get_level()) {
			  ob_end_clean();
			}
			// çàñòàâëÿåì áğàóçåğ ïîêàçàòü îêíî ñîõğàíåíèÿ ôàéëà
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			// ÷èòàåì ôàéë è îòïğàâëÿåì åãî ïîëüçîâàòåëş
			if ($fd = fopen($file, 'rb')) {
				while (!feof($fd)) {
					print fread($fd, 1024);
				}
				fclose($fd);
			}
			Yii::app()->end();
		}
	}
	
	public function actionUploadfile(){
		Yii::import("application.ext.EAjaxUpload.qqFileUploader");
		$countFiles = Users_Files::model()->count('form = "notary" AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id));
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
			$file->form = 'notary';
			$file->user_file_name = $uploader->getUserFileName();
			if(!$file->save()){
				dd($file->getErrors());
			}
		}

		echo $return;// it's array
		Yii::app()->end();
	}
	
	public function actionCreditcard(){
		$verification = Users_Verification::model()->find('user_id = :uId AND type = "creditcard"', array(':uId' => Yii::app()->user->id));
		if($verification && $verification->status == Users_Verification::REQUIRES_MODERATION){
			$this->render('completed');
			Yii::app()->end();
		} elseif(Yii::app()->user->status == Users::USER_IS_VERIFICATED){
			$this->redirect('/banking/index');
		}
		
		if(!$verification || $verification->status == Users_Verification::NOT_SEND_VERIFICATION){
			$this->creditCardForm($verification);
		} elseif($verification && $verification->status == Users_Verification::REQUIRES_USER_CODE){
			$this->creditCardConfirm($verification);
		}elseif($verification && $verification->status == Users_Verification::VERIFICATION_COMPLETED){
			if(Yii::app()->request->isAjaxRequest){
				$this->renderPartial('completed', array(), true, false);
			}
		} elseif($verification && $verification->status == Users_Verification::VERIFICATION_COMPLETED){
		
		}
		
		$this->render('creditcard');
	}
	
	public function creditCardConfirm($verification, $render = false){
		if($verification && $verification->creditcard) {
			$model = $verification->creditcard;
		} else {
			throw new HttpException(404, Yii::t('Front', 'Page not found'));
		}
		
		if (!$render && Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'verification-creditcard') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		if(isset($_POST['Users_Verification_Creditcard']) && isset($_POST['Users_Verification_Creditcard']['verification_code'])){
			/*if(Yii::app()->cache->get('User_verification_action_'.Yii::app()->user->id) > 2){
				$model->addError('Users_Verification_Creditcard_verification_code', Yii::t('Front', 'Many attempts. Please try again in an hour.'));
				echo CJSON::encode($model->getErrors());
				Yii::app()->end();
			}*/
			if($verification 
					&& $verification->creditcard 
					&& !$verification->creditcard->confirm
					&& $verification->creditcard->verification_code
					&& $verification->creditcard->verification_code == $_POST['Users_Verification_Creditcard']['verification_code']
				){
				$verification->creditcard->confirm = 1;
				$verification->status = Users_Verification::VERIFICATION_COMPLETED;
				$verification->creditcard->save();
				$verification->save();
				Yii::app()->user->removeNotification('verification_requires_user_code');
				Yii::app()->user->addNotification(
					'verification_completed', //êîä
					'Your account has been successfully verificated.', 
					'close', // âîçìîæíîñòü çàêğûòü
					'yellow' //æåëòàÿ ğàìêà
				);
				$user = Users::model()->findByPk(Yii::app()->user->id);
				$user->status = Users::USER_IS_VERIFICATED;
				if($user->save()){
					Yii::app()->user->status = $user->status;
					$html = $this->renderPartial('completed', array(), true, false);
					echo CJSON::encode(array('success' => true, 'html' => $html));
					Yii::app()->end();
				}
			} else {
				if($i = Yii::app()->cache->get('User_verification_action_'.Yii::app()->user->id)){
					Yii::app()->cache->set('User_verification_action_'.Yii::app()->user->id, ++$i, 3600);
				} else {
					Yii::app()->cache->set('User_verification_action_'.Yii::app()->user->id, 1, 3600);
				}
				
				$model->addError('Users_Verification_Creditcard_verification_code', Yii::t('Front', 'Verification code is incorect'));
				echo CJSON::encode($model->getErrors());
				Yii::app()->end();
			}
		}
		$model->verification_code = '';
		
		if(Yii::app()->request->isAjaxRequest){
			$html = $this->renderPartial('creditcard/step_two', array('model' => $model), true, false);
			echo CJSON::encode(array('success' => true, 'html' => $html));
			Yii::app()->end();
		}
		
		$this->render('creditcard/step_two', array('model' => $model));
		Yii::app()->end();
	}
	
	public function creditCardForm($verification){
		if($verification && $verification->creditcard) {
			$model = $verification->creditcard;
		} else {
			$model = new Users_Verification_Creditcard();
		}
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'verification-creditcard') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Users_Verification_Creditcard'])){
			$model->attributes = $_POST['Users_Verification_Creditcard'];
			if($model->validate() && $model->isNewRecord){
				$model->user_id = Yii::app()->user->id;
				$model->save();
				if($model->verification){
					$verification = $model->verification;
				} else {
					$verification = new Users_Verification();
				}
				$verification->type = 'creditcard';
				$verification->user_id = Yii::app()->user->id;
				$verification->status = Users_Verification::REQUIRES_USER_CODE;
				$verification->rel_id = $model->id;
				$verification->save();
				Yii::app()->user->addNotification(
					'verification_requires_user_code', //êîä
					'You have successfully passed the first stage of verification. We sent to Your bank account in the amount of 0.01EUR. In the description of the transaction specified 6-digit code that you need to enter the second stage to complete the process of verification.', 					
					'critical', // âîçìîæíîñòü çàêğûòü
					'yellow' //æåëòàÿ ğàìêà
				);
				// TODO::initialize transaction
				$this->creditCardConfirm($verification, true);
				Yii::app()->end();
			}
		}
		
		$this->render('creditcard', array('model' => $model));
		Yii::app()->end();
	}
}