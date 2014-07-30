<?php

/**
 * This is the model class for table "transactions".
 *
 * The followings are the available columns in table 'transactions':
 * @property integer $id
 * @property integer $account_id
 * @property string $type
 * @property string $transfer_type
 * @property int     $outgoing_id
 * @property int     $incoming_id
 * @property double $amount
 * @property double $acc_balance
 *
 * The followings are the available model relations:
 * @property Accounts $account
 */
class Transactions extends ActiveRecord
{
	
	private $_info = false;
	
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
			array('account_id, type, amount, transfer_type, transfer_id', 'required'),
			array('account_id, transfer_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'type', 'type'=>'float'),
			array('operation', 'safe', 'on' => 'admin'),
			array('type', 'in', 'range'=>array('positive', 'negative'), 'allowEmpty'=>false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, type, amount', 'safe', 'on'=>'search'),
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
			'info' => array(self::BELONGS_TO, 'Transactions_Info', 'info_id'), // deleted
			//'attachments' => array(self::HAS_MANY, 'Transactions_Info_Attachments', 'transaction_id'),
			'notes' => array(self::HAS_MANY, 'Transactions_Notes', 'transaction_id', 'condition' => 'deleted = 0'),
			'link' => array(self::HAS_ONE, 'Transactions_Categories_Links', 'transaction_id'),
			'category' => array(self::HAS_ONE, 'Transactions_Categories', array('category_id' => 'id'), 'through' => 'link'),
            'alertRules' => array(self::HAS_MANY, 'Users_AlertsRules', array('account_id' => 'account_id', 'user_id' => 'user_id')),
		);
	}

	public function getTransfer(){
		if($this->_info !== false){
			return $this->_info;
		}
		if(!$this->transfer_type){
			return false;
		}
		switch($this->transfer_type){
			case 'outgoing':
				$this->_info = Transfers_Outgoing::model()->findByPk($this->transfer_id);
				break;
			case 'incoming':
				$this->_info = Transfers_Incoming::model()->findByPk($this->transfer_id);
				break;
		}
		return $this->_info;
	}
	
	public function getFromInformation(){
		$this->getTransfer();
		switch($this->transfer_type){
			case 'outgoing':
				break;
			case 'incoming':
				$this->_info = Transfers_Incoming::model()->findByPk($this->transfer_id);
				break;
		}
	}
	
	public function getToInformation(){
		
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
			'amount' => 'amount',
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

    /**
     * TODO: rename field sum to amount
     */
    public function getSum(){
        return $this->amount;
    }
}
