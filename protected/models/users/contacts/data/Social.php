<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Social $contact
 */
class Users_Contacts_Data_Social extends Users_Contacts_Data_Model
{

	public $social;
	public $url;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('social, url', 'required'),
			array('url', 'url'),
			array('social', 'in', 'range' => array_keys(Yii::app()->eauth->services)),
		);
	}
	
	public function attributeNames(){
		return array(
			'social',
			'url',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersContactsData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
