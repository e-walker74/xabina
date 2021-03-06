<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 * @property string $to_account_number
 * @property string $from_account_number
 * @property string $electronic_method
 * @property string $from_account_holder
 *
 * @property Transactions $transactions
 */
class Transfers_Incoming extends ActiveRecord
{
    public $need_confirm = 1;

	public static $charges = array(
        '1' => 'Shared (mandatory for EC payments)',
        '2' => 'Receiver pays the fees',
        '3' => 'Sender pays the fees'
    );
	public static $card_types = array(
        '1' => 'master-card',
        '2' => 'jcb',
        '3' => 'union-pay',
        '4' => 'maestro',
        '5' => 'visa',
        '6' => 'american-ecspress'
    );
	
	const STATUS_PENDING = 0;
	const STATUS_APPROVED = 1;
	const STATUS_REJECTED = 2;

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
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_incoming';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return array(
            array('amount, to_account_number, to_account_id, currency_id, form_type', 'required'),
            array('amount, to_account_number, currency_id, charges, counter_agent, category_id, electronic_method, card_type', 'numerical'),
			//array('from_account_number', 'boolean'),
			array('amount', 'length', 'max' => 12, 'tooLong' => Yii::t('Front', 'Max lenght is 9')),
			array('p_month', 'numerical', 'min' => 1, 'max' => 12),
			array('p_month, p_year', 'length', 'max' => 2),
			array('p_year', 'numerical', 'min' => date('y'), 'max' => date('y', time()+3600*24*365*20)),
			array('p_csc', 'numerical'),
			array('p_csc', 'length', 'max' => 3, 'min' => 3),
            array('urgent, favorite', 'boolean'),
            array('status', 'safe', 'on' => 'admin'),
			array('from_account_number, from_account_holder, tag1, tag2, tag3', 'length', 'max' => 255),
            array('description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
        );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'account' => array(self::BELONGS_TO, 'Accounts', 'to_account_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'notes' => array(self::HAS_MANY, 'Transactions_Notes', 'transaction_id', 'condition' => 'deleted = 0'),
			'category' => array(self::BELONGS_TO, 'Transactions_Categories', 'category_id'),
            'transactions' => array(self::HAS_MANY, 'Transactions', 'incoming_id'),
			//'xabina_account' => array(self::BELONGS_TO, 'Accounts', 'account_number'),
		);
	}

	public function beforeSave()
    {
		if ($this->isNewRecord) {
            $this->status = self::STATUS_PENDING;
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
		);
	}

	public function getPublicAttrs($full = false)
    {
		switch($this->form_type){
			case 'electronic':
				$return = array(
					Yii::t('Front', 'date') => date('d.m.Y', $this->created_at),
					Yii::t('Front', 'type') => 'OV', //TODO what is the type?
					Yii::t('Front', 'Value') => $this->amount . ' ' . $this->currency->code, //TODO what is the type?
					//Yii::t('Front', 'sender_name') => $this->from_account_holder,
					//Yii::t('Front', 'electronic_method') => Form_Incoming_Electronic::$methods[$this->electronic_method],
				);
				if($this->electronic_method == 1){
					$return[Yii::t('Front', Form_Incoming_Electronic::$methods[$this->electronic_method])] = 'xxxx xxxx xxxx ' . substr($this->from_account_number, -4);
					$return[Yii::t('Front', 'sender_name')] = $this->from_account_holder;
				} elseif($this->electronic_method == 2){
					$return[Yii::t('Front', Form_Incoming_Electronic::$methods[$this->electronic_method])] = $this->from_account_number;
				}
				$return[Yii::t('Front', 'recipient_name')] = $this->user->fullname;
				$return[Yii::t('Front', 'recipient_account_number')] = $this->to_account_number;
				$return[Yii::t('Front', 'details_of_payments')] = $this->description;
				$return[Yii::t('Front', 'Urgent')] = ($this->urgent) ? Yii::t('Front', 'Yes') : Yii::t('Front', 'No');
				
				return $return;
				break;
			case 'request':
				return array(
					
				);
				break;
		}
		return array();
	}

	public function getFromHolder()
    {
		switch($this->form_type){
			case 'request':
				return Users::model()->find('login = :login', array(':login' => $this->from_account_number))->fullname;
				break;
			case 'electronic':
				switch(Form_Incoming_Electronic::$methods[$this->electronic_method]){
					case 'creditcard':
						return $this->from_account_holder;
						break;
					case 'ideal':
						return number_format($this->from_account_number, 0, '.', ' ');
						break;
				}
				break;
		}
	}

    public function getFromDescription()
    {
        switch($this->form_type){
            case 'request':
                return Users::model()->find('login = :login', array(':login' => $this->from_account_number))->fullname;
                break;
            case 'electronic':
                switch(Form_Incoming_Electronic::$methods[$this->electronic_method]){
                    case 'creditcard':
                        return 'xxxx xxxx ' . substr($this->from_account_number, -4);
                        break;
                    case 'ideal':
                        return Yii::t('Front', 'ideal');
                        break;
                }
                break;
        }
    }

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.status',0);
		//$criteria->compare('t.need_confirm',0);
		$criteria->compare('amount',$this->amount);
		$criteria->with = 'user';
		$criteria->together = true;
		$criteria->order = 't.created_at desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getHtmlOperationDescription()
    {
        switch($this->form_type){
            case 'electronic':
                if($this->electronic_method == 1){
                    return '<strong class="holder">' . $this->from_account_number . '</strong><br/>' .
                    $this->from_account_holder . '<br>' .
                    $this->description;
                } else {
                    return '<strong class="holder">' . $this->from_account_number . '</strong>';
                }
                break;
        }
    }

    public function getHtmlStatus(){
        switch($this->status){
            case self::STATUS_PENDING:
                return '<span class="pending">'.Yii::t('Front', 'Pending').'</span>';
                break;
            case self::STATUS_APPROVED:
                return '<span class="approved">'.Yii::t('Front', 'Approved').'</span>';
                break;
            case self::STATUS_REJECTED:
                return '<span class="rejected">'.Yii::t('Front', 'Rejected').'</span>';
                break;
        }
    }
}