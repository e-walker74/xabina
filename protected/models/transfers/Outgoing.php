<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 *
 * @properties boolean $need_confirm
 *
 * @properties Transactions[] $transactions
 */
class Transfers_Outgoing extends ActiveRecord
{

    public static $charges = array('1' => 'Shared (mandatory for EC payments)', 2 => 'Receiver pays the fees', 3 => 'Sender pays the fees');

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'transfers_outgoing';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('amount, account_id, account_number, currency_id, charges, form_type', 'required'),
            array('amount, account_id, account_number, currency_id, charges, remaining_balance, counter_agent, each_period, category_id, external_bank_id', 'numerical'),
            array('urgent, favorite, is_iban', 'boolean'),
            array('amount', 'length', 'max' => 12, 'tooLong' => Yii::t('Front', 'Max lenght is 9')),
            array('tag1, tag2, tag3, to_account_number', 'length', 'max' => 255),
            array('period', 'in', 'range' => array('day', 'week', 'month', 'year')),
            array('frequency_type', 'in', 'range' => array(1, 2)),
            array('status', 'safe', 'on' => 'admin'),
//			array('description', 'length', 'max' => 140),
            array('description, to_account_holder, bic, bank_name, to_account_number', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            array('execution_date, start_date, end_date', 'safe'),
            array('ewallet_type', 'in', 'range' => array_keys(Form_Outgoingtransf_Ewallet::$ewallet_types)),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
            'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'notes' => array(self::HAS_MANY, 'Transactions_Notes', 'transaction_id', 'condition' => 'deleted = 0'),
            'category' => array(self::BELONGS_TO, 'Transactions_Categories', 'category_id'),
            'external_bank' => array(self::BELONGS_TO, 'Banks_Info', 'external_bank_id'),
            'transactions' => array(self::HAS_MANY, 'Transactions', 'outgoing_id'),
            //'xabina_account' => array(self::BELONGS_TO, 'Accounts', 'account_number'),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_PENDING;
            $this->user_id = Yii::app()->user->id;
            if ($this->frequency_type == 1 && !$this->execution_date) {
                $this->execution_date = time();
            }
        }
        return parent::beforeSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('t.status', 0);
        $criteria->compare('t.need_confirm', 0);
        $criteria->compare('amount', $this->amount);
        $criteria->with = 'user';
        $criteria->together = true;
        $criteria->order = 't.created_at desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function log()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('t.status', 0);
        $criteria->compare('amount', $this->amount);
        $criteria->with = 'user';
        $criteria->together = true;
        $criteria->order = 't.created_at desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransfersOutgoing the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getHtmlOperationDescription()
    {
        switch ($this->form_type) {
            case 'xabina':
                return chunk_split($this->account_number, 4) . '<br>' .
                $this->description;
                break;
            case 'own':
                return
//                    '<strong class="holder">' . $this->to_account_holder . '</strong><br/>' .
                    chunk_split($this->account_number, 4) . '<br>' .
                    $this->description;
                break;
            case 'external':
                return '<strong class="holder">' . $this->bank_name . '</strong><br/>' .
                chunk_split($this->bic, 4) . '<br>' .
                $this->description;
                break;
        }
    }

