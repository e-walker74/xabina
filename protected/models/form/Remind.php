<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Remind extends CFormModel
{
	public $login;
	public $formtype;
    public $remind_types = array("email", "login", "phone");

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('login, formtype', 'required', 'message' => Yii::t('Front', 'Field cannot empty')),
			array('login', 'match', 'pattern' => '/^[0-9a-zA-Z\-\@\_\.\+]{1,}$/', 'message' => Yii::t('Front', $this->formtype.' is incorect')),
			array('login', 'match', 'pattern' => '/^[\+]\d+$/', 'message' => Yii::t('Front', 'Mobile Phone is incorrect'), 'on' => 'phone'),
			array('login', 'checkUserID', 'on' => 'login'),
			array('login', 'checkEmail', 'on' => 'email'),
			array('login', 'checkPhone', 'on' => 'phone'),
			array('login', 'email', 'message' => Yii::t('Front', 'E-mail is incorrect'), 'on' => 'email'),
			array('login', 'length', 'min' => 8, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long'), 'on' => 'phone'),
		);
	}


	public function checkUserID($attribute,$params)
	{
        $user = Users::model()->findByAttributes(array('login' => $this->login));
        if (!$user) {
            $this->addError('login', Yii::t('Front', 'User ID is incorrect'));
        }
        else {
            $i = Yii::app()->cache->get('sms_change_phone_user_'.$user->login);

            if($i && $i > 3){
                $this->addError('login', Yii::t('Front', 'Change phone function blocked for 1 hour.'));
                return false;
            }
        }
	}

	public function checkPhone($attribute,$params)
	{
        $this->login = trim($this->login, '+');
        $user = Users::model()->findByAttributes(array('phone' => $this->login));
        if (!$user) {
            $this->addError('login', Yii::t('Front', 'Phone not found'));
        }
	}

	public function checkEmail($attribute,$params)
	{
        $user = Users::model()->findByAttributes(array('email' => $this->login));
        if (!$user) {
            $this->addError('login', Yii::t('Front', 'E-mail not found '));
        }
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'login' => Yii::t('Front', 'Login or E-Mail'),
		);
	}
}
