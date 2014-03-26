<?php

/**
 * This is the model class for table "users_emails".
 *
 * The followings are the available columns in table 'users_emails':
 * @property integer $id
 * @property integer $user_id
 * @property integer $email_type
 * @property string $hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $is_master
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Users_Emails extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_emails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, email_type_id', 'required', 'on'=>'editemails'),
            array('email', 'email'),
			array('user_id, email_type_id, status, is_master', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			array('email', 'length', 'max'=>200),
            array('email', 'checkEmailUnique', 'on'=>'editemails'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, email_type_id, hash, status, is_master, email', 'safe', 'on'=>'search'),
		);
	}

    public function checkEmailUnique($attribute, $params){
        $this->email = trim($this->email);
        if($this->isNewRecord){
            $email = Users_Emails::model()->find('email = :email', array(':email' => $this->email));
        } else {
            $email = Users_Emails::model()->find('email = :email AND id != :id', array(':phone' => $this->email, ':id' => $this->id));
        }
        if($email){
            $this->addError('email', Yii::t('Front', 'This E-mail is already registered'));
        }
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
			'email' => 'Email',
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
		$criteria->compare('email_type_id',$this->email_type);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_master',$this->is_master);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersEmails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function generateHash(){
		$this->hash = md5('email' . time() . $this->email);
	}
	
    public function beforeSave(){
        if($this->isNewRecord){
            $this->generateHash();
        }
        return parent::beforeSave();
    }
}
