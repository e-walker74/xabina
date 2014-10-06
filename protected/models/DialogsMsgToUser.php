<?php

/**
 * This is the model class for table "dialogs_msg_to_user".
 *
 * The followings are the available columns in table 'dialogs_msg_to_user':
 * @property integer $id
 * @property integer $msg_id
 * @property integer $dialog_id
 * @property string $user_id
 * @property integer $status
 * @property string $group
 * @property integer $add_time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property DialogsMsg $msg
 * @property Users $user
 * @property DialogsList $dialog
 */
class DialogsMsgToUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogs_msg_to_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msg_id, dialog_id, user_id, status, add_time', 'required'),
			//array('msg_id, dialog_id, user_id, status, group, add_time, created_at, updated_at', 'required'),
			array('msg_id, dialog_id, status, add_time, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('group', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, msg_id, dialog_id, user_id, status, group, add_time, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'msg' => array(self::BELONGS_TO, 'DialogsMsg', 'msg_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'dialog' => array(self::BELONGS_TO, 'DialogsList', 'dialog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'msg_id' => 'Msg',
			'dialog_id' => 'Dialog',
			'user_id' => 'User',
			'status' => 'Status',
			'group' => 'Group',
			'add_time' => 'Add Time',
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
		$criteria->compare('msg_id',$this->msg_id);
		$criteria->compare('dialog_id',$this->dialog_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('add_time',$this->add_time);
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
	 * @return DialogsMsgToUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
