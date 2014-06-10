<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Urls $contact
 */
class Users_Contacts_Data_Urls extends Users_Contacts_Data_Model
{

	public $url;
	public $category;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url', 'url'),
			array('url', 'required'),
			array('category, url', 'length', 'max' => 140),
		);
	}
	
	public function attributeNames(){
		return array(
			'category',
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
