<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


class Form_Outgoingtransf_Own extends Form_Outgoingtransf{

    public $form_type = 'own';

    public $to_account_number;

    public function rules(){
        return array_merge(
            parent::rules(),
            array(
                array('account_number', 'required'),
                array('to_account_number', 'required'),
                array('to_account_number', 'compare', 'compareAttribute' => 'account_number', 'operator' => '!='),
                array('to_account_number', 'checkXabinaNumber'),
            )
        );
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