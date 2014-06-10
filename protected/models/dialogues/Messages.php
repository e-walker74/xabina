<?php

/**
 * This is the model class for table "dialogues_messages".
 *
 * The followings are the available columns in table 'dialogues_messages':
 * @property string $id
 * @property string $dialog_id
 * @property string $user_id
 * @property integer $status
 * @property string $category_id
 * @property string $read_at
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property DialoguesMessagesCategories $category
 * @property Dialogues $dialog
 * @property DialoguesMessagesLinks[] $dialoguesMessagesLinks
 */
class Dialogues_Messages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogues_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dialog_id, status, message, created_at, updated_at', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('dialog_id, user_id, category_id, read_at, created_at, updated_at', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dialog_id, user_id, status, category_id, read_at, message, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Dialogues_Messages_Categories', 'category_id'),
			'dialog' => array(self::BELONGS_TO, 'Dialogues', 'dialog_id'),
			'dialoguesMessagesLinks' => array(self::HAS_MANY, 'Dialogues_Messages_Links', 'message_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dialog_id' => 'Dialog',
			'user_id' => 'User',
			'status' => 'Status',
			'category_id' => 'Category',
			'read_at' => 'Read At',
			'message' => 'Message',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('dialog_id',$this->dialog_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('read_at',$this->read_at,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DialoguesMessages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
