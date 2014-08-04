<?php

/**
 * This is the model class for table "users_activation".
 *
 * The followings are the available columns in table 'users_activation':
 * @property integer $user_id
 * @property integer $step
 * @property string $first_name
 * @property string $last_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property integer $zip_code
 * @property string $town
 * @property string $country_id
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
			array('user_id, step, first_name, last_name, address_line_1, zip_code, town, country_id', 'required'),
			array('terms, fee_structure', 'in', 'range' => array(1), 'on' => 'terms', 'message' => Yii::t('Front', 'Do you not agree with rules?')),
			array('user_id, step, created_at, updated_at, moderator_id, country_id', 'numerical', 'integerOnly'=>true),
			array('zip_code', 'length', 'min' => 2, 'max' => 9, 'tooShort' => Yii::t('Front', 'Zip Code is too short'), 'tooLong' => Yii::t('Front', 'Zip Code is too long')),
			array('address_line_1, address_line_2, town, first_name, last_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, step, first_name, last_name, address_line_1, address_line_2, zip_code, town, country_id, created_at, updated_at, moderator_id, description', 'safe', 'on'=>'search'),
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
			'files' => array(self::HAS_MANY, 'Users_Files', 'user_id', 'condition' => 'form = "activation" AND deleted = 0'),
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'step' => 'Activate Step',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'address_line_1' => 'Address Line 1',
			'address_line_2' => 'Address Line 2',
			'zip_code' => 'Zip Code',
			'town' => 'Town',
			'country_id' => 'Country',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'moderator_id' => 'Moderator',
			'description' => 'Moderator Description',
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
		$criteria->compare('step', $this->step);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('address_line_1',$this->address_line_1,true);
		$criteria->compare('address_line_2',$this->address_line_2,true);
		$criteria->compare('zip_code',$this->zip_code);
		$criteria->compare('town',$this->town,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('moderator_id',$this->moderator_id);
		$criteria->compare('description',$this->description,true);
		
		if(!isset($_GET['Users_Activation'])){
			$criteria->order = 'updated_at desc';
		}

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
