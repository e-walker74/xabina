<?php

/**
 * This is the model class for table "users_verification".
 *
 * The followings are the available columns in table 'users_verification':
 * @property integer $user_id
 * @property string $type
 * @property integer $rel_id
 */
class Users_Verification extends ActiveRecord
{
	
	const NOT_SEND_VERIFICATION = 0;
	const REQUIRES_MODERATION = 1;
	const REQUIRES_USER_CODE = 2;
	const VERIFICATION_COMPLETED = 3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_verification';
	}
	
	public static function getVerificationModel($modelId){
		$className = 'Users_Verification_' . $modelId;
        return parent::model($className, true);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, rel_id', 'required'),
			array('user_id, rel_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>18, 'message' => Yii::t('Front', 'Entry is to long')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, type, rel_id', 'safe', 'on'=>'search'),
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
			'notary' => array(self::BELONGS_TO, 'Users_Verification_Notary', 'rel_id'),
			'creditcard' => array(self::BELONGS_TO, 'Users_Verification_Creditcard', 'rel_id', 'condition' => 'canceled = 0'),
			'bankaccount' => array(self::BELONGS_TO, 'Users_Verification_Bankaccount', 'rel_id', 'condition' => 'canceled = 0'),
			'paypal' => array(self::BELONGS_TO, 'Users_Verification_Paypal', 'rel_id', 'condition' => 'canceled = 0'),
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
			'type' => 'Type',
			'rel_id' => 'Rel',
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
		$criteria->compare('type','notary');
		$criteria->compare('status',self::REQUIRES_MODERATION);
		$criteria->compare('rel_id',$this->rel_id);
		$criteria->order = 'created_at desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersVerification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
