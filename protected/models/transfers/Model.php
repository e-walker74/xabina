<?php
/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:08
 */

abstract class Transfers_Model extends CModel {

    public $account_id;
    public $user_id;         //user, who initiated the transfer
    public $operation;
    public $type;
    public $sum;
    public $acc_balance;
    public $info_date;           //Transaction_Info.date = created_at TIME FIELD
    public $info_type;           //default OV - i don`t not what is it
    public $info_sender_name;    //sender
    public $info_sender_account_number;
    public $info_sender_bic;
    public $info_detail_of_payment;

    abstract public function createOutgoingTransaction(Transfers_Outgoing $transfer);

    abstract public function createInComingTransaction(Transfers_Incoming $model);

    public function attributeNames(){
        return array();
    }

    /**
     * @param string $className
     * @return $this
     */
    public static function model($className=__CLASS__)
    {
        if($className != __CLASS__){
            $className = __CLASS__ . '_' . $className;
        }
        return new $className;
    }

}