<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Account $contact
 */
class Users_Contacts_Data_Account extends Users_Contacts_Data_Model
{

    /*
    * data attributes
    */
    public static $contacts_account_types = array(
        1 => 'bank_account',
        2 => 'paypal_acc',
        3 => 'scrill_acc',
        4 => 'webmoney_acc',
    );
    public $account_type;
    public $account_number;
    public $account_holder;
    public $bic;
    public $bank_id;
    public $p_year;
    public $p_month;
    public $p_csc;
    public $bank_name;
    public $paypal_acc;
    public $scrill_acc;
    public $webmoney_acc;
    public $category;
    public $details;
    public $currency_id;
    public $outgoing_category;
    public $incoming_category;
    public $automatic_linking;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UsersContactsData the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getAccountTypesWithTranslate()
    {
        $return = array();
        foreach (self::$contacts_account_types as $key => $val) {
            $return[$key] = Yii::t('Front', $val);
        }
        return $return;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array_merge(
            parent::rules(),
            array(
                array('account_type', 'required'),
                array('account_holder, account_number', 'required', 'on' => 'bank_account'),
                array('paypal_acc', 'required', 'on' => 'paypal_acc'),
                array('paypal_acc, scrill_acc', 'email'),
                array('bic', 'validateBankCode'),
                array('scrill_acc', 'required', 'on' => 'scrill_acc'),
                array('webmoney_acc', 'required', 'on' => 'webmoney_acc'),
                array('webmoney_acc, scrill_acc, bic, paypal_acc, account_holder, account_number, details, category', 'length', 'max' => 140),
                array('automatic_linking', 'boolean'),
                array('account_type', 'in', 'range' => array_keys(self::$contacts_account_types)), //TODO another account types
                /*array('p_month', 'numerical', 'min' => 1, 'max' => 12),
                array('p_month', 'length', 'max' => 2),
                array('p_year', 'numerical', 'min' => date('Y'), 'max' => date('Y', time()+3600*24*365*20)),
                array('p_year', 'length', 'is' => 4, 'max' => 4),
                array('p_csc', 'numerical'),
                array('p_csc', 'length', 'max' => 3, 'min' => 3),*/
                //array('account_number, account_holder, bic', 'length', 'max' => 255),
                array('
				account_type,
				account_number,
				account_holder,
				bic,
				bank_id,
				p_year,
				p_month,
				p_csc,
				webmoney_acc,
				currency_id,
				outgoing_category,
				incoming_category,
				automatic_linking,
				', 'safe'),
            ));
    }

    public function validateBankCode($attribute, $params)
    {
        if (!$this->{$attribute}) {
            return true;
        }
        $model = Banks_Info::model()->find(
            array(
                'condition' => 'bic_code = :bic',
                'params' => array(':bic' => $this->{$attribute}),
                'select' => 'id, institution_name',
            )
        );
        if (!$model) {
            $this->addError($attribute, Yii::t('Front', 'Bank name is incorrect'));
        }
    }

    public function beforeValidate()
    {
        if ($this->account_type) {
            $this->scenario = self::$contacts_account_types[$this->account_type];

            switch (self::$contacts_account_types[$this->account_type]) {
                case 'bank_account':
                    break;
                case 'paypal_acc':
                    $this->account_holder = $this->paypal_acc;
                    $this->account_number = $this->paypal_acc;
                    break;
                case 'scrill_acc':
                    $this->account_holder = $this->scrill_acc;
                    $this->account_number = $this->scrill_acc;
                    break;
                case 'webmoney_acc':
                    $this->account_holder = $this->webmoney_acc;
                    $this->account_number = $this->webmoney_acc;
                    break;
            }
        }
        return parent::beforeValidate();
    }

    public function attributeNames()
    {
        return array(
            'account_type',
            'account_number',
            'account_holder',
            'bic',
            'bank_id',
            'p_year',
            'p_month',
            'p_csc',
            'paypal_acc',
            'scrill_acc',
            'webmoney_acc',
            'category',
            'details',
            'currency_id',
            'incoming_category',
            'outgoing_category',
            'automatic_linking',
        );
    }

    public function getPaementSystemModel()
    {
        return PaymentSystems::model()->findByPk($this->account_type);
    }

    public function getDataTitle()
    {
        return Yii::t('Front', 'Account Number');
    }
}
