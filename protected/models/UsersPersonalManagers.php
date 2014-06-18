<?php

/**
 * This is the model class for table "users_personal_managers".
 *
 * The followings are the available columns in table 'users_personal_managers':
 * @property integer $manager_id
 * @property integer $user_id
 * @property integer $widget_state
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property PersonalManagers $manager
 */
class UsersPersonalManagers extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_personal_managers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('manager_id, user_id, widget_state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('manager_id, user_id, widget_state', 'safe', 'on'=>'search'),
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
			'manager' => array(self::BELONGS_TO, 'PersonalManagers', 'manager_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'manager_id' => 'Manager',
			'user_id' => 'User',
			'widget_state' => 'Widget State',
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

		$criteria->compare('manager_id',$this->manager_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('widget_state',$this->widget_state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersPersonalManagers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
