<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


abstract class Form_Outgoingtransf extends CFormModel{

    /* master params */
    public $amount;
    public $amount_cent = '00';
    public $currency_id;
    public $account_number;
    public $description;
    public $account_id;
    public $favorite = false;
    /* charges */
    public $charges;
    public $urgent;
    /* frequency type */
    public $frequency_type = 1;
    public $execution_date;
    public $remaining_balance;
    public $remaining_balance_cent;
    public $start_date;
    public $end_date;
    public $each_period;
    public $period;

    /* category */
    public $counter_agent;
    public $tag1;
    public $tag2;
    public $tag3;
    public $category_id;

    /* system */
    public $need_confirm = 1;
    public $is_iban = false;
    public $external_bank_id;

    public static $chargesList = array(
        '1' => 'Shared (mandatory for EC payments)',
        '2' => 'Receiver pays the fees',
        '3' => 'Sender pays the fees',
    );

    public static $periods = array(
        'day'   => 'Day(s)',
        'week'  => 'Week(s)',
        'month' => 'Month(s)',
        'year'  => 'Year(s)'
    );

    /**
     * save outgoing transfer
     * @return mixed
     */
    abstract public function save();

    /**
     * required params for all outgoing transfers
     * @return array
     */
    public function rules()
    {
        return array(
            array('amount, account_number, currency_id, charges', 'required'),
            array('amount, amount_cent, account_number, currency_id, charges, remaining_balance, remaining_balance_cent, category_id', 'numerical'),
            array('amount_cent', 'length', 'max' => 2),
            array('account_number', 'checkXabinaNumber'),
            array('counter_agent', 'checkXabinaUserID'),
            array('urgent, favorite', 'boolean'),
            array('period', 'in', 'range' => array('day', 'week', 'month', 'year')),
            array('frequency_type', 'in', 'range' => array(1, 2)),
            array('end_date', 'validateCompareDates', 'compareAttribute' => 'start_date', 'message' => Yii::t('Front', 'Must be greater than Start Date')),
            array('execution_date, start_date, end_date', 'validateToday', 'integerOnly' => false, 'min' => strtotime(date('m/d/Y'), time()), 'message' => Yii::t('Front', 'Date is not correct')),
            array('description, tag1, tag2, tag3', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
        );
    }

    public function checkXabinaUserID($attribute, $params){
        if($this->{$attribute}){
            if(!Users::model()->find('login = :n', array(':n' => $this->{$attribute}))) {
                $this->addError($attribute, Yii::t('Front', 'User ID is incorrect'));
            }
        }
    }

    public function checkXabinaNumber($attribute, $params){
        if($this->{$attribute}){
            if(!AccountService::checkNumber($this->{$attribute})){
                $this->addError($attribute, Yii::t('Front', 'Account number is incorrect'));
            } elseif(!Accounts::model()->find('number = :n', array(':n' => $this->{$attribute}))) {
                $this->addError($attribute, Yii::t('Front', 'Account number is incorrect'));
            }
        }
    }

    public function validateCompareDates($attribute, $params){
        if($this->{$attribute} && $this->{$attribute} < $this->{$params['compareAttribute']}){
            $this->addError($attribute, Yii::t('Front', $params['message']));
        }
    }

    public function validateToday($attribute, $params){
        if($this->{$attribute} && $this->{$attribute} < strtotime(date('m/d/Y'), time())){
            $this->addError($attribute, Yii::t('Front', $params['message']));
        }
    }

    public function beforeValidate() {
        if(parent::beforeValidate()) {
            if($this->account_number){
                if($acc = Accounts::model()->find('number = :n', array(':n' => $this->account_number))){
                    $this->account_id = $acc->id;
                }
            }
            if($this->execution_date){
                $this->execution_date = strtotime($this->execution_date);
            }
            if($this->start_date){
                $this->start_date = strtotime($this->start_date);
            }
            if($this->end_date){
                $this->end_date = strtotime($this->end_date);
            }
            if($this->amount_cent){
                $this->amount .= '.' . $this->amount_cent;
            }
            if($this->remaining_balance_cent){
                $this->remaining_balance .= '.' . $this->remaining_balance_cent;
            }
            return true;
        }
    }
}