<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Contact $contact
 */
class Users_Contacts_Data_Contact extends Users_Contacts_Data_Model
{

	public $contact_id;
	public $category;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_id', 'required', 'message' => Yii::t('Front', 'Contact is incorrect')),
			array('contact_id', 'ext.validators.ContactValidator'),
			array('category', 'length', 'max' => 255),
		);
	}
	
	public function attributeNames(){
		return array(
			'contact_id',
			'category',
		);
	}
	
	public function getContactInfo(){
		return Users_Contacts::model()->currentUser()->findByPk($this->contact_id);
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
