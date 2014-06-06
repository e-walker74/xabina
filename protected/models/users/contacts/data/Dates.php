<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Dates $contact
 */
class Users_Contacts_Data_Dates extends Users_Contacts_Data_Model
{

	public $date;
	public $category;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date', 'date', 'format' => 'dd.mm.YYYY'),
			array('category', 'length', 'max' => 140),
		);
	}
	
	public function attributeNames(){
		return array(
			'date',
			'category',
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
