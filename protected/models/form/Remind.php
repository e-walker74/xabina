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
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('login, formtype', 'required', 'message' => Yii::t('Front', 'Field cannot empty')),
			array('login', 'match', 'pattern' => '/^[0-9a-zA-Z\-\@\_\.\+]{1,}$/', 'message' => Yii::t('Front', 'Insert Your login using latin alphabet')),
			array('login', 'authenticatePhone'),
			// password needs to be authenticated
		);
	}

	public function authenticatePhone($attribute,$params)
	{
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
