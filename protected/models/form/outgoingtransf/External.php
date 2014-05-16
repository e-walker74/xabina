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

    public function validateBankCode($attribute, $params){
        $model = Banks_Info::model()->find(
            array(
                'condition' => 'bic_code = :bic',
                'params' => array(':bic' => $this->{$attribute}),
                'select' => 'id, institution_name',
            )
        );
        if(!$model){
            $this->addError($attribute, Yii::t('Front', 'Bank name is incorrect'));
        } else {
            $this->external_bank_id = $model->id;
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