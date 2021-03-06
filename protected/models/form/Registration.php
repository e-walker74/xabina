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
	public $country;
	public $company_name;
	public $role;
	public $terms;
	public $login;
	public $prepaid_login;

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
			array('login', 'required', 'message' => Yii::t('Front', 'User ID is incorrect')),
			array('terms', 'required', 'message' => Yii::t('Front', 'You need to agree to the Terms & Conditions')),
			//array('first_name', 'required', 'message' => Yii::t('Front', 'First Name is incorrect')),
			//array('first_name, last_name', 'match', 'pattern' => '/^[a-zA-Z\- ]{1,}$/', 'message' => Yii::t('Front', 'Add Your name using latin alphabet')),
			//array('last_name', 'required', 'message' => Yii::t('Front', 'Last Name is incorrect')),
			array('phone', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'match', 'pattern' => '/^[\+]\d+$/', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'authenticatePhone'),
			array('phone', 'length', 'min' => 10, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long')),
			array('login', 'length', 'min' => 5, 'max' => 20, 'tooShort' => Yii::t('Front', 'User ID is too short'), 'tooLong' => Yii::t('Front', 'User ID is too long')),
			array('login', 'match', 'pattern' => '/^[0-9a-zA-Z\_]{1,}$/', 'message' => Yii::t('Front', 'Insert Your login using latin alphabet')),
			array('email', 'checkEmailUnique'),
            array('email', 'email', 'checkPort' => false, 'message' => Yii::t('Front', 'E-Mail is incorrect')),
            array('login', 'checkLoginUnique'),
			// password needs to be authenticated
			array('email', 'authenticate'),
            array('role', 'required'),
            array('role', 'in', 'range' => array(1, 2)),
            array('country', 'checkCountry'),
            array('company_name', 'checkCompany'),
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
			'company_name' => Yii::t('Front', 'Company Name'),
			'country' => Yii::t('Front', 'Country'),
			'login' => Yii::t('Front', 'User ID'),
			'prepaid_login' => Yii::t('Front', 'Old User ID'),
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

	public function checkLoginUnique($attribute, $params){
        $this->login = trim($this->login);
		$email = Users::model()->find('login = :login', array(':login' => $this->login));
        if($email){
            $this->addError('login', Yii::t('Front', 'This User ID is already registered'));
        }
    }

    public function checkCompany($attribute, $params){
        if($this->role == 2){
            if(!$this->company_name){
                //$this->addError('company_name', Yii::t('Front', 'Company name is incorrect'));
            }
        }
    }

    public function checkCountry($attribute, $params){
        if($this->role == 2){
            $c = Countries::model()->findByAttributes(
                array('name' => $this->country)
            );
            if(!$c){
                //$this->addError('country', Yii::t('Front', 'Country is incorrect'));
            }
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
		//$user->login = new CDbExpression('UUID_SHORT()');
		$pass = substr(md5(time() . 'xabina_pass' . $user->email), 2, 8);
		$user->password = md5($pass);
		$user->created_at = time();
		$user->updated_at = $user->created_at;
		$user->role = $this->role;
		$user->status = Users::USER_IS_NOT_ACTIVE;
		$user->createHash();

		if($user->save()){
            $email = new Users_Emails;
            $email->user_id = $user->id;
            $email->email = $user->email;
            $email->status = 0;
            $email->is_master = 0;
            $email->save();

            if($user->role == 2) {
                $countries = new Countries;
                $country = $countries->findByAttributes(
                    array('name' => $this->country)
                );
                $company = new Companies;
                $company->owner_id = $user->id;
                $company->title = $this->company_name;
                $company->country_id = 2760; // NL
                $company->save();
            }

            $rbac = new RbacUserRoles();
            $rbac->user_id = $user->id;
            $rbac->role_id = 1; //TODO get default role for the new user
            $rbac->save();

			if(!$user->settings){
				$user->settings = new Users_Settings;
				$user->settings->user_id = $user->id;
				$user->settings->language = Yii::app()->language;
				$user->settings->statement_language = Yii::app()->language;
				$user->settings->font_size = 14;
				
				$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
				$country = $SxGeo->getCountry(Yii::app()->request->getUserHostAddress());
				
				$user->settings->time_zone_id = 231; // NL
				if($country){
					$zone = Zone::model()->find('country_code = :code', array(':code' => $country));
					if($zone){
						$user->settings->time_zone_id = $zone->zone_id;
					}
				}
				$user->settings->currency_id = 1;
				$user->settings->save();
			}
		
			$result = true;
		}
		return $result;
	}

	public function registerPrepaid(){
		$result = false;
		$user = new Users;
		$user->attributes = $this->attributes;
		//$user->login = new CDbExpression('UUID_SHORT()');
		$pass = substr(md5(time() . 'xabina_pass' . $user->email), 2, 8);
		$user->password = md5($pass);
		$user->created_at = time();
		$user->updated_at = $user->created_at;
		$user->role = $this->role;
		$user->status = Users::USER_IS_NOT_ACTIVE;
		$user->createHash();

		if($user->save()){

            if($user->role == 2) {
                $countries = new Countries;
                $country = $countries->findByAttributes(
                    array('name' => $this->country)
                );
                $company = new Companies;
                $company->owner_id = $user->id;
                $company->title = $this->company_name;
                $company->country_id = $country->id;
                $company->save();
            }

            $rbac = new RbacUserRoles();
            $rbac->user_id = $user->id;
            $rbac->role_id = 1; //TODO get default role for the new user
            $rbac->save();

			if(!$user->settings){
				$user->settings = new Users_Settings;
				$user->settings->user_id = $user->id;
				$user->settings->language = Yii::app()->language;
				$user->settings->statement_language = Yii::app()->language;
				$user->settings->font_size = 14;

				$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
				$country = $SxGeo->getCountry(Yii::app()->request->getUserHostAddress());

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

			$result = true;

		}
		return $result;
	}
}
