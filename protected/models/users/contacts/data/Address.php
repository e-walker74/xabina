<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Address $contact
 */
class Users_Contacts_Data_Address extends Users_Contacts_Data_Model
{

	public $address;
	public $address_line_2;
	public $index;
	public $country_id;
	public $country_code;
	public $category;
	public $city;
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address, country_id', 'required'),
			array('address, address_line_2, city, index, category', 'length', 'max' => 140),
			array('country_id', 'numerical'),
		);
	}
	
	public function attributeNames(){
		return array(
			'address',
			'index',
			'country_id',
			'category',
			'city',
			'address_line_2',
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
