<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Changelostphone extends CFormModel
{
	public $phone;
	public $email;
    public $userId;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('phone', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect'), 'on' => 'change'),
			array('email', 'required', 'message' => Yii::t('Front', 'E-mail is incorrect'), 'on' => 'change'),
			array('email', 'email', 'message' => Yii::t('Front', 'E-mail is incorrect'), 'on' => 'change'),
			array('userId', 'checkUser'),
			array('userId', 'required', 'on' => 'change'),
		);
	}

	public function checkUser($attribute,$params)
	{

        $this->phone = trim($this->phone, '+');
        $user = Users::model()->findByAttributes( array('phone' => $this->phone, 'email' => $this->email, 'login' => $this->userId));
        if(!$user){
            $this->addError('userId', Yii::t('Front', 'Mobile Phone or E-mail not match'));
        }
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'phone' => Yii::t('Front', 'Mobile Phone'),
			'email' => Yii::t('Front', 'E-mail'),
			'userId' => Yii::t('Front', 'UserID'),
			'code'=>Yii::t('Front', 'SMS verification code'),
		);
	}

}
