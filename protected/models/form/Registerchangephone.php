<?php

/**
 * Registerchangephone class.
 */
class Form_Registerchangephone extends CFormModel
{
	public $phone;
    public $userId;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('phone, userId', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'match', 'pattern' => '/^[\+]\d+$/', 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'authenticatePhone'),
			array('phone', 'length', 'min' => 10, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long'), 'on' => 'change'),

		);
	}
	
	public function authenticatePhone($attribute,$params)
	{
		$this->phone = trim($this->phone, '+');
        $user = Users::model()->find('phone = :phone and login!=:login', array(':phone' => $this->phone, ':login' => $this->userId));
        if($user){
            $this->addError('phone', Yii::t('Front', 'This Mobile Phone is already registered'));
        }
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
}
