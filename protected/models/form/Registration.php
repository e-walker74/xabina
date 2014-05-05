<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Registration extends CFormModel
{
	public $email;
	public $first_name;
	public $last_name;
	public $phone;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('email', 'required', 'message' => Yii::t('Front', 'E-Mail is incorrect')),
			array('first_name', 'required', 'message' => Yii::t('Front', 'First Name is incorrect')),
			array('first_name, last_name', 'match', 'pattern' => '/^[a-zA-Z\- ]{1,}$/', 'message' => Yii::t('Front', 'Add Your name using latin alphabet')),
			array('last_name', 'required', 'message' => Yii::t('Front', 'Last Name is incorrect')),
			array('phone', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'match', 'pattern' => '/^[\+]\d+$/', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'length', 'min' => 11, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long')),
			array('phone', 'authenticatePhone'),
			array('email', 'checkEmailUnique'),
            array('email', 'email', 'checkPort' => false, 'message' => Yii::t('Front', 'E-Mail is incorrect')),
			// password needs to be authenticated
			array('email', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => Yii::t('Front', 'E-mail'),
			'first_name' => Yii::t('Front', 'First Name'),
			'last_name' => Yii::t('Front', 'Last Name'),
			'phone' => Yii::t('Front', 'Mobile Phone'),
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
	
	public function checkEmailUnique($attribute, $params){
        $this->email = trim($this->email);
		$email = Users_Emails::model()->find('email = :email AND status=1', array(':email' => $this->email));
        if($email){
            $this->addError('email', Yii::t('Front', 'This E-mail is already registered'));
        }
    }

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		//if(!$this->hasErrors())
		//{
			$user = Users::model()->find('LOWER(email)=?', array(strtolower($this->email)));
			if($user){
				$this->addError('email', Yii::t('Front', 'This E-Mail is already registered'));
			}
		//}
	}

	private function _setAttributes(&$to, $attributes){
		$aProfileLabels = array_flip($to->attributeLabels());
					
		foreach($attributes as $key => $attr){
			if(in_array($key, $aProfileLabels)){
				$to->$key = $attr;
			}
		}
	}
	
	public function registration(){
		$result = false;
		$user = new Users;
		$user->attributes = $this->attributes;
		$user->login = new CDbExpression('UUID_SHORT()');
		$pass = substr(md5(time() . 'xabina_pass' . $user->email), 2, 8);
		$user->password = md5($pass);
		$user->created_at = time();
		$user->updated_at = $user->created_at;
		$user->role = 1;
		$user->status = Users::USER_IS_NOT_ACTIVE;
		$user->createHash();
		if($user->save()){
		
			if(!$user->settings){
				$user->settings = new Users_Settings;
				$user->settings->user_id = $user->id;
				$user->settings->language = Yii::app()->language;
				$user->settings->statement_language = Yii::app()->language;
				$user->settings->font_size = 14;
				
				$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
				$country = $SxGeo->getCountry(CHttpRequest::getUserHostAddress());
				
				$user->settings->time_zone_id = 276; // NL
				if($country){
					$zone = Zone::model()->find('country_code = :code', array(':code' => $country));
					if($zone){
						$user->settings->time_zone_id = $zone->zone_id;
					}
				}
				$user->settings->currency_id = 1;
				$user->settings->save();
			}
		
			$user = Users::model()->findByPk($user->id);
			$mail = new Mail();
			if($mail->send(
				$user, // this user
				'registration', // sys mail code
				array(	// params
					'{:userPassword}' => $pass,
					'{:date}' => date('Y m d', $user->created_at),
					'{:activateUrl}' => Yii::app()->getBaseUrl(true).'/emailconfirm/'.$user->hash,
				)
			)){
				$result = true;
			} else {
				Yii::log('registration fail '.print_r($user->attributes, 1), CLogger::LEVEL_ERROR, 'error');
				$user->delete();
			}
		}
		return $result;
	}
}
