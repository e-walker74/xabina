<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


class Form_Incoming_Quick extends Form_Incoming{

	public $from_account_number;
	public $from_account_holder;
	
	public $tid; //trasfer ID
	
	// creditcard params
	public $creditcard_number;
	public $creditcard_holder;
	public $p_month;
	public $p_year;
	public $p_csc;
	public $card_type;

	// ideal params
	public $ideal_account_number;
	
	public static $methods = array(
		1 => 'creditcard',
		2 => 'ideal',
	);

    public $form_type = 'electronic';
	public $electronic_method = '';

    public function rules(){
        return array_merge(
            parent::rules(),
            array(
                array('electronic_method, tid', 'required'),
				array('tid, amount, amount_cent, currency_id', 'numerical'),
				array('tid, amount, amount_cent, currency_id', 'safe'),
            )
        );
    }

	public function checkCard($attribute, $params){
		if($this->{$attribute}){
			if(!AccountService::checkNumber($this->{$attribute}, strlen($this->{$attribute}))){
				$this->addError($attribute, Yii::t('Front', 'Card id not valid'));
			}
		}
	}

	public function beforeValidate(){
		if($this->electronic_method){
			$this->scenario = Form_Incoming_Electronic::$methods[$this->electronic_method];
		}
		return parent::beforeValidate();
	}

    public function save(){
        if(!$this->validate()){
            return false;
        }

		$transfer = new Transfers_Incoming();
        $transfer->attributes = $this->attributes;
		switch(Form_Incoming_Electronic::$methods[$this->electronic_method]){
			case 'creditcard':
				$transfer->from_account_number = $this->creditcard_number;
				$transfer->from_account_holder = $this->creditcard_holder;
				break;
			case 'ideal':
				$transfer->from_account_number = $this->ideal_account_number;
				break;
		}
		if($transfer->save()){
			$this->afterTransferSave($transfer);
			return true;
		}
		return false;
    }
}