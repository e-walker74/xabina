<?php

/**
 * This is the model class for table "users_phones".
 *
 * The followings are the available columns in table 'users_phones':
 * @property integer $id
 * @property integer $user_id
 * @property integer $email_type_id
 * @property string $hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $is_master
 * @property string $phone
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property EmailTypes $emailType
 */
class Users_Phones extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_phones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_type_id, phone', 'required', 'on'=>'editephones'),
            array('phone', 'match', 'pattern' => '/^(\+?\d+)?\s*(\(\d+\))?[\s-]*([\d-]*)$/'),
			array('user_id, email_type_id, status, is_master', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			array('phone', 'length', 'max'=>12),
            array('phone', 'length', 'min'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, email_type_id, hash, status, is_master, phone', 'safe', 'on'=>'search'),
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
			'emailType' => array(self::BELONGS_TO, 'Users_EmailTypes', 'email_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'email_type_id' => 'Email Type',
			'hash' => 'Hash',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
			'is_master' => 'Is Master',
			'phone' => 'Phone',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('email_type_id',$this->email_type_id);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_master',$this->is_master);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersPhones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if($this->isNewRecord){
            $this->hash = md5($this->phone . 'xabina hash' . time());
        }
        return parent::beforeSave();
    }
}
