<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property string $number
 * @property integer $user_id
 * @property integer $status
 * @property integer $type_id
 * @property string $currency_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Currencies $currency
 */
class Accounts extends ActiveRecord
{

	public $holderEmail;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, status, type_id, currency_id', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>12),
            array('number', 'unique'),
            array('name', 'length', 'max'=>25),
            array('currency_id', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, user_id, status, type_id, currency_id', 'safe', 'on'=>'search'),
			array('id, number, user_id, status, type_id, currency_id', 'safe', 'on'=>'save'),
			array('id, number, user_id, status, type_id, currency_id, holderEmail', 'safe', 'on'=>'adminSearch'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'type_info' => array(self::BELONGS_TO, 'Accounts_Types', 'type_id'),
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'transactions' => array(self::HAS_MANY, 'Transactions', 'account_id', 'order' => 'created_at desc'),
//            'category' => array(self::BELONGS_TO, 'Accounts_Category', 'category_id'),
		);
	}
	
	public function getBalanceInEUR(){
		return $this->balance / $this->currency->last_value;
	}

    /**
     * check account balance
     */
    public function checkBalance($amount, $currency){
        $sum = Currencies::convert($amount, $currency, $this->currency_id);
        return ($sum < $this->balance);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'Number',
			'user_id' => 'User',
			'status' => 'Status',
			'type_id' => 'type_id',
			'currency' => Yii::t('Front', 'Currency'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user.email',$this->holderEmail, true);
		$criteria->with = array('user');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'balance desc',
			),
			'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave(){
		if($this->isNewRecord){
			for($number = AccountService::generateNumber();
				Accounts::model()->find('number = :number', array(':number' => $number));
				$number = AccountService::generateNumber())
				{
					Yii::log('generate for user_id '.$this->user_id, CLogger::LEVEL_ERROR, 'generateAccountNumner');
			}
			$this->number = $number;
			//$this->currency_id = 1;
			//$this->type_id = 1;
			$this->status = 1;
		}
		return parent::beforeSave();
	}
	
	public function getUserBalanceInEUR($number = false){
		$criteria=new CDbCriteria;
		$criteria->compare('user_id',$this->user_id);
		$criteria->with = 'currency';
		$criteria->together = true;
		$accounts = Accounts::model()->findAll($criteria);
		$total = 0;
		foreach($accounts as $acc){
			$total += ($acc->balance / $acc->currency->last_value);
		}
		if($number){
			return $total;
		}
		$currencies = Currencies::model()->findAll();
		return Yii::app()->controller->renderPartial('application.views.banking._totalCurrencies', array('total' => $total, 'currencies' => $currencies), true);
	}
}
