<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


class Form_Outgoingtransf_Ewallet extends Form_Outgoingtransf{

    public $form_type = 'ewallet';

    public static $ewallet_types = array(
        '1' => 'paypal',
        '2' => 'webmoney',
        '3' => 'scrill',
    );

    public $ewallet_type;
    public $to_account_number;

    public $paypall_email;
    public $webmoney_acc;
    public $scrill_acc;

    public function rules(){
        return array_merge(
            parent::rules(),
            array(
                array('account_number, ewallet_type', 'required'),
                array('ewallet_type', 'in', 'range' => array_keys(self::$ewallet_types)),

                array('paypall_email', 'email', 'on' => 'paypall'),
                array('paypall_email', 'required', 'on' => 'paypall'),
                array('webmoney_acc', 'required', 'on' => 'webmoney'),
                array('scrill_acc', 'email', 'on' => 'scrill'),

                array('to_account_number', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            )
        );
    }

    public function beforeValidate() {
        if(parent::beforeValidate()) {
            if($this->ewallet_type){
                switch($this->ewallet_type){
                    case 1:
                        $this->scenario = 'paypall';
                        $this->to_account_number = $this->paypall_email;
                        break;
                    case 2:
                        $this->scenario = 'webmoney';
                        $this->to_account_number = $this->webmoney_acc;
                        break;
                    case 3:
                        $this->scenario = 'scrill';
                        $this->to_account_number = $this->scrill_acc;
                        break;
                }
            }
            return true;
        }
    }

    public function save($transfer = false){
        if(!$this->validate()){
            return false;
        }
        if(!$transfer){
            $transfer = new Transfers_Outgoing();
        }
        $transfer->attributes = $this->attributes;
        if($transfer->save()){
			$this->afterTransferSave($transfer);
			return true;
		}
		return false;
    }

}