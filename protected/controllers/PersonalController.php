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
                'actions' => array(
                    'index',
                    'editemails',
                    'saveemails',
                    'editphones',
                    'savephones',
                    'editaddress',
                    'saveaddress',
                    'editname',
                    'personal',
                    'uploadfile',
                    'activate',
                    'makeprimary',
                    'cancelmakeprimary',
                    'editsocials',
                    'delete',
                    'cancel',
                    'editmessagers',
                    'changetype',
                    'resendsms',
                    'editqustions',
                    'resendemail',
                    'editpins',
                    'settings',
                    'alerts',
                    'updatealerts',
                    'dropalerts',
                    'paymentinstuments',
                    'deletePaymentInstument',
                    'newsletter',
                    'uploaduserphoto',
                    'other',
                    'accounts',
                    'resendsmsforchangeid',
                    'forgotPass',
                ),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function init()
    {
        if (!Yii::request()->isAjaxRequest && !Yii::request()->getParam('ajax')) {
            Yii::app()->clientScript->registerScriptFile('/js/personal.js');
        }
        return parent::init();
    }

    public function actionIndex()
    {


        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = '';
        $model = Users::model()->with(array(
//            'primary_email',
//            'primary_address',
//            'primary_phone',
//            'primary_paymentsmethod',
            'accounts',
        ))->findByPk(Yii::app()->user->id, array('order' => 'accounts.is_master desc'));
        if (Yii::request()->isAjaxRequest) {
            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('tabversion/_overview', array('model' => $model), true, true),
            ));
            Yii::app()->end();
        }

        $this->render('tabversion/index', array('model' => $model));
    }

    public function actionAccounts()
    {
        $model = $model = Users::model()->with(array(
            'accounts',
        ))->findByPk(Yii::app()->user->id, array('order' => 'accounts.is_master desc'));

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial('tabversion/_accounts', array('model' => $model), true, true),
        ));
        Yii::app()->end();
    }

    public function actionEditemails()
    {

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My E-Mail addresses'))] = '';

        $model_emails = new Users_Emails('editemails');

        if (Yii::request()->getParam('ajax')) {
            echo CActiveForm::validate($model_emails);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Emails'])) {

            $model_emails->attributes = $_POST['Users_Emails'];
            $model_emails->user_id = Yii::app()->user->id;

            if ($model_emails->save()) {

                $data_categories = Users_Categories::model()->findAll(
                    array(
                        'condition' => 'data_type = "users_emails" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                        'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
                    )
                );

                $mail = new Mail;
                $mail->send(
                    $model_emails->user, // this user
                    'emailConfirm', // sys mail code
                    array( // params
                        '{:type}' => 'emails',
                        '{:date}' => date('Y m d', time()),
                        '{:activateUrl}' => Yii::app()->getBaseUrl(true) . Yii::app()->createUrl('/personal/activate', array('type' => 'emails', 'hash' => $model_emails->hash)),
                    ),
                    $model_emails->email
                );

                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_emails',
                            array(
                                'users_emails' => self::getUsersItems($model_emails),
                                'model_emails' => $model_emails,
                                'data_categories' => $data_categories,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'We sent confirmation email to :email', array(':email' => $model_emails->email)),
                ));
                Yii::app()->end();
            } else {
                echo CJSON::encode(array(
                    'success' => false,
                    'message' => Yii::t('Personal', array_shift(array_shift($model_emails->getErrors())))
                ));
                Yii::app()->end();
            }
        }

        $data_categories = Users_Categories::model()->findAll(
            array(
                'condition' => 'data_type = "users_emails" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
            )
        );

        if (Yii::request()->isAjaxRequest) {

            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('tabversion/_emails', array(
                        'users_emails' => self::getUsersItems($model_emails),
                        'model_emails' => $model_emails,
                        'data_categories' => $data_categories,
                    ), true, true)
            ));
            Yii::app()->end();
        }

