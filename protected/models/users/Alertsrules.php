<?php

/**
 * This is the model class for table "user_alert_rules".
 *
 * The followings are the available columns in table 'user_alert_rules':
 * @property string $id
 * @property integer $user_id
 * @property integer $account_id
 * @property string $alert_id
 * @property double $greater
 * @property double $less
 * @property double $equal
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Accounts $account
 * @property Alerts $alert
 * @property Users_AlertsEmail[] $alertEmails
 * @property Users_AlertsPhone[] $alertPhones
 * @property Transactions[] $transactions
 */
class Users_AlertsRules extends ActiveRecord
{
    public $alert_code;

    /** @var $emails array */
    public $emails;
    /** @var $phones array */
    public $phones;

    public $greater;
    public $less;
    public $equal;

    public $greater_cent;
    public $less_cent;
    public $equal_cent;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_alerts_rules';
	}

    /**
     * @param integer $account_id
     * @return Users_AlertsRules $this
     */
    public function byAccountID($account_id)
    {
        $this->getDbCriteria()->mergeWith(array(
                'condition' => 'account_id = :accountId',
                'params' => array(':accountId'=>$account_id)
            ));
        return $this;
    }
    /**
     * @param integer $account_number
     * @return Users_AlertsRules $this
     */
    public function byAccountNumber($account_number)
    {
        $this->getDbCriteria()->mergeWith(array(
                'with' => 'account',
                'condition' => 'account.account_number = :accountNumber',
                'params' => array(':accountNumber'=>$account_number)
            ));
        return $this;
    }

    protected function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->greater = $this->greater != '' ? floor($this->greater)+($this->greater_cent/100) : '';
            $this->less = $this->less != '' ? floor($this->less)+($this->less_cent/100) : '';
            $this->equal = $this->equal != '' ? floor($this->equal)+($this->equal_cent/100) : '';
            return true;
        }
        return false;
    }


    /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, alert_id', 'required'),
			array('emails, phones', 'recipientValidator'),
			array('user_id', 'numerical', 'integerOnly'=>true),
            array('greater, less, equal, greater_cent, less_cent, equal_cent', 'numerical'),
            array('greater, less, equal', 'rulesValidator'),
			array('greater, less, equal', 'length', 'max' => 12, 'tooLong' => Yii::t('Front', 'Max lenght is 9')),
			array('greater_cent, less_cent, equal_cent', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, alert_id, greater, less, equal', 'safe', 'on'=>'search'),
		);
	}

    public function recipientValidator($attribute, $params)
    {
        $valid = false;
        foreach ($this->emails as $emailID => $active) {
            if($active == 1) {
                $valid = true;
                break;
            }
        }
        if(!$valid) {
            foreach ($this->phones as $phoneID => $active) {
                if($active == 1) {
                    $valid = true;
                    break;
                }
            }
        }
        if(!$valid) {
            $this->addError('emails', Yii::t('Front', 'You don\'t choose recipient'));
        }
    }

    public function rulesValidator($attribute, $params)
    {
        if($this->alert && $this->alert->use_rules == 1) {
            $emptyAttributes = array();
            $validateAttributes = array('greater', 'less', 'equal');
            foreach($validateAttributes as $attr) {
                if(empty($this->{$attr})) {
                    $emptyAttributes[] = $attr;
                }
            }
            if(count($validateAttributes) == count($emptyAttributes)) {
                $this->addError($attribute, Yii::t('Front', 'Rules can not be empty'));
            }
        }
    }

    public function scopes()
    {
        return array(
            'currentUser' => array(
                'condition' => 'user_id=:uid',
                'params' => array(':uid'=>Yii::app()->user->id)
            )
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
			'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
			'alert' => array(self::BELONGS_TO, 'Alerts', 'alert_id'),
			'alertEmails' => array(self::HAS_MANY, 'Users_AlertsEmail', 'alert_rule_id'),
			'alertPhones' => array(self::HAS_MANY, 'Users_AlertsPhone', 'alert_rule_id'),
			'transactions' => array(self::HAS_MANY, 'Transactions', array('account_id' => 'account_id', 'user_id' => 'user_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => Yii::t('Front', 'User'),
			'alert_id' => Yii::t('Front', 'Alert'),
			'greater' => Yii::t('Front', 'Greater'),
			'less' => Yii::t('Front', 'Less'),
			'equal' => Yii::t('Front', 'Equal'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('alert_id',$this->alert_id,true);
		$criteria->compare('greater',$this->greater,true);
		$criteria->compare('less',$this->less,true);
		$criteria->compare('equal',$this->equal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return array
     */
    public static function getAlertCodeChoices()
    {
        return CHtml::listData(Alerts::model()->withRules()->findAll(), 'code', 'name');
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users_AlertsRules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function saveEmails($emails)
    {
        Users_AlertsEmail::model()->deleteAllByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'alert_rule_id' => $this->id
            ));
        foreach ($emails as $emailID => $active) {
            if($active) {
                $modelEmail = Users_Emails::model()->findByPk($emailID);
                if($modelEmail && $modelEmail->user_id == Yii::app()->user->id) {
                    $ruleEmail = new Users_AlertsEmail();
                    $ruleEmail->alert_rule_id = $this->id;
                    $ruleEmail->user_id = Yii::app()->user->id;
                    $ruleEmail->email_id = $emailID;
                    $ruleEmail->save();
                }
            }
        }
    }

    /**
     * @param Users_Emails $email
     * @return bool
     */
    public function inEmails($email)
    {
        foreach ($this->alertEmails as $item) {
            if($item->email_id == $email->id)
                return true;
        }
        return false;
    }

    /**
     * @param Users_Phones $phone
     * @return bool
     */
    public function inPhones($phone)
    {
        foreach ($this->alertPhones as $item) {
            if($item->phone_id == $phone->id)
                return true;
        }
        return false;
    }

    public function savePhones($phones)
    {
        Users_AlertsPhone::model()->deleteAllByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'alert_rule_id' => $this->id
            ));
        foreach ($phones as $phoneID => $active) {
            if($active) {
                $modelPhone = Users_Phones::model()->findByPk($phoneID);
                if($modelPhone && $modelPhone->user_id == Yii::app()->user->id) {
                    $rulePhone = new Users_AlertsPhone();
                    $rulePhone->alert_rule_id = $this->id;
                    $rulePhone->user_id = Yii::app()->user->id;
                    $rulePhone->phone_id = $phoneID;
                    $rulePhone->save();
                }
            }
        }
    }

}
