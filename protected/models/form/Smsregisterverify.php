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
			array('phone', 'length', 'min' => 11, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long'), 'on' => 'change'),
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

		if($this->code != Yii::app()->session['user_code']){

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

}
