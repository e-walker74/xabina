<?php

/**
 * This is the model class for table "user_alert_rules".
 *
 * The followings are the available columns in table 'user_alert_rules':
 * @property string $id
 * @property integer $user_id
 * @property integer $account_id
 * @property string $alert_id
 * @property string $greater
 * @property string $less
 * @property string $equal
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Accounts $account
 * @property Alerts $alert
 * @property Users_AlertsEmail[] $emails
 * @property Users_AlertsPhone[] $phones
 */
class Users_AlertsRules extends ActiveRecord
{
    public $alert_code;

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

    /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, alert_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('alert_id, greater, less, equal', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, alert_id, greater, less, equal', 'safe', 'on'=>'search'),
		);
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
			'emails' => array(self::HAS_MANY, 'Users_AlertsEmail', 'alert_rule_id'),
			'phones' => array(self::HAS_MANY, 'Users_AlertsPhone', 'alert_rule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'ссылка на users',
			'alert_id' => 'ссылка на alerts',
			'greater' => 'правило "больше"',
			'less' => 'правило "меньше"',
			'equal' => 'правило "равно"',
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
        foreach ($this->emails as $item) {
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
        foreach ($this->phones as $item) {
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
