<?php

/**
 * This is the model class for table "users_pins".
 *
 * The followings are the available columns in table 'users_pins':
 * @property integer $id
 * @property integer $user_id
 * @property integer $pin1
 * @property integer $pin1_exp
 * @property integer $pin2
 * @property integer $pin2_exp
 * @property integer $pin3
 * @property integer $pin3_exp
 */
class Users_Pins extends ActiveRecord
{

	public $old_pass;
	public $confirm_pass;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_pins';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pin1, pin1_exp', 'required', 'on' => 'pin1', 'message' => Yii::t('Front', 'Cannot be blank.')),
			array('pin2, pin2_exp', 'required', 'on' => 'pin2', 'message' => Yii::t('Front', 'Cannot be blank.')),
			array('pin3, pin3_exp', 'required', 'on' => 'pin3', 'message' => Yii::t('Front', 'Cannot be blank.')),
			array('confirm_pass', 'required'),
			array('confirm_pass, old_pass', 'safe'),
			array('old_pass', 'checkUserNewPass'),
			array('confirm_pass', 'checkConfirm'),

			array('user_id, pin1_exp, pin2_exp, pin3_exp', 'numerical', 'integerOnly'=>true, 'message' => Yii::t('Front', 'Password lifetime is incorrect')),
            array('pin1, pin2, pin3, confirm_pass, old_pass', 'length', 'min' => 6, 'max' => 32, 'tooLong' => Yii::t('Front', 'long_pass'), 'tooShort' => Yii::t('Front', 'short_pass')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, pin1, pin1_exp, pin2, pin2_exp, pin3, pin3_exp', 'safe', 'on'=>'search'),
		);
	}
	
	public function checkUserNewPass($attributes, $params){
		$oldPin = false;
		$pass = false;
		$oldPins = Users_Pins::model()->find('user_id = :uid', array(':uid' => Yii::app()->user->id));
		switch($this->scenario){
			case 'pin1':
				$pass = $this->pin1;
				if($oldPins && $oldPins->pin1){
					$oldPin = $oldPins->pin1;
				}
				break;
			case 'pin2':
				$pass = $this->pin2;
				if($oldPins && $oldPins->pin2){
					$oldPin = $oldPins->pin2;
				}
				break;
			case 'pin3':
				$pass = $this->pin3;
				if($oldPins && $oldPins->pin3){
					$oldPin = $oldPins->pin3;
				}
				break;
		}
		
		if($oldPin && $oldPin != md5($this->old_pass)){
			$this->addError('old_pass', Yii::t('Front', 'Old Pass is incorrect'));
		}
		
	}

	public function checkConfirm($attributes, $params){
		$oldPin = false;
		$oldPins = Users_Pins::model()->find('user_id = :uid', array(':uid' => Yii::app()->user->id));
		$newPin = false;
		switch($this->scenario){
			case 'pin1':
				$newPin = $this->pin1;
				if($oldPins && $oldPins->pin1){
					$oldPin = $oldPins->pin1;
				}
				break;
			case 'pin2':
				$newPin = $this->pin2;
				if($oldPins && $oldPins->pin2){
					$oldPin = $oldPins->pin2;
				}
				break;
			case 'pin3':
				$newPin = $this->pin3;
				if($oldPins && $oldPins->pin3){
					$oldPin = $oldPins->pin3;
				}
				break;
		}
		if($newPin != $this->confirm_pass){
			$this->addError('confirm_pass', Yii::t('Front', 'Confirm new password is incorrect'));
		}
		if($oldPin && $oldPin == md5($newPin)){
			$this->addError($this->scenario, Yii::t('Front', 'New password should be different than the old one'));
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
			'pin1' => 'Pin1',
			'pin1_exp' => 'Pin1 Exp',
			'pin2' => 'Pin2',
			'pin2_exp' => 'Pin2 Exp',
			'pin3' => 'Pin3',
			'pin3_exp' => 'Pin3 Exp',
		);
	}
	
	public function beforeSave(){
		switch($this->scenario){
			case 'pin1':
				$this->pin1 = md5($this->pin1);
				break; 
			case 'pin2':
				$this->pin2 = md5($this->pin2);
				break;
			case 'pin3':
				$this->pin3 = md5($this->pin3);
				break;
		}
		return parent::beforeSave();
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
		$criteria->compare('pin1',$this->pin1);
		$criteria->compare('pin1_exp',$this->pin1_exp);
		$criteria->compare('pin2',$this->pin2);
		$criteria->compare('pin2_exp',$this->pin2_exp);
		$criteria->compare('pin3',$this->pin3);
		$criteria->compare('pin3_exp',$this->pin3_exp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersPins the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
