<?php

/**
 * This is the model class for table "users_verification_creditcard".
 *
 * The followings are the available columns in table 'users_verification_creditcard':
 * @property integer $id
 * @property integer $user_id
 * @property string $account_number
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users_Verification_Creditcard extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_verification_creditcard';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verification_code', 'required', 'on' => 'verification_code'),
			array('account_number', 'unique'),
			array('account_number, account_holder, expiry_year, expiry_month, cvc_code', 'required'),
			array('user_id, expiry_year, expiry_month, cvc_code', 'numerical', 'integerOnly'=>true),
			array('account_holder', 'match', 'pattern'=>'/[a-zA-Z -]+/', 'message' => Yii::t('Front', 'name is incorect')),
			array('cvc_code', 'length', 'min' => 3, 'max'=>4, 'message' => Yii::t('Front', 'card id not valid')),
			array('account_number', 'length', 'min' => 14, 'max'=>19, 'message' => Yii::t('Front', 'card id not valid')),
			array('account_number', 'match', 'pattern'=>'/^((34)|(35)|(4)|(62[0-5]0)|(5[0-6])|(67))[\d+]/', 'message' => Yii::t('Front', 'card id not valid')),
			array('account_number', 'checkCard'),
			array('verification_code', 'numerical', 'on' => 'verification_code'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, account_number, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
	
	public function checkCard(){
		if(!AccountService::checkNumber($this->account_number, strlen($this->account_number))){
			$this->addError('account_number', Yii::t('Front', 'Card id not valid'));
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
			'account_number' => 'Account Number',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('account_number',$this->account_number,true);
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
	 * @return UsersVerificationCreditcard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
