<?php

/**
 * This is the model class for table "dialogs_users".
 *
 * The followings are the available columns in table 'dialogs_users':
 * @property integer $id
 * @property string $user_id
 * @property integer $dialog_id
 * @property string $name
 * @property integer $add_time
 * @property integer $delete_time
 * @property integer $delete_last_time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property DialogsList $dialog
 * @property Users $user
 */
class DialogsUsers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogs_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, dialog_id, add_time', 'required'),
			//array('user_id, dialog_id, name, add_time, delete_time, delete_last_time, created_at, updated_at', 'required'),
			array('dialog_id, add_time, delete_time, delete_last_time, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, dialog_id, name, add_time, delete_time, delete_last_time, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'dialog' => array(self::BELONGS_TO, 'DialogsList', 'dialog_id'),
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
			'dialog_id' => 'Dialog',
			'name' => 'Name',
			'add_time' => 'Add Time',
			'delete_time' => 'Delete Time',
			'delete_last_time' => 'Delete Last Time',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('dialog_id',$this->dialog_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('delete_time',$this->delete_time);
		$criteria->compare('delete_last_time',$this->delete_last_time);
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
	 * @return DialogsUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
