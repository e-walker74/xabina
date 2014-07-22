<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Smslogin extends CFormModel
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
			array('userId', 'authenticate', 'on' => 'login'),
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

    public function sendBlockEmail() {
        $user = Users::model()->find('login = :p', array(':p' => $this->userId));
        if ($user != null) {
            $user->createHash();
            $user->save();
            $mail = new Mail();
            $mail->send(
                $user, // this user
                'resetLoginBlock', // sys mail code
                array(	// params
                      '{:date}' => date('Y m d', time()),
                      '{:activateUrl}' => Yii::app()->getBaseUrl(true).'/site/ResetSMSLogin/?login='.$user->login.'&confirm='.$user->hash,
            ));
            return true;
        } else {
            return false;
        }
    }

	public function checkCode($attribute, $params){
		$i = Yii::app()->cache->get('sms_auth_trying_user_'.$this->userId);
		if(!$i){
			$i = 0;
		}
        if ($i == 4) {

            $this->sendBlockEmail();
            Yii::app()->cache->set('sms_auth_trying_user_'.$this->userId, ++$i, 3600);
        }
		if($i > 3){
			$this->addError('code', Yii::t('Front', 'You have entered the wrong sms code 3 times. Your profile has been temporarily blocked for 1 hour. Please check Your E-Mail in order to restore access to Your account'));
            return false;
		}
		if($this->code != Yii::app()->cache->get('sms_auth_code_user_'.$this->userId)){
			Yii::app()->cache->set('sms_auth_trying_user_'.$this->userId, ++$i, 3600);
			$this->addError('code', Yii::t('Front', 'Code is incorrect. Your code is :'.Yii::app()->cache->get('sms_auth_code_user_'.$this->userId)));
		}
	}

	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserSmsIdentity($this->userId);
			if(!$this->_identity->authenticate()){
				if($this->_identity->errorCode == UserIdentity::USER_IS_NOT_ACTIVE){
					//$this->addError('userId', Yii::t('Front', 'Is not activated, <a href=":link">resend</a> activation', array(':link' => Yii::app()->createUrl('/remind'))));
				} else {
					//$this->addError('userId', Yii::t('Front', 'User ID is incorrect'));
				}
                $this->addError('userId', Yii::t('Front', 'User ID is incorrect'));
			}
		}
	}
	
	public function smsSendCode(){
		if($this->_identity===null)
		{
			$this->_identity=new UserSmsIdentity($this->userId);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$user = Users::model()->findByPk($this->_identity->getId());
			$code = rand(100000, 999999);
			Yii::app()->cache->set('sms_auth_code_user_'.$user->login, $code, 60*7);
			Yii::app()->session['user_phone'] = $user->phone;
			if(Yii::app()->sms->to($user->phone)->body('Xabina auth code: {code}', array('{code}' => $code))->send() != 1){
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
				return false;
			}
			return true;
		}
		else
			return false;
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
			if($this->code == Yii::app()->cache->get('sms_auth_code_user_'.$this->userId)){
				
				$duration= 60 * 15;
				Yii::app()->user->login($this->_identity,$duration);
				return true;
			}
		}
		else
			return false;
	}
}
