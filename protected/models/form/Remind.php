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
			array('login', 'authenticatePhone'),
			array('login', 'email', 'message' => Yii::t('Front', 'E-mail is incorrect'), 'on' => 'email'),
			array('login', 'match', 'pattern' => '/^[\+]\d+$/', 'message' => Yii::t('Front', 'Mobile Phone is incorrect'), 'on' => 'phone'),
			array('login', 'length', 'min' => 11, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long'), 'on' => 'phone'),
			// password needs to be authenticated
		);
	}

	public function authenticatePhone($attribute,$params)
	{
        if ($this->formtype)
		$this->login = trim($this->login, '+');
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
