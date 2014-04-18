<?php

/**
 * This is the model class for table "users_deleted".
 *
 * The followings are the available columns in table 'users_deleted':
 * @property integer $id
 * @property string $login
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property integer $role
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $hash
 * @property string $phone
 * @property string $lang
 */
class Users_Deleted extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_deleted';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, login, last_name, password, role, email, status, created_at, updated_at, hash, phone, lang', 'required'),
			array('id, role, status, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('login, email', 'length', 'max'=>255),
			array('first_name, last_name', 'length', 'max'=>30),
			array('password, hash', 'length', 'max'=>32),
			array('phone', 'length', 'max'=>19),
			array('lang', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, first_name, last_name, password, role, email, status, created_at, updated_at, hash, phone, lang', 'safe'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'password' => 'Password',
			'role' => 'Role',
			'email' => 'Email',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'hash' => 'Hash',
			'phone' => 'Phone',
			'lang' => 'Lang',
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('lang',$this->lang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersDeleted the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
