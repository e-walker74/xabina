<?php

/**
 * This is the model class for table "invoices".
 *
 * The followings are the available columns in table 'invoices':
 * @property integer $id
 * @property integer $user_id
 * @property integer $currency_id
 * @property string $number
 * @property string $invoice_date
 * @property string $due_date
 * @property string $reference
 * @property string $email
 * @property double $discount
 * @property double $discount_type
 * @property string $terms
 * @property string $note
 */
class Invoices extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, currency_id, number, subtotal, total', 'required'),
			array('user_id, currency_id', 'numerical', 'integerOnly'=>true),
			array('discount, subtotal, total', 'numerical'),
			array('discount_type, invoice_date, due_date', 'numerical'),
			array('number, reference, email, terms, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, currency_id, number, date, due_date, reference, email, discount, discount_type, terms, note', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'currency_id' => 'Currency',
			'number' => 'Number',
			'date' => 'Date',
			'due_date' => 'Due Date',
			'reference' => 'Reference',
			'email' => 'Email',
			'discount' => 'Discount',
			'terms' => 'Terms',
			'note' => 'Note',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('terms',$this->terms,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeValidate(){
		if($this->invoice_date){
			$this->invoice_date = strtotime($this->invoice_date);
		}
		if($this->due_date){
			$this->due_date = strtotime($this->due_date);
		}
		return parent::beforeValidate();
	}
}
