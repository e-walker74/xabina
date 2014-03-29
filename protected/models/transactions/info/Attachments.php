<?php

/**
 * This is the model class for table "transactions_info_attachments".
 *
 * The followings are the available columns in table 'transactions_info_attachments':
 * @property integer $id
 * @property integer $transaction_id
 * @property string $user_file_name
 * @property string $name
 * @property string $ext
 * @property integer $deleted
 * @property string $description
 * @property string $file_type
 * @property integer $created_at
 * @property integer $updated_at
 */
class Transactions_Info_Attachments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transactions_info_attachments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_file_name, name, ext, file_type', 'required'),
			array('transaction_id, deleted', 'numerical', 'integerOnly'=>true),
			array('user_file_name, file_type', 'length', 'max'=>255),
			array('name, ext', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			array('description', 'safe', 'on' => 'update'),
			array('id, transaction_id, user_file_name, name, ext, deleted, description, file_type, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'transaction_id' => 'Transaction',
			'user_file_name' => 'User File Name',
			'name' => 'Name',
			'ext' => 'Ext',
			'deleted' => 'Deleted',
			'description' => 'Description',
			'file_type' => 'File Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('user_file_name',$this->user_file_name,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('file_type',$this->file_type,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionsInfoAttachments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
