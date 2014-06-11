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

    public function save($transfer = false){
        if(!$this->validate()){
            return false;
        }

        if(!$transfer){
            $transfer = new Transfers_Outgoing();
        }
        $transfer->attributes = $this->attributes;
        $to_account = Accounts::model()->find('number = :num', array(':num' => $transfer->to_account_number));
        $transfer->to_account_holder = $to_account->user->fullName;
		if($transfer->save()){
			$this->afterTransferSave($transfer);
			return true;
		}
		return false;
    }

    public static function model($className=__CLASS__)
    {
        return new $className;
    }
} 