<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Activation_File extends CFormModel
{
	
	protected $user_id;
	
	public $file_type;
	public $description;
	public $files;
	public $document;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('file_type, document', 'required', 'message' => Yii::t('Front', 'File Type is incorrect')),
			array('description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			array('files', 'required', 'message' => Yii::t('Front', 'You dont uploaded any files'))
			
			// password needs to be authenticated
		);
	}
	
	public function setUserId($id){
		$this->user_id = $id;
		return $this;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'file_type' => Yii::t('Front', 'Document Type'),
			'description' => Yii::t('Front', 'Description'),
		);
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
		
		return true;
		//return $uActivation->save();
	}
}
