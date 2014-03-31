<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 * @property string $id
 * @property string $user_id
 * @property double $amount
 * @property string $currency_id
 * @property string $account_id
 * @property string $send_to
 * @property string $account_number
 * @property string $account_holder
 * @property string $country_id
 * @property string $swift
 * @property string $bank_beneficiary
 * @property string $postcode
 * @property string $description
 * @property integer $charges
 * @property integer $standing
 * @property integer $execution_time
 * @property integer $urgent
 * @property integer $each_transfer
 * @property integer $each_period
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $need_confirm
 * @property integer $created_at
 * @property integer $updated_at
 */
class Transfers_Outgoing extends ActiveRecord
{

	public static $periods = array(1 => 'Day(s)', 2 => 'Week(s)', 3 => 'Month(s)');
	public $amount_cent;
	public $xabina_execution_time;
	public $external_execution_time;
	public $xabina_start_time;
	public $external_start_time;
	public $xabina_end_time;
	public $external_end_time;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_outgoing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, currency_id, account_id, send_to', 'required'),
			array('amount', 'checkBalance', 'message' => Yii::t('Front', 'Not enough money'), 'on' => 'own,xabina,external'),
			array('own_account_id', 'required', 'on' => 'own'),
			array('account_number', 'required', 'on' => 'xabina'),
			array('account_number', 'checkXabinaNumber', 'on' => 'xabina'),
			array('own_account_id', 'compare', 'compareAttribute' => 'account_id', 'operator' => '!=', 'on' => 'own', 'message' => Yii::t('Front', 'Account number is incorrect')),
			array('account_holder, external_account_number, currency_id, swift, bank_beneficiary, postcode', 'required', 'on' => 'external'),
			array('charges, standing, urgent, each_transfer, each_period, need_confirm', 'numerical', 'integerOnly'=>true),
			array('amount, amount_cent, account_number', 'numerical'),
			array('account_number', 'length', 'max'=>12, 'min' => 12),
			array('user_id, currency_id, account_id, country_id', 'length', 'max'=>10),
			array('send_to', 'length', 'max'=>8),
			//array('execution_time, start_time, end_time, xabina_execution_time, xabina_start_time, xabina_end_time, external_execution_time, external_start_time, external_end_time', 'numerical', 'min' => strtotime(date('m/d/Y'), time())),
			array('execution_time, start_time, end_time', 'numerical', 'min' => strtotime(date('m/d/Y'), time()), 'on' => 'insert', 'message' => Yii::t('Front', 'Date in not correct')),
			array('account_holder, swift, bank_beneficiary, postcode, external_account_number', 'length', 'max'=>255),
			array('description, amount, amount_cent, currency_id, account_id, send_to, execution_time, each_transfer, each_period, start_time, end_time, urgent', 'safe'),
			array('own_account_id', 'safe', 'on' => 'own'),
			array('account_number', 'safe', 'on' => 'xabina'),
			array('account_holder, external_account_number, country_id, swift, bank_beneficiary, postcode, charges', 'safe', 'on' => 'external'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, amount, currency_id, account_id, send_to, account_number, account_holder, country_id, swift, bank_beneficiary, postcode, description, charges, standing, execution_time, urgent, each_transfer, each_period, start_time, end_time, need_confirm, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	
	public function checkBalance($attribute,$params){
		if($this->account_id && $this->amount){
			$account = Accounts::model()->findByPk($this->account_id);
			if($account->user_id != Yii::app()->user->id){
				return;
			}
			$amount = $this->amount;
			if($this->amount_cent){
				$amount = $this->amount.'.'.$this->amount_cent;
			}
			if($account->balance < $amount){
				$this->addError('amount', Yii::t('Front', 'Not enough money'));
				$this->addError('amount_cent', Yii::t('Front', 'Not enough money'));
			}
		}
	}
	
	public function checkXabinaNumber($attribute,$params){
		if(!AccountService::checkNumber($this->account_number)){
			$this->addError('account_number', Yii::t('Front', 'Account number is incorrect'));
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
			'own_account' => array(self::BELONGS_TO, 'Accounts', 'own_account_id'),
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->user_id = Yii::app()->user->id;
		}
		return parent::beforeSave();
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'amount' => 'Amount',
			'currency_id' => 'Currency',
			'account_id' => 'Account',
			'send_to' => 'Send To',
			'account_number' => 'Account Number',
			'account_holder' => 'Account Holder',
			'country_id' => 'Country',
			'swift' => 'Swift',
			'bank_beneficiary' => 'Bank Beneficiary',
			'postcode' => 'Postcode',
			'description' => 'Description',
			'charges' => 'Charges',
			'standing' => 'Standing',
			'execution_time' => 'Execution Time',
			'urgent' => 'Urgent',
			'each_transfer' => 'Each Transfer',
			'each_period' => 'Each Period',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'need_confirm' => 'Need Confirm',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.status',0);
		$criteria->compare('t.need_confirm',0);
		$criteria->compare('amount',$this->amount);
		$criteria->with = 'user';
		$criteria->together = true;
		$criteria->order = 't.created_at desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function log()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.status',0);
		$criteria->compare('amount',$this->amount);
		$criteria->with = 'user';
		$criteria->together = true;
		$criteria->order = 't.created_at desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransfersOutgoing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
