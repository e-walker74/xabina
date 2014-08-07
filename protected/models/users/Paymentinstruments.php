<?php

/**
 * This is the model class for table "{{users_payment_instruments}}".
 *
 * The followings are the available columns in table '{{users_payment_instruments}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string  $from_account_number
 * @property string  $from_account_holder
 * @property integer $electronic_method
 * @property integer $card_type
 * @property integer $p_month
 * @property integer $p_year
 * @property integer $p_csc
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $bank_id
 * @property string  $bic
 */
class Users_Paymentinstruments extends Users_Profile
{

    const METHOD_CREDITCARD = 1;
    const METHOD_IDEAL = 2;
    const METHOD_BANK_ACCOUNT = 3;
    const METHOD_PAYPAL = 4;
    const METHOD_SKRILL = 5;
    const METHOD_WEBMONEY = 6;

    public static $methods = array(
        self::METHOD_CREDITCARD => 'creditcard',
        self::METHOD_IDEAL => 'ideal',
        self::METHOD_BANK_ACCOUNT => 'bank_account',
        self::METHOD_PAYPAL => 'paypal',
        self::METHOD_SKRILL => 'webmoney',
        self::METHOD_WEBMONEY => 'skrill',
    );

    public $status = 1;

    // creditcard params
    public $creditcard_holder;
    public $creditcard_number;
    // ideal params
    public $ideal_account_number;
    // bank account
    public $bank_name;
    // paypal
    public $paypal_account_number;
    // webmoney
    public $webmoney_account_number;
    // skrill
    public $skrill_account_number;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return $this the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_payment_instruments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('electronic_method, category_id', 'numerical'),
            array('electronic_method', 'required'),
            array('from_account_number, from_account_holder', 'length', 'max' => 255),
            array('from_account_number, from_account_holder', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            // creditcard
            array('card_type, p_month, p_year, p_csc, creditcard_number, creditcard_holder', 'required', 'on' => 'creditcard'),
            array('creditcard_number', 'match', 'pattern' => '/^((34)|(35)|(37)|(4)|(62[0-5]0)|(5[0-6])|(62)|(88))[\d+]/', 'message' => Yii::t('Front', 'card id not valid'), 'on' => 'creditcard'),
            array('creditcard_number', 'ext.validators.Card', 'on' => 'creditcard'),
            array('card_type', 'numerical', 'on' => 'creditcard'),
            array('p_month', 'numerical', 'min' => 1, 'max' => 12, 'on' => 'creditcard'),
            array('p_month, p_year', 'length', 'max' => 2, 'on' => 'creditcard'),
            array('p_year', 'numerical', 'min' => date('y'), 'max' => date('y', time() + 3600 * 24 * 365 * 20), 'on' => 'creditcard'),
            array('p_csc', 'numerical'),
            array('p_csc', 'length', 'max' => 3, 'min' => 3, 'on' => 'creditcard'),
            // ideal
            array('ideal_account_number', 'required', 'on' => 'ideal'),
            array('ideal_account_number', 'numerical', 'on' => 'ideal'),
            // paypal
            array('paypal_account_number', 'required', 'on' => 'paypal'),
            array('paypal_account_number', 'email', 'on' => 'paypal'),
            // webmoney
            array('webmoney_account_number', 'required', 'on' => 'webmoney'),
            array('webmoney_account_number', 'numerical', 'on' => 'webmoney'),
            // paypal
            array('skrill_account_number', 'required', 'on' => 'skrill'),
            array('skrill_account_number', 'email', 'on' => 'skrill'),
            // bank account
            array('from_account_number, from_account_holder, bic', 'required', 'on' => 'bank_account'),
            array('bic', 'validateBic', 'on' => 'bank_account'),
        );
    }

    public function validateBic($attr, $par)
    {
        $bank = Banks_Info::model()->findByAttributes(
            array(
                'bic_code' => $this->$attr
            )
        );
        if (!$bank) {
            $this->addError($attr, Yii::t('Front', 'Bic is incorrect'));
        } else {
            $this->bank_id = $bank->id;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'bank' => array(self::BELONGS_TO, 'Bank_Info', 'bank_id'),
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
            'status' => 'Status',
            'from_account_number' => 'Account number',
            'from_account_holder' => 'Account holder',
            'creditcard_holder' => 'Creditcard holder',
            'creditcard_number' => 'Creditcard number',
            'electronic_method' => 'Electronic method',
            'card_type' => 'Card type',
            'p_month' => 'Month',
            'p_year' => 'Year',
            'p_csc' => 'CSC',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('from_account_number', $this->from_account_number, true);
        $criteria->compare('from_account_holder', $this->from_account_holder, true);
        $criteria->compare('electronic_method', $this->electronic_method);
        $criteria->compare('card_type', $this->card_type);
        $criteria->compare('p_month', $this->p_month);
        $criteria->compare('p_year', $this->p_year);
        $criteria->compare('p_csc', $this->p_csc);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeValidate()
    {
        if (!$this->category_id) {
            $this->category_id = null;
        }
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->scenario != 'delete')
            switch (self::$methods[$this->electronic_method]) {
                case 'creditcard':
                    $this->from_account_number = $this->creditcard_number;
                    $this->from_account_holder = $this->creditcard_holder;
                    break;
                case 'ideal':
                    $this->from_account_number = $this->ideal_account_number;
                    break;
                case 'paypal':
                    $this->from_account_number = $this->paypal_account_number;
                    break;
                case 'webmoney':
                    $this->from_account_number = $this->webmoney_account_number;
                    break;
                case 'skrill':
                    $this->from_account_number = $this->skrill_account_number;
                    break;
            }

        if ($this->isNewRecord) {
            $this->status = PaymentService::APPROVED_STATUS;
            $this->user_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

    /**
     * getHtmlStatus
     * TODO: all $this->htmlStatus to PaymentService::getHtmlStatus($this->status);
     * @return string
     */
    public function getHtmlStatus()
    {
        return PaymentService::getHtmlStatus($this->status);
    }


    public function scopes()
    {
        $alias = $this->getTableAlias(false, false);
        return Array(
            'active' => Array(
                'condition' => "$alias.deleted=0",
            ),
        );
    }
}