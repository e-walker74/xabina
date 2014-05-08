<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


class Form_Outgoingtransf_External extends Form_Outgoingtransf{

    public $form_type = 'external';

    public $to_account_number;
    public $to_account_holder;
    public $bic;
    public $bank_name;

    public function rules(){
        return array_merge(
            parent::rules(),
            array(
                array('account_number, to_account_holder, to_account_number', 'required'),
                array('bic', 'validateBankCode'),
                array('to_account_holder, to_account_number', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            )
        );
    }

    public function validateBankCode(){
        return true;
    }

    public function save(){
        if(!$this->validate()){
            return false;
        }
        $transfer = new Transfers_Outgoing();
        $transfer->attributes = $this->attributes;
        return $transfer->save();
    }

}