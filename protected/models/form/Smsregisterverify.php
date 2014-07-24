<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Smsregisterverify extends CFormModel
{
	public $phone;
	public $code;
    public $userId;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('phone, userId', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect'), 'on' => 'change'),
			array('phone', 'match', 'pattern' => '/^[\+]\d+$/', 'message' => Yii::t('Front', 'Mobile Phone is incorrect'), 'on' => 'change'),
			array('phone', 'length', 'min' => 8, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long'), 'on' => 'change'),
			array('phone', 'authenticatePhone'),
			array('userId', 'required', 'on' => 'login'),
			array('code, userId', 'required', 'on' => 'confirm'),
			array('code', 'checkCode', 'on' => 'confirm'),
		);
	}
	
	public function authenticatePhone($attribute,$params)
	{
		//if(!$this->hasErrors())
		//{
			$this->phone = trim($this->phone, '+');
			$user = Users::model()->find('phone = :phone', array(':phone' => $this->phone));
			if($user){
				$this->addError('phone', Yii::t('Front', 'This Mobile Phone is already registered'));
			}
		//}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'phone' => Yii::t('Front', 'Mobile Phone'),
			'userId' => Yii::t('Front', 'User ID'),
			'code'=>Yii::t('Front', 'SMS verification code'),
		);
	}

	public function checkCode($attribute, $params){

        if (!$this->code) return;
        return;
        $i = Yii::app()->cache->get('sms_change_phone_user_'.$this->userId);
		if(!$i){
			$i = 1;
		}
        if ($i == 4) {

            Yii::app()->cache->set('sms_change_phone_user_'.$this->userId, ++$i, 3600);
        }
		if($i > 3){
			$this->addError('code', Yii::t('Front', 'You have entered the wrong sms code 3 times. Change phone function blocked for 1 hour.'));
            return false;
		}
		if($this->code != Yii::app()->session['user_code']){
			Yii::app()->cache->set('sms_change_phone_user_'.$this->userId, ++$i, 3600);
			$this->addError('code', Yii::t('Front', 'Code is incorrect. Your code is :'.Yii::app()->session['user_code']));
		}
	}
	
	public function smsSendCode(){

        if(Yii::app()->sms->to($this->phone)->body('Xabina auth code: {code}', array('{code}' => Yii::app()->session['user_code']))->send() != 1){
            Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
            return false;
        }
        return true;
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserSmsIdentity($this->userId);
			$this->_identity->authenticate();

		}

		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration= 60 * 15;
            Yii::app()->user->login($this->_identity,$duration);
            return true;
		}
		else
			return false;
	}

}
