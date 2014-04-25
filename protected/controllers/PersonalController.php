<?php

class PersonalController extends Controller
{
    public $layout = 'banking';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }


    public function accessRules()
    {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                //'actions' => array('index', 'save', 'activate'),
                'actions' => array(
                    'index',
                    'editemails',
                    'saveemails',
                    'editphones',
                    'savephones',
                    'editaddress',
                    'saveaddress',
					'editname',
					'uploadfile',
					'activate',
					'makeprimary',
                    'editsocials',
					'delete',
					'editmessagers',
					'changetype',
					'resendsms',
					'editqustions',
					'resendemail',
                ),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }


    public function actionIndex()
    {
	
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = '';
	
		$model = Users::model()->findByPk(Yii::app()->user->id);

        $this->render('index', array(
			'model' => $model,
        ));
    }

    public function actionEditemails()
    {
		
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Manage email addresses'))] = '';
	
		$model_emails = new Users_Emails('editemails');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user_datas') {
            echo CActiveForm::validate($model_emails);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Emails'])) {

            $model_emails->attributes = $_POST['Users_Emails'];
			$model_emails->user_id = Yii::app()->user->id;
			if($model_emails->save()){
				$this->redirect(array('/personal/editemails'));
			}
        }

        $this->render('editemails', array(
            'users_emails' => self::getUsersItems($model_emails),
            'model_emails' => $model_emails,
        ));
    }
	
	public function actionEditmessagers(){
	
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Manage instant messager services'))] = '';
	
		$model = new Users_Instmessagers();
		$user = Users::model()->findByPk(Yii::app()->user->id);
		
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users_instmessager') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
        if(isset($_POST['Users_Instmessagers'])) {
			
            $model->attributes = $_POST['Users_Instmessagers'];
			$model->user_id = Yii::app()->user->id;
			$model->status = 1;
			$model->type_id = 1; //default
			$model->is_master = 0;
			if(!$user->messagers){
				$model->is_master = 1;
			}
			$model->user_id = Yii::app()->user->id;
			if($model->save()){
				$this->redirect(array('/personal/editmessagers'));
			}
        }
		
        $this->render('editinstmessangers', array('model' => $model, 'user' => $user));
	}

    public function actionSaveemails()
    {

        $model_emails = new Users_Emails;

        if (Yii::app()->request->isAjaxRequest) {

            if (CActiveForm::validate($model_emails) == '[]') {

                self::saveUsersEmails($_POST['email'], $_POST['type']);
                self::removeUsersItems($_POST['delete'], $model_emails);

                if(isset($_POST['type_edit'])){
                    self::editTypeItems($_POST['type_edit'], $model_emails);
                }

                $html = $this->renderPartial('_emails', array(
                        'users_emails' => self::getUsersItems($model_emails),
                        'model_emails' => $model_emails,
                    ), true, false
                );

                echo CJSON::encode(array('success' => true, 'html' => $html));
            } else {
                echo CActiveForm::validate($model_emails);
            }

            Yii::app()->end();

        }
    }


    public function actionEditphones()
    {

		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Manage phones'))] = '';
	
        $model_phones = new Users_Phones('editphones');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user_datas') {
            echo CActiveForm::validate($model_phones);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Phones'])) {
			$model_phones->attributes = $_POST['Users_Phones'];
			$model_phones->user_id = Yii::app()->user->id;
			if($model_phones->save()){
				$this->redirect(array('/personal/editphones'));
			}

            Yii::app()->end();
        }

        $this->render('editphones', array(
            'users_phones' => self::getUsersItems($model_phones),
            'model_phones' => $model_phones,
        ));
    }

    public function actionSavephones()
    {

        $model_phones = new Users_Phones;

        if (Yii::app()->request->isAjaxRequest) {

            if (CActiveForm::validate($model_phones) == '[]') {

                self::saveUsersPhones($_POST['phone'], $_POST['type']);
                self::removeUsersItems($_POST['delete'], $model_phones);

                if(isset($_POST['type_edit'])){
                    self::editTypeItems($_POST['type_edit'], $model_phones);
                }

                $html = $this->renderPartial('_phones', array(
                        'users_phones' => self::getUsersItems($model_phones),
                        'model_phones' => $model_phones,
                    ), true, false
                );

                echo CJSON::encode(array('success' => true, 'html' => $html));
            } else {
                echo CActiveForm::validate($model_phones);
            }

            Yii::app()->end();

        }
    }


    public function actionEditaddress()
    {

		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Manage addresses'))] = '';
	
        $model = new Users_Address('editaddress');
		$user = Users::model()->findByPk(Yii::app()->user->id);

        if (Yii::app()->request->isAjaxRequest && isset($_POST['ajax']) && isset($_POST['Users_Address'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Address'])) {
			if(isset($_POST['Users_Address']['id'])){
				$model = Users_Address::model()->findByPk($_POST['Users_Address']['id']);
				if($model->user_id != Yii::app()->user->id){
					throw new CHttpException(404, Yii::t('Front', 'Page not found'));
				}
			}
			$model->attributes = $_POST['Users_Address'];
            if($model->save()){
				$this->redirect(array('/personal/editaddress'));
			}

            Yii::app()->end();
        }

        $this->render('editaddress', array('user' => $user, 'model' => $model));
    }

    public function actionSaveaddress()
    {

        $model_address = new Users_Address;

        if (Yii::app()->request->isAjaxRequest) {

            if (CActiveForm::validate($model_address) == '[]') {

                self::saveUsersAddress($_POST);
                self::removeUsersItems($_POST['delete'], $model_address);

                if(isset($_POST['type_edit'])){
                    self::editTypeItems($_POST['type_edit'], $model_address);
                }

                $html = $this->renderPartial('_address', array(
                        'users_address' => self::getUsersItems($model_address),
                        'model_address' => $model_address,
                    ), true, false
                );

                echo CJSON::encode(array('success' => true, 'html' => $html));
            } else {
                echo CActiveForm::validate($model_address);
            }

            Yii::app()->end();

        }
    }

	public function actionEditname(){
	
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Information Management'))] = '';
	
		//$model = Users::model()->findByPk(Yii::app()->user->id);

		$files1 = Users_Files::model()->findAll('form = "editname" AND document = 1 AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id));
		$files2 = Users_Files::model()->findAll('form = "editname" AND document = 2 AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id));
		$model = new Form_Editname_File;

		if (Yii::app()->getRequest()->isAjaxRequest && (Yii::app()->getRequest()->getParam('ajax') == 'editname-from-1' || Yii::app()->getRequest()->getParam('ajax') == 'editname-from-2')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Form_Editname_File']) && Yii::app()->request->isAjaxRequest){
			if(CActiveForm::validate($model) != '[]'){
				echo CActiveForm::validate($model);
			} else {
				foreach($_POST['Form_Editname_File']['files'] as $file){
					$document = $_POST['Form_Editname_File']['document'];
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

		if(Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('success') == 'true'){
			$success = true;
			if(empty($files1) || empty($files1)){
				$success = false;
			} else {
				foreach($files1 as $file){
					if(!$file->document_type){
						$success = false;
					}
				}
				foreach($files2 as $file){
					if(!$file->document_type){
						$success = false;
					}
				}
			}

			if($success){
				$personalEdit = new Users_Personal_Edit();
				$personalEdit->user_id = Yii::app()->user->id;
				$personalEdit->save();
				Yii::log('User was change personal information', CLogger::LEVEL_INFO);
				echo CJSON::encode(array('success' => true));
			}
			Yii::app()->end();
		}

		$this->render('_editname', array('model' => $model, 'files1' => $files1, 'files2' => $files2));
	}

	public function actionUploadFile(){
		Yii::import("application.ext.EAjaxUpload.qqFileUploader");
		$documentNum = Yii::app()->request->getParam('doc','int');
		$countFiles = Users_Files::model()->count('form = "editname" AND document = :docNumb AND user_id = :user_id AND deleted = 0', array(':user_id' => Yii::app()->user->id, ':docNumb' => $documentNum));
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
			$file->form = 'editname';
			$file->user_file_name = $uploader->getUserFileName();
			$file->document = $documentNum;
			if(!$file->save()){
				dd($file->getErrors());
			}
		}

		echo $return;// it's array
		Yii::app()->end();
	}
	
	public function actionResendSms($id){
		$model = Users_Phones::model()->findByPk($id);
		if($model->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		
		if($model->status == 1 && $model->is_master == 0 && $model->hash){
			$model->generateHash();
			$model->save();
			if(Yii::app()->sms->to($model->user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1){
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			} else {
				echo CJSON::encode(array('success' => true, 'hash' => $model->hash));
			}
		} elseif($model->status == 0 && $model->is_master == 0 && $model->hash){
			$user = Users::model()->findByPk(Yii::app()->user->id);
			$model->generateHash();
			$model->save();
			if(Yii::app()->sms->to($user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1){
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			} else {
				echo CJSON::encode(array('success' => true, 'hash' => $model->hash));
			}

		}
		
		
		if(Yii::app()->sms->to($model->user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1){
			Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
		} else {
			echo CJSON::encode(array('success' => true, 'hash' => $model->hash));
		}
	}
	
	public function actionResendEmail($id){
		$model = Users_Emails::model()->findByPk($id);
		if($model->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		
		if($model->status == 1 && $model->is_master == 0 && $model->hash){
			$model->generateHash();
			$model->save();
			$mail = new Mail;
			$mail->send(
				$model->user, // this user
				'emailMakePrimary', // sys mail code
				array( // params
					'{:type}' => 'email',
					'{:date}' => date('Y m d', time()),
					'{:activateUrl}' => Yii::app()->getBaseUrl(true).Yii::app()->createUrl('/personal/activate',
						array(
							'type' => 'emails',
							'hash' => $model->hash,
						)),
				)

			);
			echo CJSON::encode(array('success' => true, 'hash' => $model->hash));
		} elseif($model->status == 0 && $model->is_master == 0 && $model->hash){
			$user = Users::model()->findByPk(Yii::app()->user->id);
			$model->generateHash();
			$model->save();
			$mail = new Mail;
			$mail->send(
				$model->user, // this user
				'emailConfirm', // sys mail code
				array( // params
					'{:type}' => 'emails',
					'{:date}' => date('Y m d', time()),
					'{:activateUrl}' => Yii::app()->getBaseUrl(true).Yii::app()->createUrl('/personal/activate', array('type' => 'emails', 'hash' => $model->hash)),
				),
				$model->email
			);
			echo CJSON::encode(array('success' => true, 'hash' => $model->hash));

		}
	}

	public function actionMakePrimary($type, $id){
		$model = Users::getModelByType($type)->findByPk($id);
		if(!$model || $model->user_id != Yii::app()->user->id || $model->status == 0 || $model->is_master == 1){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}

		$reload = false;
		$message = false;

		if($type == 'emails'){
			$model->generateHash();
			$model->save();
			$mail = new Mail;
			$mail->send(
				$model->user, // this user
				'emailMakePrimary', // sys mail code
				array( // params
					'{:type}' => 'email',
					'{:date}' => date('Y m d', time()),
					'{:activateUrl}' => Yii::app()->getBaseUrl(true).Yii::app()->createUrl('/personal/activate',
						array(
							'type' => $type,
							'hash' => $model->hash,
						)),
				)

			);
			$message = Yii::t('Front', 'We send you confirmation email');
		} elseif($type == 'phones') {
			$model->generateHash();
			$model->save();
			$reload = true;
			if(count($model->user->phones) > 1){
				if(Yii::app()->sms->to($model->user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1){
					Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
				}
				$message = Yii::t('Front', 'We send you confirmation sms to mobile');
			} else {
				if($model->status == 1 && $model->is_master == 0){
					$model->is_master = 1;
					$model->hash = '';
					$model->save();
					Yii::app()->user->addNotification(
						'activate_new_'.$model->id, //код
						'You have successfully change primary '.$type,
						'close', // возможность закрыть
						'green' //желтая рамка
					);
				}
			}
		} elseif($type == 'socials'){
			Users_Socials::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::app()->user->id));
			Users_Socials::model()->updateByPk($id, array('is_master' => 1));
			$reload = true;
		} elseif($type == 'instmessagers'){
			Users_Instmessagers::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::app()->user->id));
			Users_Instmessagers::model()->updateByPk($id, array('is_master' => 1));
			$reload = true;
		} elseif($type == 'address'){
			Users_Address::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::app()->user->id));
			Users_Address::model()->updateByPk($id, array('is_master' => 1));
			$reload = true;
		}

		echo CJSON::encode(array('success' => true, 'message' => $message, 'reload' => $reload));
	}
	
	public function actionChangeType($type){
		$row_id = Yii::app()->request->getParam('row_id', '', 'int');
		$type_id = Yii::app()->request->getParam('type_id', '', 'int');
		
		$model = Users::getModelByType($type)->findByPk($row_id);
		$model->type_id = $type_id;
		$model->save();
		
		echo CJSON::encode(array('success' => true));
	}

    public function actionActivate($type){
		/*if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}*/
		$model = Users::getModelByType($type)
					->find('user_id = :user_id AND hash = :hash',
						array(
							':user_id' => Yii::app()->user->id,
							':hash' => Yii::app()->request->getParam('hash')
						)
					);
		if(!$model){
			echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Activate code is incorrect')));
			Yii::app()->end();
		}

		if($model->status == 1 && $model->is_master == 0){
			$master = Users::getModelByType($type)->find('user_id = :uid AND is_master = 1', array(':uid' => Yii::app()->user->id));
			$model->is_master = 1;
			if($type == 'emails'){
				$model->user->email = $model->email;
			} elseif($type == 'phones'){
				$model->user->phone = $model->phone;
			}
			$model->hash = '';
			if(!$model->user->validate()){
				echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'This '.$type.' primary for another account')));
				Yii::app()->end();
			}
			if($model->user->save()){
				if($master){
					$master->is_master = 0;
					$master->save();
				}
				$model->save();
				if($type == 'emails'){
					Yii::app()->user->addNotification(
						'is_master_new_'.$type, //код
						$type.' "'. $model->user->email .'" is primary',
						'close', // возможность закрыть
						'green' //желтая рамка
					);
				} elseif($type == 'phones') {
					Yii::app()->user->addNotification(
						'is_master_new_'.$type, //код
						'Phone "'. $model->user->phone .'" is primary',
						'close', // возможность закрыть
						'green' //желтая рамка
					);
				}

			}
		} elseif($model->status == 0 && $model->is_master == 0) {
			$model->hash = '';
			$model->status = 1;
			$model->is_master = 0;
			$model->save();
			if($type == 'phones'){
				Yii::app()->user->removeNotification('mobile_activation');
			}
			Yii::app()->user->addNotification(
				'activate_new_'.$model->id, //код
				'You have successfully activated new '.$type,
				'close', // возможность закрыть
				'green'
			);
		}

		if(Yii::app()->request->isAjaxRequest){
			echo CJSON::encode(array('success' => true));
		} else {
			$this->redirect(array('/banking/index'));
		}
		Yii::app()->end();
    }


    /**
     * @param $model
     * @param array $fields какие поля выводить
     * @return mixed
     */
    private static function getUsersItems($model, array $fields = array('*'))
    {
        //return Users::model()->with('emails')->findByPk(Yii::app()->user->id);
        //$model->emails;

       return $model->findAll(array(
            'select' => implode(',', $fields),
            'condition' => 'user_id=:user_id',
            'params' => array(':user_id' => Yii::app()->user->id),
            'order' => 'id',
       ));
    }

    /**
     * @param array $arr_post_delete
     * @param $model
     * @return bool
     */
    private static function removeUsersItems(array $arr_post_delete, $model)
    {
        foreach ($arr_post_delete as $k => $v) {
            if ((int)$v === 1) {
                $res = $model->findByPk((int)$k);
                if ($res && !$res->is_master) {
                    $res->delete();
                }
            }
        }
        return true;
    }



    private static function editTypeItems(array $arr_post_type, $model)
    {
       foreach ($arr_post_type as $k => $v) {
            if (!empty($v) && !empty($k)) {
                $res = $model->findByPk($k);
                if ($res) {
                    $res->email_type_id = $v;
                    $res->save();
                   /*if(!$res->save()){
                       print_r( $res->getErrors());
                       die;
                   }*/
                }
            }
        }
        return true;
    }
	
    /**
     * Сохранение емейлов
     * @param array $arr_post_email POST емейлов
     * @param array $arr_post_type POST типов емейла
     * @return bool
     */
    private static function saveUsersEmails(array $arr_post_email, array $arr_post_type)
    {
        foreach ($arr_post_email as $k => $email) {
            if (!empty($email)) {
                $model_emails = new Users_Emails;
                $model_emails->email = $email;
                $model_emails->user_id = Yii::app()->user->id;
                $model_emails->email_type_id = (int)$arr_post_type[$k];
                //$model_emails->save();
                if($model_emails->save()){
                    $mail = new Mail;
                    $mail->send(
                        $model_emails->user, // this user
                        'emailConfirm', // sys mail code
                        array( // params
							'{:type}' => 'emails',
                            '{:date}' => date('Y m d', time()),
                            '{:activateUrl}' => Yii::app()->getBaseUrl(true).Yii::app()->createUrl('/personal/activate', array('type' => 'emails', 'hash' => $model_emails->hash)),
                        ),
                        $model_emails->email
                    );

                }

            }
        }
        return true;
    }

    private static function saveUsersPhones(array $arr_post_phone, array $arr_post_type)
    {
        foreach ($arr_post_phone as $k => $phone) {
            if (!empty($phone)) {
                $model_phones = new Users_Phones;
                $model_phones->phone = $phone;
                $model_phones->user_id = Yii::app()->user->id;
                $model_phones->email_type_id = (int)$arr_post_type[$k];
                if($model_phones->save()){
					if(Yii::app()->sms->to($model_phones->phone)->body('Your activate code: {code}', array('{code}' => $model_phones->hash))->send() != 1){
						Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
					}
				}
            }
        }
        return true;
    }

    /**
     * @param array $arr_post_address
     * @param array $arr_post_type
     * @return bool
     */
    private static function saveUsersAddress(array $post)
    {
        foreach ($post['address'] as $k => $adr) {
            if (!empty($adr)) {
                $model_address = new Users_Address;

                $model_address->address = $adr;

                if (!empty($post['address_optional'][$k])) {
                    $model_address->address_optional = $post['address_optional'][$k];
                }
                if (!empty($post['indx'][$k])) {
                    $model_address->indx = $post['indx'][$k];
                }
                if (!empty($post['city'][$k])) {
                    $model_address->city = $post['city'][$k];
                }
                if (!empty($post['country_id'][$k])) {
                    $model_address->country_id = (int)$post['country_id'][$k];
                }
                if (!empty($post['type'][$k])) {
                    $model_address->email_type_id = (int)$post['type'][$k];
                }

                $model_address->user_id = Yii::app()->user->id;

                $model_address->save();
            }
        }
        return true;

    }

	public function actionTestSms(){
		
	}

    public function actionEditSocials(){
	
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Manage soccial networks'))] = '';
	
		$service = Yii::app()->request->getQuery('service');
        if (isset($service)) {

            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = $this->createAbsoluteUrl('/personal/editsocials');
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('/personal/editsocials');


            if ($authIdentity->authenticate()) {
                $identity = new EAuthUserIdentity($authIdentity);

                // successful authentication
                if ($identity->authenticate()) {
                    Yii::app()->user->login($identity);
                    if($identity->addNewSocial){
                        Users_Providers::addSocialToUser($identity, Yii::app()->user->getId());
                    }
                    // special redirect with closing popup window
                    $authIdentity->redirect();
                } elseif ($identity->errorCode == EAuthUserIdentity::ERROR_USER_NOT_REGISTERED) {
                    Users_Providers::addSocialToUser($identity, Yii::app()->user->getId());
                    $authIdentity->redirect();
                } else {
                    // close popup window and redirect to cancelUrl
                    $authIdentity->cancel();
                }
            }

//            $errors = array('message' => 'user was not login from ' . $service);
//            Yii::log($errors, CLogger::LEVEL_INFO);

            // Something went wrong, redirect to login page
            $this->redirect($this->createAbsoluteUrl('/personal/editsocials'));
        }

        $this->render('editSocials');
    }
	
	public function actionEditQustions(){
	
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal'))] = array('/personal/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Manage Security Questions'))] = '';
	
		$model = new Users_Securityquestions();
		$user = Users::model()->findByPk(Yii::app()->user->id);

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users_securityquestions') {
			$error = CActiveForm::validate($model);
			if($error == '[]'){
				if($user->questions){
					$model->addError('Users_Securityquestions_answer', Yii::t('Front', 'You have reached the required limit for security questions. In order to add new questions, you need to delete the existing ones'));
					echo CJSON::encode($model->getErrors());
					Yii::app()->end();
				}
			}
			echo $error;
            Yii::app()->end();
        }

        if (isset($_POST['Users_Securityquestions'])) {
			$model->attributes = $_POST['Users_Securityquestions'];
			$model->user_id = Yii::app()->user->id;
			if($user->questions){
				$model->addError('Users_Securityquestions_answer', Yii::t('Front', 'You have reached the required limit for security questions. In order to add new questions, you need to delete the existing ones'));
				echo CJSON::encode($model->getErrors());
				Yii::app()->end();
			}
			if($model->save()){
				$this->redirect(array('/personal/editqustions'));
			}
            Yii::app()->end();
        }

        $this->render('editqustions', array('model' => $model, 'user' => $user));
	}
	
	public function actionDelete($id){
		$type = Yii::app()->request->getParam('type', '', 'list', array('social','messager','phones','question', 'emails', 'address'));
		if(!$type && !$id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$return = true;
		switch($type){
			case 'social':
				$soc = Users_Socials::model()->findByPk($id);
				if($soc){
					$soc->getProvider()->delete();
					$soc->delete();
				}
				break;
			case 'messager':
				$mes = Users_Instmessagers::model()->findByPk($id);
				$mes->delete();
				break;
			case 'phones':
				$mes = Users_Phones::model()->findByPk($id);
				if($mes->user->phone != $mes->phone){
					$mes->delete();
				} else {
					$return = false;
				}
				break;
			case 'emails':
				$mes = Users_Emails::model()->findByPk($id);
				if($mes->user->email != $mes->email){
					$mes->delete();
				} else {
					$return = false;
				}
				break;
			case 'question':
				$qust = Users_Securityquestions::model()->findByPk($id);
				if($qust->user_id == Yii::app()->user->id){
					$qust->delete();
				}
				break;
			case 'address':
				$addr = Users_Address::model()->findByPk($id);
				if($addr->user_id == Yii::app()->user->id && $addr->is_master != 1){
					$addr->delete();
				} else {
					$return = false;
				}
				break;
				
		}

		echo CJSON::encode(array('success' => $return));
	}

}