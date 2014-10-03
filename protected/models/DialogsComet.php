<?php

/**
 * This is the model class for table "dialogs_comet".
 *
 * The followings are the available columns in table 'dialogs_comet':
 * @property integer $id
 * @property integer $add_time
 * @property string $type
 * @property integer $type_id
 * @property string $params
 * @property string $author_id
 * @property string $user_id
 * @property integer $create_at
 * @property integer $update_at
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Users $author
 */
class DialogsComet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogs_comet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('add_time, type, type_id, user_id, author_id', 'required'),
			//array('add_time, type, type_id, params, author_id, user_id, create_at, update_at', 'required'),
			array('add_time, type_id, create_at, update_at', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>255),
			array('author_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, add_time, type, type_id, params, author_id, user_id, create_at, update_at', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'add_time' => 'Add Time',
			'type' => 'Type',
			'type_id' => 'Type',
			'params' => 'Params',
			'author_id' => 'Author',
			'user_id' => 'User',
			'create_at' => 'Create At',
			'update_at' => 'Update At',
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
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('create_at',$this->create_at);
		$criteria->compare('update_at',$this->update_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DialogsComet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
