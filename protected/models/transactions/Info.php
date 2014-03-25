<?php

/**
 * This is the model class for table "transactions_info".
 *
 * The followings are the available columns in table 'transactions_info':
 * @property integer $transaction_id
 * @property integer $date
 * @property string $type
 * @property string $sender
 * @property integer $sum
 * @property integer $curency_id
 * @property string $address
 * @property string $postal_code
 * @property string $country
 * @property string $transfer_from
 * @property string $account_payer
 * @property string $bic
 * @property string $data_bank
 * @property string $costs
 */
class Transactions_Info extends CActiveRecord
{

	public $keyword;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transactions_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_id, date, type, sender, value, address, postal_code, country, transfer_from, account_payer, bic, data_bank, costs', 'required'),
			array('transaction_id, date, value', 'numerical', 'integerOnly'=>true),
			array('type, sender, address, postal_code, country, transfer_from, account_payer, bic, data_bank, costs', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transaction_id, date, type, sender, value, address, postal_code, country, transfer_from, account_payer, bic, data_bank, costs', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transaction_id' => 'Transaction',
			'date' => 'Date',
			'type' => 'Type',
			'sender' => 'Sender',
			'sum' => 'Sum',
			'curency_id' => 'Curency',
			'address' => 'Address',
			'postal_code' => 'Postal Code',
			'country' => 'Country',
			'transfer_from' => 'Transfer From',
			'account_payer' => 'Account Payer',
			'bic' => 'Bic',
			'data_bank' => 'Data Bank',
			'costs' => 'Costs',
		);
	}
	
	public function getPublicAttrs(){
		$attrs = array();
		foreach($this->attributes as $key => $value){
			if($key != 'transaction_id' && $value){
				$attrs[$this->getAttributeLabel($key)] = $value;
			}
		}
		return $attrs;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionsInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
