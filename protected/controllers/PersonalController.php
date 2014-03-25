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
                ),
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
        $model_emails = new Users_Emails();
        $model_phones = new Users_Phones();
        $model_address = new Users_Address();
		
		$model = Users::model()->findByPk(Yii::app()->user->id);

        $this->render('index', array(
			'model' => $model,
            'users_emails' => self::getUsersItems($model_emails),
            'users_phones' => self::getUsersItems($model_phones),
            'users_address' => self::getUsersItems($model_address),
        ));
    }

    public function actionEditemails()
    {

        $model_emails = new Users_Emails('editemails');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user_datas') {
            echo CActiveForm::validate($model_emails);
            Yii::app()->end();
        }

        if (Yii::app()->request->isAjaxRequest && isset($_POST['Users_Emails'])) {

            if (CActiveForm::validate($model_emails) == '[]') {
                echo CJSON::encode(array('success' => true));
            } else {
                echo CActiveForm::validate($model_emails);
            }

            Yii::app()->end();
        }

        $this->render('editemails', array(
            'users_emails' => self::getUsersItems($model_emails),
            'model_emails' => $model_emails,
        ));
    }

    public function actionSaveemails()
    {

        $model_emails = new Users_Emails;

        if (Yii::app()->request->isAjaxRequest) {

            if (CActiveForm::validate($model_emails) == '[]') {

                self::saveUsersEmails($_POST['email'], $_POST['type']);
                self::removeUsersItems($_POST['delete'], $model_emails);

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

        $model_phones = new Users_Phones('editephones');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user_datas') {
            echo CActiveForm::validate($model_phones);
            Yii::app()->end();
        }

        if (Yii::app()->request->isAjaxRequest && isset($_POST['Users_Phones'])) {

            if (CActiveForm::validate($model_phones) == '[]') {
                echo CJSON::encode(array('success' => true));
            } else {
                echo CActiveForm::validate($model_phones);
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

        $model_address = new Users_Address('editaddress');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user_datas') {
            echo CActiveForm::validate($model_address);
            Yii::app()->end();
        }

        if (Yii::app()->request->isAjaxRequest && isset($_POST['Users_Address'])) {

            if (CActiveForm::validate($model_address) == '[]') {
                echo CJSON::encode(array('success' => true));
            } else {
                echo CActiveForm::validate($model_address);
            }

            Yii::app()->end();
        }

        $this->render('editaddress', array(
            'users_address' => self::getUsersItems($model_address),
            'model_address' => $model_address,
        ));
    }

    public function actionSaveaddress()
    {

        $model_address = new Users_Address;

        if (Yii::app()->request->isAjaxRequest) {

            if (CActiveForm::validate($model_address) == '[]') {

                self::saveUsersAddress($_POST);
                self::removeUsersItems($_POST['delete'], $model_address);

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

    public function actionActivate()
    {
        $hash = Yii::app()->getRequest()->getQuery('hash');
        die;
    }


    /**
     * @param $model
     * @param array $fields какие поля выводить
     * @return mixed
     */
    private static function getUsersItems($model, array $fields = array('*'))
    {
        //$model = Users::model()->with('email')->findByPk(Yii::app()->user->id);
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
                if ($res) {
                    $res->delete();
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
							'{:type}' => 'email',
                            '{:date}' => date('Y m d', time()),
                            '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/'.Yii::app()->createUrl('/personal/activate', array('type' => 'email', 'hash' => $model_emails->hash)),
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
                $model_phones->save();
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
        $adress = $post['address'];
        $address_optional = $post['address_optional'];
        $indx = $post['indx'];
        $city = $post['city'];
        $country_id = $post['country_id'];
        $type = $post['type'];

        foreach ($adress as $k => $adr) {
            if (!empty($adr)) {
                $model_address = new Users_Address;
                $model_address->address = $adr;
                if (!empty($address_optional[$k])) {
                    $model_address->address_optional = $address_optional[$k];
                }
                $model_address->indx = $indx[$k];
                $model_address->city = $city[$k];
                $model_address->country_id = $country_id[$k];

                $model_address->user_id = Yii::app()->user->id;
                $model_address->email_type_id = (int)$type[$k];

                $model_address->save();
            }
        }
        return true;

    }

}