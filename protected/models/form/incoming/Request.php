<?php
/**
 * Created by Eugene Kazak.
 * User: Trueman
 * Date: 05.05.14
 * Time: 19:48
 */


class Form_Incoming_Request extends Form_Incoming{

    public $form_type = 'request';
    public $transmitter;

    public function rules(){
        return array_merge(
            parent::rules(),
            array(
                array('transmitter', 'required'),
                array('transmitter', 'checkXabinaUserID'),
            )
        );
    }

    public function save(){
        if(!$this->validate()){
            return false;
        }
        $transfer = new Transfers_Incoming();
        $transfer->attributes = $this->attributes;
		$transfer->from_account_number = $this->transmitter;
        return $transfer->save();
    }

}