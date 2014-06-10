<?php

/**
 * This is the model class for table "personal_managers".
 *
 * The followings are the available columns in table 'personal_managers':
 * @property integer $id
 * @property string $manager_name
 * @property integer $manager_state
 * @property string $phone
 * @property string $email
 * @property string $language
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property UsersPersonalManagers[] $usersPersonalManagers
 */
class PersonalManagers extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'personal_managers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('manager_name, phone, email, language', 'required'),
            array('manager_state', 'numerical', 'integerOnly'=>true),
            array('email', 'email'),
            array('manager_name, phone, email', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, manager_name, manager_state, phone, email, language, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'usersPersonalManagers' => array(self::HAS_MANY, 'UsersPersonalManagers', 'manager_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'manager_name' => 'Manager Name',
			'manager_state' => 'Manager State',
			'phone' => 'Phone',
			'email' => 'Email',
			'language' => 'Language',
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
		$criteria->compare('manager_name',$this->manager_name,true);
		$criteria->compare('manager_state',$this->manager_state);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('language',$this->language,true);
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
	 * @return PersonalManagers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
