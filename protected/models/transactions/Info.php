<?php

/**
 * This is the model class for table "transactions_info".
 *
 * The followings are the available columns in table 'transactions_info':
 * @property integer $date
 * @property string  $type
 * @property string  $sender
 * @property integer $sum
 * @property integer $curency_id
 * @property string  $bic
 * @property string  $data_bank
 * @property string  $costs
 * @property string  $status_comment
 */
class Transactions_Info extends CActiveRecord
{

    public $keyword;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'transactions_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sender', 'required'),
            array('type, sender, bic, data_bank, costs, status_comment', 'length', 'max' => 255),
            array('type', 'length', 'max' => 2),
            array('details_of_payment', 'safe', 'on' => 'admin'),
            array('status_comment', 'validateRejected', 'on' => 'admin'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date, type, sender, value, bic, data_bank, costs', 'safe', 'on' => 'search'),
        );
    }

    public function validateRejected($attribute, $params)
    {
        if(isset($_POST['Transactions']['status'])
            && $_POST['Transactions']['status'] == Transactions::STATUS_REJECTED
            && !$this->status_comment){
            $this->addError('status_comment', Yii::t('Admin', 'Comment is incorrect'));
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transaction' => array(self::HAS_ONE, 'Transactions', 'info_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'date' => 'Date',
            'type' => 'Type',
            'sender' => 'Sender',
            'sum' => 'Sum',
            'curency_id' => 'Curency',
            'bic' => 'Bic',
            'data_bank' => 'Data Bank',
            'costs' => 'Costs',
        );
    }

    public function getPublicAttrs()
    {
        $attrs = array();
        foreach ($this->attributes as $key => $value) {
            if ($key != 'id' && $key != 'charges' && $value) {
                $attrs[$this->getAttributeLabel($key)] = $value;
            }
            if ($key == 'charges' && $value) {
                $attrs[$this->getAttributeLabel($key)] = Transfers_Outgoing::$charges[$value];
            }
        }
        return $attrs;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionsInfo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
