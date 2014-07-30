<?php

/**
 * This is the model class for table "users_notification".
 *
 * The followings are the available columns in table 'users_notification':
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property string $type
 * @property integer $closed
 * @property string $style
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Users_Notification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, message, type, closed, style', 'required'),
			array('user_id, closed', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>30),
			array('type', 'in','range'=>array('close','critical'),'allowEmpty'=>false),
			array('style', 'in','range'=>array('green','yellow','red'),'allowEmpty'=>false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, message, type, closed, style', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'message' => 'Message',
			'type' => 'Type',
			'closed' => 'Closed',
			'style' => 'Style',
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
		$criteria->compare('message',$this->message,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('closed',$this->closed);
		$criteria->compare('style',$this->style,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersNotification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
