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
                    'saveaddress'
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

        $this->render('index', array(
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
                $model_emails->save();
                /*if($model_emails->save()){
                    $mail = new Mail;
                    $mail->send(
                        $model_emails->user, // this user
                        'emailConfirm', // sys mail code
                        array( // params
                            '{:date}' => date('Y m d', time()),
                            '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/'.$this->createUrl('/personal/activate', array('type' => 'email','hash' => $model_emails->hash)),
                        ),
                        $model_emails->email
                    );

                }*/

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