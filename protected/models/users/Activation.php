<?php

/**
 * This is the model class for table "users_activation".
 *
 * The followings are the available columns in table 'users_activation':
 * @property integer $user_id
 * @property integer $activate_step
 * @property string $first_name
 * @property string $last_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property integer $zip_code
 * @property string $town
 * @property string $country
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $moderator_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Users_Activation extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_activation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, step, first_name, last_name, address_line_1, address_line_2, zip_code, town, country, moderator_id, description', 'required'),
			array('user_id, step, zip_code, created_at, updated_at, moderator_id, country', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>30),
			array('address_line_1, address_line_2, town', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, step, first_name, last_name, address_line_1, address_line_2, zip_code, town, country, created_at, updated_at, moderator_id, description', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'activate_step' => 'Activate Step',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'address_line_1' => 'Address Line 1',
			'address_line_2' => 'Address Line 2',
			'zip_code' => 'Zip Code',
			'town' => 'Town',
			'country' => 'Country',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'moderator_id' => 'Moderator',
			'description' => 'Description',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('activate_step',$this->activate_step);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('address_line_1',$this->address_line_1,true);
		$criteria->compare('address_line_2',$this->address_line_2,true);
		$criteria->compare('zip_code',$this->zip_code);
		$criteria->compare('town',$this->town,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('moderator_id',$this->moderator_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersActivation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
