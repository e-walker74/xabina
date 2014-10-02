<?php

/**
 * Created by PhpStorm.
 * User: Trueman
 * Date: 09.05.14
 * Time: 16:08
 */
abstract class Transfers_Model extends CModel
{

    public $account_id;
    public $user_id; //user, who initiated the transfer
    public $operation;
    public $type;
    public $sum;
    public $acc_balance;
    public $info_date; //Transaction_Info.date = created_at TIME FIELD
    public $info_type; //default OV - i don`t not what is it
    public $info_sender_name; //sender
    public $info_sender_account_number;
    public $info_sender_bic;
    public $info_detail_of_payment;

    abstract public function createOutgoingTransaction(Transfers_Outgoing $transfer);

    abstract public function createInComingTransaction(Transfers_Incoming $model);

    public function attributeNames()
    {
        return array();
    }

    /**
     * @param $transfer Transfers_Outgoing|Transfers_Incoming
     */
    protected function findContact($type, $number, $holder = false)
    {
        $type = $type . '_acc';
        $contact = Users_Contacts_Data::model()->with('contact')->findAll(
            array(
                'condition' => 'contact.user_id = :uid AND field1 = :type AND field2 = :number',
                'params' => array(
                    ':uid' => Yii::user()->getCurrentId(),
                    ':type' => $type,
                    ':number' => $number,
                ),
            )
        );

        if(!$contact){
            $contact = new Users_Contacts();
            $contact->scenario = 'system';
            $contact->user_id = Yii::user()->getCurrentId();
            $contact->hint = $holder;
            $contact->save();
            $contact_account = new Users_Contacts_Data_Account();
            $contact_account->account_type = $type;
            $contact_account->account_holder = $holder;
            $contact_account->account_number = $number;

            $dbModel = new Users_Contacts_Data();
            $dbModel->contact_id = $contact->id;
            $dbModel->data_type = 'account';
            $dbModel->field1 = $type;
            $dbModel->field2 = $number;
            $contact_account->setDbModel($dbModel);
            $contact_account->save();
        }

        return $contact;
    }

    /**
     * @param string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        if ($className != __CLASS__) {
            $className = __CLASS__ . '_' . $className;
        }
        return new $className;
    }

}