//        $this->render('editemails', array(
//            'users_emails' => self::getUsersItems($model_emails),
//            'model_emails' => $model_emails,
//        ));
    }

    /**
     * @param       $model
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
            'order' => 'is_master desc, id',
        ));
    }

    public function actionEditmessagers()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My instant messengers'))] = '';

        $model = new Users_Instmessagers();
        $user = Users::model()->findByPk(Yii::app()->user->id);

        $messengers = InstmessagerSystems::model()->findAll('status = 1');

        if (!empty($_POST['Users_Instmessagers']['id'])) {
            $model = Users_Instmessagers::model()->ownUser()->findByPk($_POST['Users_Instmessagers']['id']);
        }

        if (Yii::request()->getParam('ajax')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Instmessagers'])) {
            $model->attributes = $_POST['Users_Instmessagers'];
            $model->user_id = Yii::app()->user->id;
            $model->status = 1;
            if (!$user->messagers) {
                $model->is_master = 1;
            }
            if (!$model->category_id) {
                $model->category_id = NULL;
            }
            $model->user_id = Yii::app()->user->id;
            if ($model->save()) {

                $data_categories = Users_Categories::model()->findAll(
                    array(
                        'condition' => 'data_type = "users_instmessagers" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                        'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
                    )
                );

                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_instmess',
                            array(
                                'model' => new Users_Instmessagers(),
                                'user' => Users::model()->findByPk(Yii::app()->user->id),
                                'messengers' => $messengers,
                                'data_categories' => $data_categories,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'Inst Messenger was saved'),
                ));
                Yii::app()->end();

            }
        }

        $data_categories = Users_Categories::model()->findAll(
            array(
                'condition' => 'data_type = "users_instmessagers" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                'params' =>
                    array(
                        ':uid' => Yii::user()->id,
                        ':lang' => Yii::app()->language
                    ),
            )
        );

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial(
                    'tabversion/_instmess',
                    array(
                        'model' => new Users_Instmessagers(),
                        'user' => $user,
                        'messengers' => $messengers,
                        'data_categories' => $data_categories,
                    ),
                    true,
                    true
                ),
        ));
        Yii::app()->end();
    }

    public function actionEditphones()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My phone numbers'))] = '';

        $model_phones = new Users_Phones('editphones');
        $model_telephones = new Users_Telephones;
        $user = Users::model()->findByPk(Yii::app()->user->id);

        $data_categories = Users_Categories::model()->findAll(
            array(
                'condition' => '(user_id is NULL OR user_id = :uid)',
                'params' => array(
                    ':uid' => Yii::user()->id,
                ),
            )
        );

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'personal-mobilephones') {
            echo CActiveForm::validate($model_phones);
            Yii::app()->end();
        }
        if (isset($_POST['Users_Phones'])) {
            $model_phones->attributes = $_POST['Users_Phones'];
            $model_phones->user_id = Yii::app()->user->id;
            $phone = $model_phones->phone;
            if ($model_phones->save()) {

                if (Yii::app()->sms->to($phone)->body('Your activate code: {code}', array('{code}' => $model_phones->hash))->send() != 1) {
                    Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
                }

                $model_phones = new Users_Phones('editphones');
                $this->cleanResponseJs();
                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_phones',
                            array(
                                'users_phones' => self::getUsersItems($model_phones),
                                'model_telephones' => $model_telephones,
                                'user' => $user,
                                'model_phones' => $model_phones,
                                'data_categories' => $data_categories,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'We sent confirmation sms to :phone', array(':phone' => $phone)),
                ));
                Yii::app()->end();

//                $this->redirect(array('/personal/editphones'));
            }

            Yii::app()->end();
        }

        if (isset($_POST['ajax']) && Yii::request()->getParam('Users_Telephones')) {
            echo CActiveForm::validate($model_telephones);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Telephones'])) {
            if (isset($_POST['Users_Telephones']['id'])) {
                $model_telephones = Users_Telephones::model()->currentUser()->findByPk($_POST['Users_Telephones']['id']);
            }

            $model_telephones->attributes = $_POST['Users_Telephones'];
            $model_telephones->user_id = Yii::app()->user->id;
            if ($model_telephones->save()) {

                $data_categories = Users_Categories::model()->findAll(
                    array(
                        'condition' => '(user_id is NULL OR user_id = :uid)',
                        'params' => array(
                            ':uid' => Yii::user()->id,
                        ),
                    )
                );
                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_phones',
                            array(
                                'users_phones' => self::getUsersItems($model_phones),
                                'model_telephones' => new Users_Telephones(),
                                'user' => $user,
                                'data_categories' => $data_categories,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'New telephone was successfully saved'),
                ));
                Yii::app()->end();

//                Yii::app()->session['flash_notify'] = array(
//                    'title' => Yii::t('Front', 'Personal Cabinet'),
//                    'message' => Yii::t('Front', 'New phone number was added'),
//                );
//
//                $this->redirect(array('/personal/editphones'));
            }
            Yii::app()->end();
        }

        if (Yii::request()->isAjaxRequest) {

            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('tabversion/_phones', array(
                        'users_phones' => self::getUsersItems($model_phones),
                        'model_telephones' => $model_telephones,
                        'user' => $user,
                        'model_phones' => $model_phones,
                        'data_categories' => $data_categories,
                    ), true, true)
            ));
            Yii::app()->end();
        }

//        $this->render('editphones', array(
//            'users_phones' => self::getUsersItems($model_phones),
//            'model_telephones' => $model_telephones,
//            'user' => $user,
//            'model_phones' => $model_phones,
//        ));
    }

//    /**
//     * @param array $arr_post_delete
//     * @param       $model
//     * @return bool
//     */
//    private static function removeUsersItems(array $arr_post_delete, $model)
//    {
//        foreach ($arr_post_delete as $k => $v) {
//            if ((int)$v === 1) {
//                $res = $model->findByPk((int)$k);
//                if ($res && !$res->is_master) {
//                    $res->delete();
//                }
//            }
//        }
//        return true;
//    }
//
//    private static function editTypeItems(array $arr_post_type, $model)
//    {
//        foreach ($arr_post_type as $k => $v) {
//            if (!empty($v) && !empty($k)) {
//                $res = $model->findByPk($k);
//                if ($res) {
//                    $res->email_type_id = $v;
//                    $res->save();
//                    /*if(!$res->save()){
//                        print_r( $res->getErrors());
//                        die;
//                    }*/
//                }
//            }
//        }
//        return true;
//    }

    public function actionEditaddress()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My addresses'))] = '';

        $model = new Users_Address('editaddress');
        $user = Users::model()->findByPk(Yii::app()->user->id);

        if (Yii::app()->request->isAjaxRequest && isset($_POST['ajax']) && isset($_POST['Users_Address'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $countries = Countries::model()->findAll();

        if (isset($_POST['Users_Address'])) {
            if (isset($_POST['Users_Address']['id']) && $_POST['Users_Address']['id']) {
                $model = Users_Address::model()->findByPk($_POST['Users_Address']['id']);
                if ($model->user_id != Yii::app()->user->id) {
                    throw new CHttpException(404, Yii::t('Front', 'Page not found'));
                }
            }
            $model->attributes = $_POST['Users_Address'];
            if ($model->isNewRecord) {
                $model->user_id = Yii::app()->user->id;
            }
            $model->status = 1;
            if ($model->save()) {


                $data_categories = Users_Categories::model()->findAll(
                    array(
                        'condition' => '(user_id is NULL OR user_id = :uid)',
                        'params' => array(
                            ':uid' => Yii::user()->id,
                        ),
                    )
                );
                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_address',
                            array(
                                'model' => new Users_Address(),
                                'user' => $user,
                                'countries' => $countries,
                                'data_categories' => $data_categories,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'Address was successfully saved'),
                ));
                Yii::app()->end();

//                $this->redirect(array('/personal/editaddress'));
            }
            Yii::app()->end();
        }

        $data_categories = Users_Categories::model()->findAll(
            array(
                'condition' => '(user_id is NULL OR user_id = :uid)',
                'params' => array(
                    ':uid' => Yii::user()->id,
                ),
            )
        );

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial(
                    'tabversion/_address',
                    array(
                        'model' => new Users_Address(),
                        'user' => $user,
                        'countries' => $countries,
                        'data_categories' => $data_categories,
                    ),
                    true,
                    true
                ),
            'message' => Yii::t('Front', 'Address was successfully saved'),
        ));
        Yii::app()->end();
