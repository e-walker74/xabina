<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


class Form_Incoming_Electronic extends Form_Incoming{

	public $from_account_number;
	public $from_account_holder;
	
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
                array('electronic_method', 'required'),
                array('card_type, p_month, p_year, p_csc, creditcard_number, creditcard_holder', 'required', 'on' => 'creditcard'),
				array('ideal_account_number', 'required', 'on' => 'ideal'),
				array('p_month', 'numerical', 'min' => 1, 'max' => 12),
				array('p_month', 'length', 'max' => 2),
				array('p_year', 'numerical', 'min' => date('Y'), 'max' => date('Y', time()+3600*24*365*20)),
				array('p_year', 'length', 'is' => 4, 'max' => 4),
				array('p_csc', 'numerical'),
				array('p_csc', 'length', 'max' => 3, 'min' => 3),
				array('ideal_account_number', 'numerical'),
				array('creditcard_number', 'match', 'pattern'=>'/^((34)|(35)|(37)|(4)|(62[0-5]0)|(5[0-6])|(62)|(88))[\d+]/', 'message' => Yii::t('Front', 'card id not valid')),
				array('creditcard_number', 'checkCard'),
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