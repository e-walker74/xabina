<?php

/**
 * This is the model class for table "users_verification_creditcard".
 *
 * The followings are the available columns in table 'users_verification_creditcard':
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property string $swift
 * @property string $account_number
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users_Verification_Paypal extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_verification_paypal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('verification_code', 'required', 'on' => 'verification_code'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('verification_code', 'numerical', 'on' => 'verification_code'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, country_id, swift, account_number, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	
	/*public function checkCard(){
		if(!AccountService::checkNumber($this->account_number, strlen($this->account_number))){
			$this->addError('account_number', Yii::t('Front', 'Card id not valid'));
		}
	}*/

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'verification' => array(self::HAS_ONE, 'Users_Verification', 'rel_id'),
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
			'email' => Yii::t('Front', 'Paypal account email'),
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersVerificationCreditcard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