//        $this->render('tabversion/_address', array('user' => $user, 'model' => $model));
    }

    public function actionPersonal()
    {
        $model = Users::model()->findByPk(Yii::user()->id);

        $message = '';

        $lastXabinaId = Users_Ids::model()->ownUser()->find(
            array(
                'condition' => 'status = :pending',
                'order' => 'created_at desc',
                'params' => array(
                    ':pending' => Users_Ids::STATUS_PENDING,
                )
            )
        );
        if (!$lastXabinaId) {
            $lastXabinaId = new Users_Ids;
        }

//        if (Yii::request()->getParam('ajax') == 'user-change-id-form') {
//            echo CActiveForm::validate($lastXabinaId);
//            Yii::app()->end();
//        }

        $reload = false;

        if (isset($_POST['delete'])) {
            $lastXabinaId->scenario = 'delete';
            $lastXabinaId->status = Users_Ids::STATUS_CANCELED;
            $lastXabinaId->save();
        } elseif (Yii::request()->getParam('ajax') == 'user-change-id-form') {
            echo CActiveForm::validate($lastXabinaId);
            Yii::app()->end();
        } elseif (isset($_POST['Users_Ids']) && isset($_POST['Users_Ids']['compare_confirm_code']) && $lastXabinaId->status == Users_Ids::STATUS_PENDING) {
            $lastXabinaId->compare_confirm_code = $_POST['Users_Ids']['compare_confirm_code'];
            if ($lastXabinaId->validate()) {
                $lastXabinaId->status = Users_Ids::STATUS_APPROVE;
                $lastXabinaId->confirm_at = time();
                $lastXabinaId->save();
                $model->login = $lastXabinaId->new_user_id;
                if($model->save()){
                    $mail = new Mail;
                    $mail->send(
                        $model, // this user
                        'new_user_id', // sys mail code
                        array( // params
                            '{:login}' => $model->login,
                            '{:date}' => date('Y m d', time()),
                        )
                    );
                }
                $lastXabinaId = new Users_Ids;
                $reload = true;
            }
        } elseif (isset($_POST['Users_Ids'])) {

            $lastChange = Users_Ids::model()->ownUser()->find(
                array(
                    'condition' => 'status = :pending',
                    'order' => 'created_at desc',
                    'params' => array(
                        ':pending' => Users_Ids::STATUS_APPROVE,
                    )
                )
            );
            if ($lastChange && !$lastChange->getIsCanChange()) {
                return false;
            }

            $lastXabinaId->attributes = $_POST['Users_Ids'];
            $lastXabinaId->user_id = Yii::user()->id;
            $lastXabinaId->confirm_code = rand(100000, 999999);

            $message = Yii::t('Personal', 'Confirmation SMS was sent to + ***' . substr($model->phone, -3));

            if ($lastXabinaId->save()) {
                if (Yii::app()->sms->to($model->phone)->body('Confirmation code: {code}', array('{code}' => $lastXabinaId->confirm_code))->send() != 1) {
                    Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
                }
            }
        }

        $lastChange = Users_Ids::model()->ownUser()->find(
            array(
                'condition' => 'status = :pending',
                'order' => 'created_at desc',
                'params' => array(
                    ':pending' => Users_Ids::STATUS_APPROVE,
                )
            )
        );

        echo CJSON::encode(array(
            'html' => $this->renderPartial(
                    'tabversion/_personal',
                    array(
                        'model' => $model,
                        'lastXabinaId' => $lastXabinaId,
                        'lastChange' => $lastChange,
                    ), true, true),
            'success' => true,
            'message' => $message,
            'reloadWindow' => $reload,
        ));
    }

    public function actionUploadUserPhoto()
    {

        $model = Users::model()->findByPk(Yii::user()->id);

        if (isset($_FILES['Users']) && $_FILES['Users']['tmp_name']['photo']) {
            $image = Yii::app()->image->load($_FILES['Users']['tmp_name']['photo']);
            $image->resize(80, 80, Image::MAX)->crop(80, 80)->quality(75);
            $folder = Yii::app()->getBasePath(true) . '/../images/users/' . $model->id . '/';
            $name = md5(time()) . '.' . $image->getImageExt();
            @mkdir($folder, 0775, 1);
            $image->save($folder . $name);
            $model->photo = $name;
            if ($model->save()) {
                Yii::user()->getPhotoUrl(true);
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => Yii::t('Personal', 'Photo was successfully changed'),
                ));
                Yii::app()->end();
            }
        }
        if (isset($_POST['Users']) && isset($_POST['Users']['delete'])) {
            $model->photo = '';
            $model->save();

            Yii::user()->getPhotoUrl(true);

            echo CJSON::encode(array(
                'success' => true,
                'message' => Yii::t('Personal', 'Photo was successfully removed'),
            ));
            Yii::app()->end();
        }

        echo CJSON::encode(array(
            'success' => false,
            'message' => Yii::t('Personal', 'You not selected photo!'),
        ));
    }

    public function actionEditname()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My personal information'))] = '';

        //$model = Users::model()->findByPk(Yii::app()->user->id);

        $model = new Form_Editname_File;

        if (Yii::app()->getRequest()->isAjaxRequest && (Yii::app()->getRequest()->getParam('ajax') == 'editname-from-1' || Yii::app()->getRequest()->getParam('ajax') == 'editname-from-2')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Form_Editname_File']) && Yii::app()->request->isAjaxRequest) {
            if (CActiveForm::validate($model) != '[]') {
                echo CActiveForm::validate($model);
            } else {
                foreach ($_POST['Form_Editname_File']['files'] as $file) {
                    $document = $_POST['Form_Editname_File']['document'];
                    $fileModel = Users_Files::model()->find('user_id = :uid AND name = :name AND document = :document', array(':uid' => Yii::app()->user->id, ':name' => $file, ':document' => $document));
                    if ($fileModel) {
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

        $user = Users::model()->findByPk(Yii::app()->user->id);
        $this->render('editname', array('user' => $user, 'model' => $model));
    }

    public function actionResendSms($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $model = Users_Phones::model()->findByPk($id);
        if ($model->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        if ($model->status == 1 && $model->is_master == 0 && $model->hash) {
            $model->generateHash();
            $model->save();

            if (Yii::app()->sms->to($model->user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1) {
                Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
            } else {
                echo CJSON::encode(array('success' => true, 'message' => Yii::t('Front', 'Sms was sent to number :number. Hash code is :hashCode', array(':number' => $model->user->phone, ':hashCode' => $model->hash))));
                Yii::app()->end();
            }
        } elseif ($model->status == 0 && $model->is_master == 0 && $model->hash) {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $model->generateHash();
            $model->save();
            if (Yii::app()->sms->to($model->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1) {
                Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
            } else {
                echo CJSON::encode(array('success' => true, 'message' => Yii::t('Front', 'Sms was sent to number :number. Hash code is :hashCode', array(':number' => $model->phone, ':hashCode' => $model->hash))));
                Yii::app()->end();
            }

        }


        /*if(Yii::app()->sms->to($model->user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1){
            Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
        } else {
            echo CJSON::encode(array('success' => true, 'hash' => $model->hash));
            Yii::app()->end();
        }*/

        echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Undefined error')));
    }

    public function actionResendEmail($id)
    {
        $model = Users_Emails::model()->findByPk($id);
        if ($model->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }


        if ($model->status == 1 && $model->is_master == 0 && $model->hash) {
            $model->generateHash();
            $model->save();
            $mail = new Mail;
            $mail->send(
                $model->user, // this user
                'emailMakePrimary', // sys mail code
                array( // params
                    '{:type}' => 'email',
                    '{:date}' => date('Y m d', time()),
                    '{:activateUrl}' => Yii::app()->getBaseUrl(true) . Yii::app()->createUrl('/personal/activate',
                            array(
                                'type' => 'emails',
                                'hash' => $model->hash,
                            )),
                )

            );
            echo CJSON::encode(array('success' => true, 'hash' => $model->hash, 'message' => Yii::t('Front', 'We sent you a confirmation to email :email', array(':email' => $model->email))));
        } elseif ($model->status == 0 && $model->is_master == 0 && $model->hash) {
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
                    '{:activateUrl}' => Yii::app()->getBaseUrl(true) . Yii::app()->createUrl('/personal/activate', array('type' => 'emails', 'hash' => $model->hash)),
                ),
                $model->email
            );
            echo CJSON::encode(array('success' => true, 'hash' => $model->hash, 'message' => Yii::t('Front', 'We sent you an activation email')));

        }
    }

    public function actionMakePrimary($type, $id)
    {
        if ($type == 'accounts') {
            $model = Accounts::model()->ownUser()->findByPk($id);
        } else {
            $model = Users::getModelByType($type)->findByPk($id);
        }
        if (!$model || $model->user_id != Yii::app()->user->id || $model->status == 0 || $model->is_master == 1) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $reload = false;
        $message = false;
        $titleMess = false;
        $html = false;
        if ($type == 'emails') {
            $model->generateHash();
            Users_Emails::model()->updateAll(
                array(
                    'hash' => '',
                ),
                'status = 1 AND user_id = :uid',
                array(
                    ':uid' => Yii::user()->id
                )
            );
            $model->save();
            $mail = new Mail;
            $mail->send(
                $model->user, // this user
                'emailMakePrimary', // sys mail code
                array( // params
                    '{:type}' => 'email',
                    '{:date}' => date('Y m d', time()),
                    '{:activateUrl}' => Yii::app()->getBaseUrl(true) . Yii::app()->createUrl('/personal/activate',
                            array(
                                'type' => $type,
                                'hash' => $model->hash,
                            )),
                )

            );
            $reload = true;
            $message = Yii::t('Front', 'We sent you a confirmation email');
        } elseif ($type == 'phones') {
            Users_Phones::model()->updateAll(
                array(
                    'hash' => '',
                ),
                'status = 1 AND user_id = :uid',
                array(
                    ':uid' => Yii::user()->id
                )
            );

            $data_categories = Users_Categories::model()->findAll(
                array(
                    'condition' => 'data_type = "users_phones" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                    'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
                )
            );

            $model->generateHash();
            $model->save();
            $reload = false;
            if (count($model->user->phones) > 1) {
                if (Yii::app()->sms->to($model->user->phone)->body('Confirmation code: {code}', array('{code}' => $model->hash))->send() != 1) {
                    Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
                }
                $message = Yii::t('Front', 'We sent you a confirmation sms to mobile');
                $html = $this->renderPartial(
                    'tabversion/_phones',
                    array(
                        'users_phones' => self::getUsersItems($model),
                        'user' => Users::model()->findByPk(Yii::app()->user->id),
                        'model_phones' => $model,
                        'data_categories' => $data_categories,
                    ),
                    true,
                    true
                );
            } else {
                if ($model->status == 1 && $model->is_master == 0) {
                    $model->is_master = 1;
                    $model->hash = '';
                    $model->save();
//					Yii::app()->user->addNotification(
//						'activate_new_'.$model->id, //код
//						'You have successfully change primary '.$type,
//						'close', // возможность закрыть
//						'green' //желтая рамка
//					);
                }
            }
        } elseif ($type == 'socials') {
            Users_Socials::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::app()->user->id));
            Users_Socials::model()->updateByPk($id, array('is_master' => 1));
            $reload = true;
            $message = Yii::t('Front', 'Primary social network was changed');
        } elseif ($type == 'instmessagers') {
            Users_Instmessagers::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::app()->user->id));
            Users_Instmessagers::model()->updateByPk($id, array('is_master' => 1));
            $reload = true;
            $message = Yii::t('Front', 'Primary instant messenger was changed');
        } elseif ($type == 'address') {
            Users_Address::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::app()->user->id));
            Users_Address::model()->updateByPk($id, array('is_master' => 1));

            $data_categories = Users_Categories::model()->findAll(
                array(
                    'condition' => 'data_type = "users_phones" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                    'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
                )
            );

            $countries = Countries::model()->findAll();

            /*Yii::app()->session['flash_notify'] = array(
                'title' => Yii::t('Front', 'Personal Cabinet'),
                'message' => Yii::t('Front', 'Primary address was changed'),
            );*/
            $message = Yii::t('Front', 'Primary address was changed');
            $titleMess = Yii::t('Front', 'Personal Cabinet');
            $html = $this->renderPartial(
                'tabversion/_address',
                array(
                    'model' => new Users_Address(),
                    'user' => $model->user,
                    'countries' => $countries,
                    'data_categories' => $data_categories,
                ),
                true,
                true
            );
            //$reload = true;
        } elseif ($type == 'paymentInstruments') {
            Users_Paymentinstruments::model()->updateAll(array('is_master' => 0), 'user_id = :uid', array(':uid' => Yii::user()->id));
            Users_Paymentinstruments::model()->updateByPk($id, array('is_master' => 1));
            $reload = true;
            $message = Yii::t('Front', 'Primary method was changed');
        } elseif ($type == 'accounts') {
            Accounts::model()->ownUser()->updateAll(array('is_master' => 0));
            $model->is_master = 1;
            $model->save();
            $reload = true;
            $message = Yii::t('Front', 'Primary account was changed');
        }

        echo CJSON::encode(
            array(
                'success' => true,
                'message' => $message,
                'reload' => $reload,
                'titleMess' => $titleMess,
                'html' => $html
            )
        );
    }

    public function actionCancelMakePrimary($id)
    {
        $type = Yii::request()->getParam('type', '', 'list', array('emails', 'phones'));
        if ($type == 'accounts') {
            $model = Accounts::model()->ownUser()->findByPk($id);
        } else {
            $model = Users::getModelByType($type)->findByPk($id);
        }
        if (!$model || $model->user_id != Yii::app()->user->id || $model->status == 0 || $model->is_master == 1) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $model->hash = '';
        $model->save();

        echo CJSON::encode(array(
            'success' => true,
            'reload' => true,
        ));
    }

    public function actionChangeType($type)
    {
        $row_id = Yii::app()->request->getParam('row_id', '', 'int');
        $type_id = Yii::app()->request->getParam('type_id', '', 'int');

        $model = Users::getModelByType($type)->findByPk($row_id);
        $model->type_id = $type_id;
        $model->save();

        echo CJSON::encode(array('success' => true));
    }

    public function actionActivate($type)
    {
        /*if(!Yii::app()->request->isAjaxRequest){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }*/
        if (!Yii::app()->request->getParam('hash')) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $model = Users::getModelByType($type)
            ->find('user_id = :user_id AND hash = :hash',
                array(
                    ':user_id' => Yii::user()->getCurrentId(),
                    ':hash' => Yii::app()->request->getParam('hash')
                )
            );

        if (!$model) {
            if (Yii::request()->isAjaxRequest) {
                echo CJSON::encode(
                    array(
                        'success' => false,
                        'message' => Yii::t('Front', 'Activate code is incorrect.')
                    )
                );
            } else {
                throw new CHttpException(404, Yii::t('Front', 'Activate code is incorrect'));
            }

            Yii::app()->end();
        }

        if ($model->status == 1 && $model->is_master == 0) {
            $master = Users::getModelByType($type)->find('user_id = :uid AND is_master = 1', array(':uid' => Yii::app()->user->id));
            $model->is_master = 1;
            if ($type == 'emails') {
                $model->user->email = $model->email;
            } elseif ($type == 'phones') {
                $model->user->phone = $model->phone;
            }
            $model->hash = '';
            if (!$model->user->validate()) {
                echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'This ' . $type . ' primary for another account')));
                Yii::app()->end();
            }
            if ($model->user->save()) {
                if ($master) {
                    $master->hash = '';
                    $master->is_master = 0;
                    $master->save();
                }
                $model->save();
                if ($type == 'emails') {
//					Yii::app()->user->addNotification(
//						'is_master_new_'.$type, //код
//						$type.' "'. $model->user->email .'" is primary',
//						'close', // возможность закрыть
//						'green' //желтая рамка
//					);

//                    Yii::app()->session['flash_notify'] = array(
//                        'title' => Yii::t('Front', 'Personal Cabinet'),
//                        'message' => Yii::t('Front', 'Email \"' . $model->user->email . '\" is primary'),
//                    );

                } elseif ($type == 'phones') {

//                    Yii::app()->session['flash_notify'] = array(
//                        'title' => Yii::t('Front', 'Personal Cabinet'),
//                        'message' => Yii::t('Front', 'Phone \"+' . $model->user->phone . '\" is primary'),
//                    );

//					Yii::app()->user->addNotification(
//						'is_master_new_'.$type, //код
//						'Phone "'. $model->user->phone .'" is primary',
//						'close', // возможность закрыть
//						'green' //желтая рамка
//					);
                }

            }
        } elseif ($model->status == 0 && $model->is_master == 0) {
            $model->hash = '';
            $model->status = 1;
            $model->is_master = 0;
            $model->save();
            if ($type == 'phones') {
//				Yii::app()->user->removeNotification('mobile_activation');
            }

//            Yii::app()->session['flash_notify'] = array(
//                'title' => Yii::t('Front', 'Personal Cabinet'),
//                'message' => Yii::t('Front', 'You have successfully activated new ' . $type),
//            );

//			Yii::app()->user->addNotification(
//				'activate_new_'.$model->id, //код
//				'You have successfully activated new '.$type,
//				'close', // возможность закрыть
//				'green'
//			);
        }

        if (Yii::app()->request->isAjaxRequest) {

            $data_categories = Users_Categories::model()->findAll(
                array(
                    'condition' => 'data_type = "users_phones" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                    'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
                )
            );

            $html = '';
            if ($type == 'phones') {
                $html = $this->renderPartial(
                    'tabversion/_phones',
                    array(
                        'users_phones' => self::getUsersItems($model),
                        'data_categories' => $data_categories,
                        'user' => Users::model()->findByPk(Yii::user()->id),
                    ),
                    true,
                    true
                );
            }

            echo CJSON::encode(
                array(
                    'success' => true,
                    'message' => Yii::t('Front', 'successfully activated'),
                    'html' => $html,
                )
            );
        } else {
            $this->redirect(array('/personal/index', '#' => $type));
//            $this->redirect(array('/banking/index'));
        }
        Yii::app()->end();
    }

    public function actionTestSms()
    {

    }

    public function actionEditSocials()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My social networks'))] = '';

        $user = Users::model()->findByPk(Yii::app()->user->id);

        $service = Yii::app()->request->getQuery('service');
        if (isset($service)) {

            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = $this->createAbsoluteUrl('/personal/index');
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('/personal/index');

            if ($authIdentity->authenticate()) {
                $identity = new EAuthUserIdentity($authIdentity);

                // successful authentication
                if ($identity->authenticate()) {
                    Yii::app()->user->login($identity);
                    if ($identity->addNewSocial) {
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
            $this->redirect($this->createAbsoluteUrl('/personal/index', array('#' => 'socials')));
        }

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial('tabversion/_socials', array('user' => $user), true, true)
        ));
    }

    public function actionEditQustions()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My security questions'))] = '';

        $model = new Users_Securityquestions();
        $user = Users::model()->findByPk(Yii::app()->user->id);

        $question = Securityquestions::model()->findAll('status = 1 AND lang = :lang', array(':lang' => Yii::app()->language));

        if (isset($_POST['ajax'])) {
            $error = CActiveForm::validate($model);
            if ($error == '[]') {
                if (count($user->questions) >= 5) {
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
            if (count($user->questions) >= 5) {
                $model->addError('Users_Securityquestions_answer', Yii::t('Front', 'Youasdfasdf have reached the required limit for security questions. In order to add new questions, you need to delete the existing ones'));
                echo CJSON::encode($model->getErrors());
                Yii::app()->end();
            }
            if ($model->save()) {
                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_questions',
                            array(
                                'model' => new Users_Securityquestions(),
                                'user' => Users::model()->findByPk(Yii::app()->user->id),
                                'question' => $question,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'Security Question was successfully saved'),
                ));
                Yii::app()->end();
            }
            Yii::app()->end();
        }

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial(
                    'tabversion/_questions',
                    array(
                        'model' => new Users_Securityquestions(),
                        'user' => $user,
                        'question' => $question,
                    ),
                    true,
                    true
                ),
        ));
        Yii::app()->end();
    }

    public function actionDelete($id)
    {
        $type = Yii::app()->request->getParam('type', '', 'list', array('social', 'messager', 'phones', 'question', 'emails', 'address', 'telephones', 'other'));
        if (!$type && !$id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $mesTitle = false;
        $message = false;
        $reload = false;
        $return = true;
        $refresh = false;
        $html = false;
        switch ($type) {
            case 'social':
                $soc = Users_Socials::model()->ownUser()->findByPk($id);
                if ($soc) {
                    $soc->getProvider()->delete();
                    $soc->delete();
                }
                $mesTitle = Yii::t('Front', 'Personal Cabinet');
                $message = Yii::t('Front', 'Social network was deleted from your profile');
                break;
            case 'messager':
                $mes = Users_Instmessagers::model()->findByPk($id);
                $mes->delete();
                $mesTitle = Yii::t('Front', 'Personal Cabinet');
                $message = Yii::t('Front', 'Instant messenger was deleted from your profile');
                break;
            case 'phones':
                $mes = Users_Phones::model()->findByPk($id);
                if ($mes->user->phone != $mes->phone) {
                    $mes->delete();
                    $mesTitle = Yii::t('Front', 'Personal Cabinet');
                    $message = Yii::t('Front', 'Mobile Phone was deleted from your profile');
                } else {
                    $return = false;
                }
                break;
            case 'emails':
                $mes = Users_Emails::model()->findByPk($id);
                if ($mes->user->email != $mes->email) {
                    $mes->delete();
                    $mesTitle = Yii::t('Front', 'Personal Cabinet');
                    $message = Yii::t('Front', 'Email address was deleted from your profile');
                } else {
                    $return = false;
                }
                break;
            case 'question':
                $qust = Users_Securityquestions::model()->ownUser()->findByPk($id);
                if ($qust->user_id == Yii::user()->id) {
                    $qust->delete();
                    $mesTitle = Yii::t('Front', 'Personal Cabinet');
                    $message = Yii::t('Front', 'Security question was deleted from your profile');
                }
                $questions = Securityquestions::model()->findAll('status = 1 AND lang = :lang', array(':lang' => Yii::app()->language));

                $user = Users::model()->findByPk(Yii::app()->user->id);

                $html = $this->renderPartial(
                    'tabversion/_questions',
                    array(
                        'model' => new Users_Securityquestions(),
                        'user' => $user,
                        'question' => $questions,
                    ),
                    true,
                    true
                );
                if (count($user->questions) < 2) {
                    $refresh = true;
                }
                break;
            case 'address':
                $addr = Users_Address::model()->findByPk($id);
                if ($addr->user_id == Yii::app()->user->id) {
                    $addr->delete();
                    $mesTitle = Yii::t('Front', 'Personal Cabinet');
                    $message = Yii::t('Front', 'Address was deleted from your profile');
                } else {
                    $return = false;
                }
                break;
            case 'telephones':
                $telephone = Users_Telephones::model()->findByPk($id);
                if ($telephone->user_id == Yii::app()->user->id) {
                    $telephone->delete();
                    $mesTitle = Yii::t('Front', 'Personal Cabinet');
                    $message = Yii::t('Front', 'Phone number was deleted from your profile');
                } else {
                    $return = false;
                }
                break;
            case 'other':
                $model = Users_Others::model()->ownUser()->findByPk($id);
                if ($model) {
                    $model->delete();
                    $return = true;
                    $mesTitle = Yii::t('Front', 'Personal Cabinet');
                    $message = Yii::t('Front', 'Note was deleted from your profile');
                    $refresh = true;
                }
                break;
        }

        echo CJSON::encode(array('success' => $return, 'refresh' => $refresh, 'mesTitle' => $mesTitle, 'message' => $message, 'reload' => $reload, 'html' => $html));
    }

    public function actionEditPins()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My passwords'))] = '';

        $model = Users_Pins::model()->find('user_id = :uid', array(':uid' => Yii::app()->user->id));
        if (!$model) {
            $model = new Users_Pins;
            $model->user_id = Yii::app()->user->id;
        }

        if (isset($_POST['Users_Pins'])) {
            if (isset($_POST['Users_Pins']['pin1'])) {
                $model->scenario = 'pin1';
            } elseif (isset($_POST['Users_Pins']['pin2'])) {
                $model->scenario = 'pin2';
            } elseif (isset($_POST['Users_Pins']['pin3'])) {
                $model->scenario = 'pin3';
            }
        }

        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Pins'])) {
            $model->attributes = $_POST['Users_Pins'];
            if (isset($_POST['Users_Pins']['confirm_pass'])) {
                $model->confirm_pass = $_POST['Users_Pins']['confirm_pass'];
            }

            if ($model->save()) {

                $model->old_pass = '';
                $model->confirm_pass = '';
                echo CJSON::encode(array(
                    'success' => true,
                    'html' => $this->renderPartial(
                            'tabversion/_password',
                            array(
                                'model' => $model,
                            ),
                            true,
                            true
                        ),
                    'message' => Yii::t('Front', 'Password was saved'),
                ));
                Yii::app()->end();
            }
        }

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial(
                    'tabversion/_password',
                    array(
                        'model' => $model,
                    ),
                    true,
                    true
                ),
        ));
        Yii::app()->end();
    }

    public function actionSettings()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Account Settings'))] = '';

        $user = Users::model()->findByPk(Yii::app()->user->id);

        if (!$user->settings) {
            $user->settings = new Users_Settings;
            $user->settings->user_id = $user->id;
            $user->settings->language = $user->lang;
            $user->settings->statement_language = $user->lang;
            $user->settings->font_size = 14;

            $address = Users_Address::model()->find('user_id = :uid AND is_master = 1', array(':uid' => Yii::app()->user->id));
            $user->settings->time_zone_id = 276; // NL
            if ($address) {
                $zone = Zone::model()->find('country_code = :code', array(':code' => $address->country->code));
                if ($zone) {
                    $user->settings->time_zone_id = $zone->zone_id;
                }
            }
            $user->settings->currency_id = 1;
            $user->settings->save();
        }

        if (isset($_POST['Users_Settings']) && Yii::app()->request->isAjaxRequest) {
            $user->settings->attributes = $_POST['Users_Settings'];
            if ($user->settings->save()) {
                $redirect = false;
                Yii::user()->setLanguage($user->settings->language);
                if (Yii::app()->language != $user->settings->language) {
                    $redirect = $this->createAbsoluteUrl('/personal/index', array('#' => 'settings', 'language' => $user->settings->language));
                }
                Yii::user()->setFontSize($user->settings->font_size);
                Yii::user()->getTimeZone(true); //refresh time zone
                Yii::user()->getLastTime(true); //refresh last login time
                echo CJSON::encode(array(
                    'success' => true,
                    'redirect' => $redirect,
                    'attrs' => $user->settings->attributes,
                    'html' => $this->renderPartial('tabversion/_settings', array('user' => $user), true, true),
                ));
            } else {
                echo CJSON::encode(array('success' => false, 'message' => $user->settings->getErrors()));
            }
            Yii::app()->end();
        }

        echo CJSON::encode(array(
            'success' => true,
            'html' => $this->renderPartial('tabversion/_settings', array('user' => $user), true, true),
        ));
    }

    public function actionAlerts()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal Account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Alerts'))] = '';
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alerts.js', CClientScript::POS_END);
        }
        Yii::app()->clientScript->scriptMap['personal.js'] = false;

        $accounts = Accounts::model()->with('user')->byUserId(Yii::app()->user->id)->findAll();
        if (empty($accounts)) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $selectedAcc = false;
        if ($accountNumber = Yii::app()->request->getParam('account', false, 'int')) {
            $selectedAcc = Accounts::model()->byUserId(Yii::app()->user->id)->find('number = :number', array(':number' => $accountNumber));
        }
        if (!$selectedAcc) {
            $selectedAcc = $accounts[0];
        }

        $staticAlerts = Alerts::model()->with('userAlertRules')->withoutAccount()->findAll();

        $userAlertsRules = Users_AlertsRules::model()
            ->byAccountID($selectedAcc->id)
            ->byUserId(Yii::app()->user->id)
            ->with('alert:withAccount')
            ->findAll();
        $emailAddresses = Users_Emails::model()->byUserId(Yii::app()->user->id)->findAll();
        $phones = Users_Phones::model()->byUserId(Yii::app()->user->id)->findAll();

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'jquery.ui.js' => false,
                'jquery.yiiactiveform.js' => false
            );
            $html = $this->renderPartial('_rulesTable', array(
                'emailAddresses' => $emailAddresses,
                'phones' => $phones,
                'selectedAcc' => $selectedAcc,
                'userAlertsRules' => $userAlertsRules
            ), true, true);
            echo CJSON::encode(array('success' => true, 'html' => $html));
            Yii::app()->end();
        }

        $this->render('alerts', array(
            'accounts' => $accounts,
            'selectedAcc' => $selectedAcc,
            'alerts' => $staticAlerts,
            'userAlertsRules' => $userAlertsRules,
            'emailAddresses' => $emailAddresses,
            'phones' => $phones,
        ));
    }

    public function actionUpdatealerts($id = null)
    {
        if (isset($_POST['Users_AlertsRules'])) {
            $response = array('success' => false);
            $code = isset($_POST['Users_AlertsRules']['alert_code']) ? $_POST['Users_AlertsRules']['alert_code'] : false;
            $alert = null;
            if ($code) {
                $alert = Alerts::model()->findByCode($code);
            }
            $accountNumber = Yii::app()->request->getParam('account', false, 'int');
            $selectedAcc = null;
            if ($accountNumber) {
                $selectedAcc = Accounts::model()->byUserId(Yii::app()->user->id)->find('number = :number', array(':number' => $accountNumber));
            }
            if ($alert && (($alert->use_rules && $selectedAcc) || !$alert->use_rules)) {
                $userAlertsRules = Users_AlertsRules::model()->findByPk($id);
                if ($userAlertsRules &&
                    (
                        ($userAlertsRules->user_id != Yii::app()->user->id) ||
                        ($alert->use_rules && $userAlertsRules->account_id != $selectedAcc->id)
                    )
                ) {
                    throw new CHttpException(404, Yii::t('Front', 'Page not found'));
                } elseif (!$userAlertsRules) {
                    $userAlertsRules = new Users_AlertsRules();
                }
                $userAlertsRules->attributes = $_POST['Users_AlertsRules'];
                $userAlertsRules->user_id = Yii::app()->user->id;
                if ($selectedAcc)
                    $userAlertsRules->account_id = $selectedAcc->id;
                $userAlertsRules->alert_id = $alert->id;
                if ($userAlertsRules->validate()) {
                    if (!isset($_POST['ajax']) && $userAlertsRules->save()) {
                        if (isset($_POST['Users_AlertsRules']['emails'])) {
                            $userAlertsRules->saveEmails($_POST['Users_AlertsRules']['emails']);
                        }
                        if (isset($_POST['Users_AlertsRules']['phones'])) {
                            $userAlertsRules->savePhones($_POST['Users_AlertsRules']['phones']);
                        }
                    }
                    $response['success'] = true;
                }
            } else {
                $userAlertsRules = new Users_AlertsRules();
                $userAlertsRules->addError('alert_code', Yii::t('Front', 'Choose alert'));
            }
            if ($response['success']) {
                $response['data'] = $userAlertsRules->id;
            } elseif (isset($userAlertsRules)) {
                foreach ($userAlertsRules->getErrors() as $attribute => $errors)
                    $response[CHtml::activeId($userAlertsRules, $attribute)] = $errors;
            }
            if (Yii::app()->request->isAjaxRequest) {
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'Users_AlertsRules' && isset($userAlertsRules)) {
                    echo CActiveForm::validate($userAlertsRules);
                } else {
                    echo json_encode($response);
                }
                Yii::app()->end();
            } else {
                $this->redirect(array('alerts'));
            }
        } else {
            $this->redirect(array('alerts'));
        }
    }

    public function actionDropalerts($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $userAlertsRules = Users_AlertsRules::model()->findByPk($id);
            if (!$userAlertsRules || $userAlertsRules->user_id != Yii::app()->user->id) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
            $response = array('success' => false);
            if ($userAlertsRules->delete()) {
                $response['success'] = true;
            }
            if (Yii::app()->request->isAjaxRequest) {
                echo json_encode($response);
                Yii::app()->end();
            }
            $this->redirect(array('alerts'));
        }
        throw new CHttpException(404, Yii::t('Front', 'Page not found'));
    }

    /**
     * actionPaymentinstuments
     *
     * User favorite payment instuments list
     * Add user favorite payment instuments list
     */
    public function actionPaymentinstuments()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Personal account'))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Payment instuments'))] = '';

        $method = Yii::app()->request->getQuery('method');
        if (!is_null($method))
            // Add or update user`s favorite payment instuments list
            $this->_createUpdatePaymentInstument($method);

        // User`s favorite payment instuments list
        $paymentInstruments = Users_Paymentinstruments::model()->ownUser()->active()->findAll(array('order' => 'is_master desc'));

