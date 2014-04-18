<?php

/**
 * This is the model class for table "users_instmessagers".
 *
 * The followings are the available columns in table 'users_instmessagers':
 * @property integer $id
 * @property integer $user_id
 * @property integer $type_id
 * @property string $hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $is_master
 * @property integer $messager_type
 * @property string $messager_login
 */
class Users_Instmessagers extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_instmessagers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('messager_type, messager_login', 'required'),
			array('user_id, type_id, status, is_master, messager_type', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			array('messager_login', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type_id, hash, created_at, updated_at, status, is_master, messager_type, messager_login', 'safe', 'on'=>'search'),
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
			'messager_system' => array(self::BELONGS_TO, 'InstmessagerSystems', 'messager_type'),
			'type' => array(self::BELONGS_TO, 'Users_EmailTypes', 'type_id'),
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
			'type_id' => 'Type',
			'hash' => 'Hash',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
			'is_master' => 'Is Master',
			'messager_type' => 'Messager Type',
			'messager_login' => 'Messager Login',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_master',$this->is_master);
		$criteria->compare('messager_type',$this->messager_type);
		$criteria->compare('messager_login',$this->messager_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersInstmessagers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
