<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Default $contact
 */
class Users_Contacts_Data_Default extends Users_Contacts_Data_Model
{

	public $type;
	public $value;
	
	public static $types = array(
		1 => 'currency',
		2 => 'Details of payment',
		3 => 'Category',
	);

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, value', 'required'),
			array('type', 'in', 'range' => array('currency', 'details', 'category')),
			array('value', 'length', 'max' => 140),
			array('value', 'checkValue'),
		);
	}
	
	public function checkValue($attribute, $params){
		//$this->addError($attribute, 'check the values');
	}
	
	public function attributeNames(){
		return array(
			'type',
			'value',
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
	
	public static function getModelForType($contact, $typeId){
		foreach($contact->getDataByType('default') as $model){
			if($model->type == $typeId){
				return $model;
			}
		}
		$model = new Users_Contacts_Data_Default;
		$model->type = $typeId;
		return $model;
	}
}
