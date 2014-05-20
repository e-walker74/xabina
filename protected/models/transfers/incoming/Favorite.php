<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 */
class Transfers_Incoming_Favorite extends ActiveRecord
{

    public $need_confirm = 1;

	public static $charges = array('1' => 'Shared (mandatory for EC payments)', 2 => 'Receiver pays the fees', 3 => 'Sender pays the fees');
	
	const PENDING_STATUS = 0;
	const APPROVED_STATUS = 1;
	const REJECTED_STATUS = 2;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_incoming_favorite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return array(
            array('amount, to_account_number, to_account_id, currency_id, form_type', 'required'),
            array('card_type, amount, to_account_number, currency_id, charges, counter_agent, category_id, electronic_method', 'numerical'),
			//array('from_account_number', 'boolean'),
			array('p_month', 'numerical', 'min' => 1, 'max' => 12),
			array('p_month', 'length', 'max' => 2),
			array('p_year', 'numerical', 'min' => date('Y'), 'max' => date('Y', time()+3600*24*365*20)),
			array('p_year', 'length', 'is' => 4, 'max' => 4),
			array('p_csc', 'numerical'),
			array('p_csc', 'length', 'max' => 3, 'min' => 3),
            array('urgent', 'boolean'),
			array('from_account_number, from_account_holder, tag1, tag2, tag3', 'length', 'max' => 255),
            array('description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
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
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'account' => array(self::BELONGS_TO, 'Accounts', 'to_account_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			//'xabina_account' => array(self::BELONGS_TO, 'Accounts', 'account_number'),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
            $this->status = self::PENDING_STATUS;
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
