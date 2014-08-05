<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Activation extends CFormModel
{
	
	protected $user_id;
	
	public $email;
	public $first_name;
	public $last_name;
	public $phone;
	public $address_line_1;
	public $address_line_2;
	public $zip_code;
	public $town;
	public $country_id;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('zip_code', 'required', 'message' => Yii::t('Front', 'Zip Code is incorrect')),
			array('country_id', 'required', 'message' => Yii::t('Front', 'Country is incorrect')),
			array('address_line_1', 'required', 'message' => Yii::t('Front', 'Address Line 1 is incorrect')),
			array('town', 'required', 'message' => Yii::t('Front', 'Town is incorrect')),
			array('first_name', 'required', 'message' => Yii::t('Front', 'First Name is incorrect')),
			array('first_name, last_name, address_line_1, address_line_2, town', 'match', 'pattern' => '/[0-9a-zA-Z\- ]{1,}$/', 'message' => Yii::t('Front', 'Add Your name using latin alphabet')),
			array('last_name', 'required', 'message' => Yii::t('Front', 'Last Name is incorrect')),
			//array('phone', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			//array('phone', 'match', 'pattern' => '/^\+\d+$/', 'message' => Yii::t('Front', 'Mobile Phone must be like +311..')),
			//array('phone', 'length', 'min' => 11, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long')),
			//array('phone', 'authenticatePhone'),
			array('zip_code', 'length', 'min' => 2, 'max' => 9, 'tooShort' => Yii::t('Front', 'Zip Code is too short'), 'tooLong' => Yii::t('Front', 'Zip Code is too long')),
			array('zip_code, country_id', 'match', 'pattern' => '/^[a-zA-Z\d+\- ]{1,}$/'),
			array('address_line_1, address_line_2, town', 'length', 'max'=>255),
			array('email, phone','safe'),
			
			// password needs to be authenticated
		);
	}
	
	public function setUserId($id){
		$this->user_id = $id;
		return $this;
	}
	
	public function setPhone($phone){
		$this->phone = $phone;
		return $this;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'first_name' => Yii::t('Front', 'First Name'),
			'last_name' => Yii::t('Front', 'Last Name'),
			'phone' => Yii::t('Front', 'Mobile Phone'),
			'address_line_1' => Yii::t('Front', 'Addres Line 1'),
			'address_line_2' => Yii::t('Front', 'Address Line 2'),
			'zip_code' => Yii::t('Front', 'Zip code'),
			'town' => Yii::t('Front', 'Town'),
			'country_id' => Yii::t('Front', 'Country'),
		);
	}
	
	public function authenticatePhone($attribute,$params)
	{
		//if(!$this->hasErrors())
		//{
			$this->phone = trim($this->phone, '+');
			$user = Users::model()->find('phone = :phone AND id != :user_id', array(':phone' => $this->phone, ':user_id' => $this->user_id));
			if($user){
				$this->addError('phone', Yii::t('Front', 'This Mobile Phone is already registered'));
			}
		//}
	}

	private function _setAttributes(&$to, $attributes)
	{
		$aProfileLabels = array_flip($to->attributeLabels());
					
		foreach($attributes as $key => $attr){
			if(in_array($key, $aProfileLabels)){
				$to->$key = $attr;
			}
		}
	}
	
	public function firstStep($activation){
		$user = Users::model()->findByPk(Yii::app()->user->id);
		$activation->attributes = $this->attributes;
		$activation->user_id = $user->id;
		$activation->phone = $user->phone;
		$activation->email = $user->email;
		$activation->step = 2;

		return $activation->save();
	}
}
