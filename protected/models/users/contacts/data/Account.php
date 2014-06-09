<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Account $contact
 */
class Users_Contacts_Data_Account extends Users_Contacts_Data_Model
{

	/* 
	* data attributes
	*/
	public $account_type;
	public $account_number;
	public $account_holder;
	public $bic;
	public $bank_id;
	public $p_year;
	public $p_month;
	public $p_csc;
	public $bank_name;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_type, account_number', 'required'),
			array('account_type', 'in', 'range' => CHtml::listData(PaymentSystems::model()->findAll(), 'id', 'id')), //TODO another account types
			array('p_month', 'numerical', 'min' => 1, 'max' => 12),
			array('p_month', 'length', 'max' => 2),
			array('p_year', 'numerical', 'min' => date('Y'), 'max' => date('Y', time()+3600*24*365*20)),
			array('p_year', 'length', 'is' => 4, 'max' => 4),
			array('p_csc', 'numerical'),
			array('p_csc', 'length', 'max' => 3, 'min' => 3),
			array('account_number, account_holder, bic', 'length', 'max' => 255),
			array('account_type, account_number, account_holder, bic, bank_id, p_year, p_month, p_csc', 'safe'),
		);
	}
	
	public function attributeNames(){
		return array(
			'account_type',
			'account_number',
			'account_holder',
			'bic',
			'bank_id',
			'p_year',
			'p_month',
			'p_csc',
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
	
	public function getPaementSystemModel(){
		return PaymentSystems::model()->findByPk($this->account_type);
	}
}
