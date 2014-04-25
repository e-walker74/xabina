<?php

/**
 * This is the model class for table "transactions_notes".
 *
 * The followings are the available columns in table 'transactions_notes':
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $user_id
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted
 */
class Transactions_Notes extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transactions_notes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_id, user_id, text', 'required'),
			array('transaction_id, user_id, deleted', 'numerical', 'integerOnly'=>true),
			array('text', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transaction_id, user_id, text, created_at, updated_at, deleted', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_id' => 'Transaction',
			'user_id' => 'User',
			'text' => 'Text',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted' => 'Deleted',
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
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionsNotes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
