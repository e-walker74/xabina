<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */

abstract class Form_Incoming extends CFormModel
{
    /* master params */
    public $amount;
    public $amount_cent = '00';
    public $currency_id;
    public $description;
    public $to_account_id;
    public $to_account_number;
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
    public $need_confirm = 0;
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
	
	public function afterTransferSave($transfer)
    {
		if ($transfer->favorite) {
			$favorite = new Transfers_Incoming_Favorite();
			$favorite->attributes = $transfer->attributes;
			$favorite->save();
		}
	
		if (isset($_POST['file_ids'])) {
			foreach ($_POST['file_ids'] as $fId) {
				$file = Users_Files::model()->findByPk($fId);
				if ($file->user_id != Yii::app()->user->id) {
					return false;
				}
				if (strpos($file->form, 'Form_Incoming') !== 0) {
					return false;
				}
				$file->form = get_class($transfer);
				$file->model_id = $transfer->id;
				$file->save();
			}
		}
	}

    /**
     * required params for all outgoing transfers
     * @return array
     */
    public function rules()
    {
        return array(
            array('amount, to_account_number, to_account_id, currency_id, charges', 'required'),
            array('amount, amount_cent, to_account_number, currency_id, charges, category_id', 'numerical'),
			array('amount', 'length', 'max' => 12, 'tooLong' => Yii::t('Front', 'Max lenght is 9')),
            array('amount_cent', 'length', 'max' => 2),
            array('urgent, favorite', 'boolean'),
            array('to_account_number', 'ext.validators.XabinaNumberValidator'),
            array('favorite', 'boolean'),
            array('counter_agent', 'ext.validators.ContactValidator'),
            array('description, tag1, tag2, tag3', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
        );
    }

    public function checkXabinaUserID($attribute, $params)
    {
        if ($this->{$attribute}) {
            if (!Users::model()->find('login = :n', array(':n' => $this->{$attribute}))) {
                $this->addError($attribute, Yii::t('Front', 'User ID is incorrect'));
            }
        }
    }

    public function checkXabinaNumber($attribute, $params)
    {
        if ($this->{$attribute}) {
            if (!AccountService::checkNumber($this->{$attribute})) {
                $this->addError($attribute, Yii::t('Front', 'Account number is incorrect'));
            } elseif (!Accounts::model()->find('number = :n', array(':n' => $this->{$attribute}))) {
                $this->addError($attribute, Yii::t('Front', 'Account number is incorrect'));
            }
        }
    }

	public function beforeValidate(){
		if($this->to_account_number){
			if($acc = Accounts::model()->find('number = :n', array(':n' => $this->to_account_number))){
				$this->to_account_id = $acc->id;
			}
		}
		if ($this->execution_date) {
			$this->execution_date = strtotime($this->execution_date);
		}
		if ($this->start_date) {
			$this->start_date = strtotime($this->start_date);
		}
		if ($this->end_date) {
			$this->end_date = strtotime($this->end_date);
		}
		if ($this->amount_cent) {
			$this->amount .= '.' . $this->amount_cent;
		}
		if ($this->remaining_balance_cent) {
			$this->remaining_balance .= '.' . $this->remaining_balance_cent;
		}
		return parent::beforeValidate();
	}
}