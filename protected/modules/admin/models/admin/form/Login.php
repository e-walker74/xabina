<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Admin_Form_Login extends CFormModel
{
	public $login;
	public $password;
    public $userModel;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('login', 'required', 'message' => Yii::t('Front', 'Insert Login or Email')),
			array('password', 'required', 'message' => Yii::t('Front', 'Password is incorrect')),
			array('login', 'match', 'pattern' => '/^[0-9a-zA-Z\-]{1,}$/', 'message' => Yii::t('Front', 'Insert Your login using latin alphabet')),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'login' => Yii::t('Front', 'Login'),
			'password' => Yii::t('Front', 'Password'),
			'shortSession'=>Yii::t('Front', 'Stay signed in'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$this->password = trim($this->password);
			$this->_identity=new UserIdentity($this->login,md5($this->password));
			if(!$this->_identity->authenticate()){
				if($this->_identity->errorCode == UserIdentity::USER_IS_NOT_ACTIVE){
					$this->addError('password', Yii::t('Front', 'User is blocked'));
				} else {
					$this->addError('password', Yii::t('Front', 'E-Mail or Password is incorrect'));
					$this->addError('login', Yii::t('Front', ''));
				}
			}
		}
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->login,$this->password);
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
