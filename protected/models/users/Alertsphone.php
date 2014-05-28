<?php

/**
 * This is the model class for table "users_alerts_phone".
 *
 * The followings are the available columns in table 'users_alerts_phone':
 * @property string $id
 * @property integer $user_id
 * @property integer $phone_id
 * @property integer $alert_rule_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Users_Phones $phone
 * @property Users_AlertsRules $alertRule
 */
class Users_AlertsPhone extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_alerts_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, phone_id', 'required'),
			array('user_id, phone_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, phone_id', 'safe', 'on'=>'search'),
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
			'phone' => array(self::BELONGS_TO, 'Users_Phones', 'phone_id'),
			'alertsRule' => array(self::BELONGS_TO, 'Users_AlertsRules', 'alert_rule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'ссылка на users',
			'phone_id' => 'ссылка на users_phones',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('phone_id',$this->phone_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users_AlertsPhone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