    public function getPublicAttrs($full = false)
    {
        switch ($this->form_type) {
            case 'own':
                return array(
                    Yii::t('Front', 'date') => date('d.m.Y', $this->created_at),
                    Yii::t('Front', 'type') => 'OV', //TODO what is the type?
                    Yii::t('Front', 'Value') => $this->amount . ' ' . $this->currency->code,
                    Yii::t('Front', 'sender_name') => $this->user->fullname,
                    Yii::t('Front', 'sender_account_number') => $this->account->number,
                    Yii::t('Front', 'recipient_name') => $this->user->fullname,
                    Yii::t('Front', 'recipient_account_number') => $this->to_account_number,
                    Yii::t('Front', 'details_of_payments') => $this->description,
                    Yii::t('Front', 'Urgent') => ($this->urgent) ? Yii::t('Front', 'Yes') : Yii::t('Front', 'No'),
                    Yii::t('Front', 'Tag 1') => $this->tag1,
                    Yii::t('Front', 'Tag 2') => $this->tag2,
                    Yii::t('Front', 'Tag 3') => $this->tag3,
                    Yii::t('Front', 'Frequency') => ($this->frequency_type == 1) ? Yii::t('Front', 'One-time') : Yii::t('Front', 'Standing'),
                );
                break;
            case 'another':
                $return = array(
                    Yii::t('Front', 'date') => date('d.m.Y', $this->created_at),
                    Yii::t('Front', 'type') => 'OV', //TODO what is the type?
                    Yii::t('Front', 'Value') => $this->amount . ' ' . $this->currency->code,
                    Yii::t('Front', 'sender_name') => $this->user->fullname,
                    Yii::t('Front', 'sender_account_number') => $this->account->number,
                    Yii::t('Front', 'recipient_name') => $this->to_account_holder,
                    Yii::t('Front', 'recipient_account_number') => $this->to_account_number,
                    Yii::t('Front', 'details_of_payments') => $this->description,
                    Yii::t('Front', 'Urgent') => ($this->urgent) ? Yii::t('Front', 'Yes') : Yii::t('Front', 'No'),
                    Yii::t('Front', 'Tag 1') => $this->tag1,
                    Yii::t('Front', 'Tag 2') => $this->tag2,
                    Yii::t('Front', 'Tag 3') => $this->tag3,
                    Yii::t('Front', 'Frequency') => ($this->frequency_type == 1) ? Yii::t('Front', 'One-time') : Yii::t('Front', 'Standing'),
                );
                return $return;
                break;
            case 'external':
                return array(
                    Yii::t('Front', 'date') => date('d.m.Y', $this->created_at),
                    Yii::t('Front', 'type') => 'OV', //TODO what is the type?
                    Yii::t('Front', 'Value') => $this->amount . ' ' . $this->currency->code,
                    Yii::t('Front', 'sender_name') => $this->user->fullname,
                    Yii::t('Front', 'sender_account_number') => $this->account->number,
                    Yii::t('Front', 'recipient_name') => $this->to_account_holder,
                    Yii::t('Front', 'recipient_account_number') => $this->to_account_number,
                    Yii::t('Front', 'bic') => $this->bic,
                    Yii::t('Front', 'bank_name') => $this->external_bank->institution_name,
                    Yii::t('Front', 'details_of_payments') => $this->description,
                    Yii::t('Front', 'Urgent') => ($this->urgent) ? Yii::t('Front', 'Yes') : Yii::t('Front', 'No'),
                    Yii::t('Front', 'Tag 1') => $this->tag1,
                    Yii::t('Front', 'Tag 2') => $this->tag2,
                    Yii::t('Front', 'Tag 3') => $this->tag3,
                    Yii::t('Front', 'Frequency') => ($this->frequency_type == 1) ? Yii::t('Front', 'One-time') : Yii::t('Front', 'Standing'),
                );
                break;
            case 'ewallet':
                return array(
                    Yii::t('Front', 'date') => date('d.m.Y', $this->created_at),
                    Yii::t('Front', 'type') => 'OV', //TODO what is the type?
                    Yii::t('Front', 'Value') => $this->amount . ' ' . $this->currency->code,
                    Yii::t('Front', 'sender_name') => $this->user->fullname,
                    Yii::t('Front', 'sender_account_number') => $this->account->number,
                    Yii::t('Front', 'recipient_name') => $this->to_account_holder,
                    Yii::t('Front', 'ewallet_type') => Form_Outgoingtransf_Ewallet::$ewallet_types[$this->ewallet_type],
                    Yii::t('Front', 'ewallet') => $this->to_account_number,
                    Yii::t('Front', 'details_of_payments') => $this->description,
                    Yii::t('Front', 'Urgent') => ($this->urgent) ? Yii::t('Front', 'Yes') : Yii::t('Front', 'No'),
                    Yii::t('Front', 'Tag 1') => $this->tag1,
                    Yii::t('Front', 'Tag 2') => $this->tag2,
                    Yii::t('Front', 'Tag 3') => $this->tag3,
                    Yii::t('Front', 'Frequency') => ($this->frequency_type == 1) ? Yii::t('Front', 'One-time') : Yii::t('Front', 'Standing'),
                );
                break;
        }
        return array();
    }

    public function getToAccountHolder()
    {
        switch ($this->form_type) {
            case 'own':
                return $this->user->fullname;
                break;
            case 'another':
                $acc = Accounts::model()->with('user')->find('number = :num', array(':num' => $this->to_account_number));
                return $acc->user->fullname;
                break;
            case 'external':
                return $this->to_account_holder;
                break;
            case 'ewallet':
                return (is_numeric($this->to_account_number)) ? number_format($this->to_account_number, 0, '.', ' ') : $this->to_account_number;
                break;
        }
    }

    public function getHtmlStatus()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return '<span class="pending">Pending</span>';
                break;
            case self::STATUS_APPROVED:
                return '<span class="approved">Approved</span>';
                break;
            case self::STATUS_REJECTED:
                return '<span class="rejected">Rejected</span>';
                break;
        }
    }

    public function notifyRules()
    {
        return array(
            'validateBalance',
        );
    }

    public function validateBalance()
    {
        $acc = Accounts::model()->find('number = :account_number AND user_id = :uid',
            array(
                ':account_number' => $this->account_number,
                ':uid' => Yii::app()->user->id,
            )
        );
        if (!$acc) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        if ($acc->getBalanceInEUR() < Currencies::convert($this->amount, Currencies::model()->findByPk($this->currency_id)->code, 'EUR')) {
            return array('amount_notify' => Yii::t('Front', 'Insufficient funds'));
        } else {
            return array();
        }
    }
}
