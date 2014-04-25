<?php

/**
 * This is the model class for table "transactions".
 *
 * The followings are the available columns in table 'transactions':
 * @property integer $id
 * @property integer $account_id
 * @property string $type
 * @property integer $sum
 *
 * The followings are the available model relations:
 * @property Accounts $account
 */
class Transactions extends ActiveRecord
{
	public $user_id;
	public $account_number;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_number', 'checkNumber', 'on' => 'admin'),
			array('account_number', 'length', 'max' => 12, 'min' => 12, 'on' => 'admin'),
			array('account_id, type, sum', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('sum', 'type', 'type'=>'float'),
			array('operation', 'safe', 'on' => 'admin'),
			array('type', 'in', 'range'=>array('positive', 'negative'), 'allowEmpty'=>false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, type, sum', 'safe', 'on'=>'search'),
		);
	}

	public function checkNumber($attribute, $params){
		if(!AccountService::checkNumber($this->account_number)){
			$this->addError('account_number', Yii::t('Transfers', 'Number is incorrect'));
		} elseif(!Accounts::model()->find('number = :n', array(':n' => $this->account_number))) {
			$this->addError('account_number', Yii::t('Transfers', 'This number not found in system'));
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
			'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
			'info' => array(self::HAS_ONE, 'Transactions_Info', 'transaction_id'),
			'attachments' => array(self::HAS_MANY, 'Transactions_Info_Attachments', 'transaction_id'),
			'notes' => array(self::HAS_MANY, 'Transactions_Notes', 'transaction_id', 'condition' => 'deleted = 0'),
			'link' => array(self::HAS_ONE, 'Transactions_Categories_Links', 'transaction_id'),
			'category' => array(self::HAS_ONE, 'Transactions_Categories', array('category_id' => 'id'), 'through' => 'link'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => 'Account',
			'type' => 'Type',
			'sum' => 'Sum',
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

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account.user_id',$this->user_id);
		$criteria->with = 'account';
		$criteria->together = true;
		
		$criteria->order = 't.created_at desc';
		$criteria->limit = 5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
