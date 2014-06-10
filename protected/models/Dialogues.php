<?php

/**
 * This is the model class for table "dialogues".
 *
 * The followings are the available columns in table 'dialogues':
 * @property string $id
 * @property string $owner_id
 * @property string $entity_type
 * @property string $entity_id
 * @property string $type
 *
 * The followings are the available model relations:
 * @property DialoguesMessages[] $dialoguesMessages
 * @property DialoguesUsers[] $dialoguesUsers
 */
class Dialogues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, entity_type', 'required'),
			array('owner_id, entity_id', 'length', 'max'=>11),
			array('entity_type', 'length', 'max'=>45),
			array('type', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner_id, entity_type, entity_id, type', 'safe', 'on'=>'search'),
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
			'dialoguesMessages' => array(self::HAS_MANY, 'DialoguesMessages', 'dialog_id'),
			'dialoguesUsers' => array(self::HAS_MANY, 'DialoguesUsers', 'dialog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner_id' => 'Owner',
			'entity_type' => 'Entity Type',
			'entity_id' => 'Entity',
			'type' => 'Type',
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
		$criteria->compare('owner_id',$this->owner_id,true);
		$criteria->compare('entity_type',$this->entity_type,true);
		$criteria->compare('entity_id',$this->entity_id,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dialogues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