//        $this->render('paymentInstuments/list', Array(
//            'paymentInstruments' => $paymentInstruments,
//        ));

        $data_categories = Users_Categories::model()->findAll(
            array(
                'condition' => 'data_type = "users_payment_instruments" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
            )
        );

        $cs = Yii::app()->clientScript;
        $cs->registerCssFile('http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css');
        $cs->registerScriptFile('http://silviomoreto.github.io/bootstrap-select/javascripts/bootstrap-select.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile('/js/jquery.creditCardValidator.js', CClientScript::POS_HEAD);

        echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial(
                        'paymentInstuments/list',
                        array(
                            'paymentInstruments' => $paymentInstruments,
                            'data_categories' => $data_categories,
                        ),
                        true,
                        true
                    )
            )
        );
    }

    /**
     * AddUpdatePaymentInstument
     *
     * @param string $method
     * @return bool
     */
    private function _createUpdatePaymentInstument($method)
    {
        $modelName = 'Users_Paymentinstruments';
        if (!isset($_POST[$modelName]))
            return FALSE;

        if ($method == 'create')
            $model = new $modelName;
        else if ($method == 'update')
            $model = $modelName::model()->findByPk($_POST[$modelName]['id']);

        if (isset($_POST[$modelName]['electronic_method'])
            && isset(Users_Paymentinstruments::$methods[$_POST[$modelName]['electronic_method']])
        ) {
            $model->scenario = Users_Paymentinstruments::$methods[$_POST[$modelName]['electronic_method']];
        } elseif (!$model->isNewRecord) {
            $model->scenario = Users_Paymentinstruments::$methods[$model->electronic_method];
        }

        // model validation
        if (
            Yii::app()->getRequest()->isAjaxRequest
            && substr(Yii::app()->getRequest()->getParam('ajax'), 0, 16) == 'electronic-form-'
        ) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // save the model
        $model->attributes = $_POST[$modelName];
        if (!$model->isNewRecord && $model->user_id != Yii::app()->user->id)
            return;

        if (!Users_Paymentinstruments::model()->ownUser()->find('deleted = 0')) {
            $model->is_master = 1;
        }

        if ($model->save()) {

            $data_categories = Users_Categories::model()->findAll(
                array(
                    'condition' => 'data_type = "users_payment_instruments" AND (user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                    'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
                )
            );

            $paymentInstruments = Users_Paymentinstruments::model()->ownUser()->active()->findAll();
            $this->cleanResponseJs();
            echo CJSON::encode(array(
                'success' => true,
                'clean' => false,
                'message' => Yii::t('Front', 'Payment instrument was saved successfully'),
                'html' =>
                    $this->renderPartial('paymentInstuments/list',
                        array(
                            'paymentInstruments' => $paymentInstruments,
                            'data_categories' => $data_categories,
                        ),
                        true, true)
            ));
        } else {
            echo CJSON::encode(array(
                'success' => false,
                'message' => $model->errors
            ));
        }
        Yii::app()->end();
    }

    public function actionDeletePaymentInstument($id)
    {
        $model = Users_Paymentinstruments::model()->findByPk($id);
        $success = false;
        $message = false;
        if ($model->user_id == Yii::app()->user->id) {
            $model->deleted = 1;
            $model->scenario = 'delete';
            if ($model->save()) {
                $success = true;
                $message = Yii::t('Front', 'Payment instrument was successfully removed');
            }
        }

        echo CJSON::encode(array(
            'success' => $success,
            'message' => $message
        ));
    }

    public function actionNewsletter()
    {
        $type = Yii::request()->getParam('name', '', 'list', Users_Newsletter::$types);
        $message = false;

        if ($type) {
            $newsletter = Users_Newsletter::model()->ownUser()->findByAttributes(array(
                'letter_type' => $type,
            ));
            if (!$newsletter) {
                $newsletter = new Users_Newsletter;
                $newsletter->letter_type = $type;
                $newsletter->user_id = Yii::user()->id;
                $newsletter->save();
                $message = Yii::t('Personal', 'Newsletter_:type_was_subscribe', array(':type' => $type));
            } else {
                $newsletter->delete();
                $message = Yii::t('Personal', 'Newsletter_:type_was_unsubscribe', array(':type' => $type));
            }
        }

        $model = Users_Newsletter::model()->findAllByAttributes(array('user_id' => Yii::user()->id));

        echo CJSON::encode(array(
            'success' => true,
            'clean' => false,
            'message' => $message,
            'html' => $this->renderPartial('tabversion/_newslatter', array('model' => $model), true, true),
        ));
    }

    public function actionOther()
    {

        $model = new Users_Others();
        $message = '';

        if (Yii::request()->getParam('ajax')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Others'])) {
            if (isset($_POST['Users_Others']['id'])) {
                $model = Users_Others::model()->ownUser()->findByPk($_POST['Users_Others']['id']);
            }
            $model->attributes = $_POST['Users_Others'];
            $model->user_id = Yii::user()->id;
            $model->save();
            $message = Yii::t('Personal', 'Note was successfully saved');
            $model = new Users_Others();
        }

        $others = Users_Others::model()->ownUser()->findAll();

        echo CJSON::encode(array(
            'success' => true,
            'message' => $message,
            'html' => $this->renderPartial(
                    'tabversion/_other',
                    array(
                        'model' => $model,
                        'others' => $others,
                    ), true, true),
        ));
    }

    public function actionResendSmsForChangeId()
    {
        $lastXabinaId = Users_Ids::model()->ownUser()->find(
            array(
                'condition' => 'status = :pending',
                'order' => 'created_at desc',
                'params' => array(
                    ':pending' => Users_Ids::STATUS_PENDING,
                )
            )
        );

        if (!$lastXabinaId) {
            echo CJSON::encode(array(
                'success' => false,
                'message' => Yii::t('Personal', 'Error new ID'),
            ));
        }

        if (Yii::app()->sms->to(Yii::user()->getPhone())->body('Confirmation code: {code}', array('{code}' => $lastXabinaId->confirm_code))->send() != 1) {
            Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
        }

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Personal', 'SMS was successfully resent'),
        ));
    }

    public function actionForgotPass()
    {
        $pin = Yii::request()->getParam('pin', '', 'list', array('pin1', 'pin2', 'pin3'));

        if($pin){
            $pins = Users_Pins::model()->ownUser()->find();
            $pass = substr(time() . 'xabina' . 'pass' . $pins->user->email, 3, 6);
            $pins->$pin = md5($pass);

            $mail = new Mail;
            $mail->send(
                $pins->user, // this user
                'newPin', // sys mail code
                array( // params
                    '{:pin}'  => $pin,
                    '{:pass}' => $pass,
                    '{:date}' => date('Y m d', time()),
                )
            );
        }

        echo CJSON::encode(array(
            'message' => Yii::t('Personal', 'We send you new password to primary email'),
            'reload' => true,
            'success' => true,
        ));
    }
}