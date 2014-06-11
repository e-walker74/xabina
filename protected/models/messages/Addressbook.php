<?php

/**
 * This is the model class for table "messages_addressbook".
 *
 * The followings are the available columns in table 'messages_addressbook':
 * @property integer $id
 * @property integer $user_id
 * @property integer $to_login
 * @property integer $to_user_id
 * @property integer $to_name
 * @property integer $is_favorite
 */
class Messages_Addressbook extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages_addressbook';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, to_login, to_user_id, to_name, is_favorite', 'required'),
			array('user_id, to_login, to_user_id, to_name, is_favorite', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, to_login, to_user_id, to_name, is_favorite', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'to_login' => 'To Login',
			'to_user_id' => 'To User',
			'to_name' => 'To Name',
			'is_favorite' => 'Is Favorite',
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
		$criteria->compare('to_login',$this->to_login);
		$criteria->compare('to_user_id',$this->to_user_id);
		$criteria->compare('to_name',$this->to_name);
		$criteria->compare('is_favorite',$this->is_favorite);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessagesAddressbook the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
