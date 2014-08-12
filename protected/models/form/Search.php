<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Search extends CFormModel
{
    private $_transactions = false;

    public $user_id;
    public $counter_agent;

	public $sender;
	public $account_number;
    public $keyword;
	public $from_date;
	public $to_date;
	public $from_sum;
	public $to_sum;
	public $type;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('sender, keyword, type', 'length', 'max' => 255, 'message' => Yii::t('Front', 'is to long')),
			array('account_number, from_sum, to_sum', 'numerical', 'message' => Yii::t('Front', 'field is not numeric')),
			array('type, sender, keyword, account_number, from_date, to_date, from_sum, to_sum', 'safe'),
			// password needs to be authenticated
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'sender' => Yii::t('Front', 'Sender'),
		);
	}

	public function searchUserTransactions(){
		$criteria=new CDbCriteria;
		
		$criteria->params = array(':uid' => Yii::app()->user->getCurrentId());
		$criteria->condition = 'account.user_id = :uid
		';

		if($this->keyword){
			$criteria->condition .= '
				AND 
				(
					info.sender LIKE :keyword OR
					info.recipient LIKE :keyword OR
					info.data_bank LIKE :keyword  OR
					info.bic LIKE :keyword  OR
					info.details_of_payment LIKE :keyword
				)
			';
            $criteria->params[':keyword'] = '%'.$this->keyword.'%';
		}
		if($this->type == 'incoming'){
			$criteria->condition .= 'AND t.type = "positive"
			';
		} elseif($this->type == 'outgoing'){
			$criteria->condition .= 'AND t.type = "negative"
			';
		}

        if($this->account_number){
            $criteria->condition .= 'AND account.number = :account_number';
            $criteria->params[':account_number'] = $this->account_number;
        }

		if($this->from_date){
			$criteria->compare('t.created_at', '>='.strtotime($this->from_date));
		} 
		if($this->to_date){
			$criteria->compare('t.created_at', '<='.strtotime($this->to_date));
		}
		if($this->from_sum){
			$criteria->compare('t.sum', '>='.$this->from_sum);
		} 
		if($this->to_sum){
			$criteria->compare('t.sum', '<='.$this->to_sum);
		}
		
		$criteria->with = array('account', 'info');
		$criteria->together = true;
		$criteria->order = 't.created_at desc';

		//d($criteria);
		
		return Transactions::model()->findAll($criteria);
	}

    public function contactLinkedTransactions(){
        if ($this->_transactions !== false) {
            return $this->_transactions;
        }

        $where = " t.user_id = {$this->user_id}  and (tinc.counter_agent = {$this->counter_agent} or tout.counter_agent = {$this->counter_agent})
        ";
        if($this->keyword){
            $where .= "
				AND
				(
					ti.sender LIKE '%{$this->keyword}%' OR
					ti.recipient LIKE '%{$this->keyword}%' OR
					ti.data_bank LIKE '%{$this->keyword}%'  OR
					ti.bic LIKE '%{$this->keyword}%'  OR
					ti.details_of_payment LIKE '%{$this->keyword}%'
				)
			";
        }
        if($this->type == 'incoming'){
            $where .= 'AND t.type = "positive"
			';
        } elseif($this->type == 'outgoing'){
            $where .= 'AND t.type = "negative"
			';
        }

        if($this->from_date){
            $time = strtotime($this->from_date);
            $where .= "AND t.created_at >= {$time}
            ";
        }
        if($this->to_date){
            $time = strtotime($this->to_date);
            $where .= "AND t.created_at <= {$time}
            ";
        }
        if($this->from_sum){
            $where .= "AND t.amount >= {$this->from_sum}
            ";
        }
        if($this->to_sum){
            $where .= "AND t.amount <= {$this->to_sum}
            ";
        }



        $sql = "
			SELECT
				t.id,
				t.amount,
				t.type,
				t.acc_balance,
				t.created_at,
				t.transfer_type,
				t.url,
				t.transfer_id,
				acc.number user_account_number,
				cur.code currency,
				tout.form_type outgoing_form_type,
				tout.account_number,
				tout.to_account_number out_to_account_number,
				tout.to_account_holder,
				tout.bic,
				tout.bank_name,
				tout.description,
				tinc.form_type incoming_form_type,
				tinc.from_account_number,
				tinc.from_account_holder,
				tinc.to_account_number inc_to_account_number,
				tinc.electronic_method,
				tinc.card_type,
				ti.sender,
				ti.recipient
			FROM
				`transactions` t
			INNER JOIN accounts acc on (t.account_id = acc.id AND acc.user_id = {$this->user_id})
			INNER JOIN currencies cur on (acc.currency_id = cur.id)
			INNER JOIN transactions_info ti on (t.info_id = ti.id)
			LEFT JOIN transfers_outgoing tout on (tout.id = t.transfer_id and t.transfer_type = 'outgoing')
			LEFT JOIN transfers_incoming tinc on (tinc.id = t.transfer_id and t.transfer_type = 'incoming')
			WHERE
		" . $where;

        $connection = Yii::app()->db;

        $command = $connection->createCommand($sql);
        $rows = $command->queryAll();
        $this->_transactions = array();

        foreach ($rows as $trans) {
            $this->_transactions[$trans['id']]['id'] = $trans['id'];
            $this->_transactions[$trans['id']]['amount'] = $trans['amount'];
            $this->_transactions[$trans['id']]['type'] = $trans['type'];
            $this->_transactions[$trans['id']]['acc_balance'] = $trans['acc_balance'];
            $this->_transactions[$trans['id']]['created_at'] = $trans['created_at'];
            $this->_transactions[$trans['id']]['currency'] = $trans['currency'];
            $this->_transactions[$trans['id']]['outgoing_form_type'] = $trans['outgoing_form_type'];
            $this->_transactions[$trans['id']]['account_number'] = $trans['account_number'];
            $this->_transactions[$trans['id']]['description'] = $trans['description'];
            $this->_transactions[$trans['id']]['incoming_form_type'] = $trans['incoming_form_type'];
            $this->_transactions[$trans['id']]['from_account_number'] = $trans['from_account_number'];
            $this->_transactions[$trans['id']]['from_account_holder'] = $trans['from_account_holder'];
            $this->_transactions[$trans['id']]['electronic_method'] = $trans['electronic_method'];
            $this->_transactions[$trans['id']]['card_type'] = $trans['card_type'];
            $this->_transactions[$trans['id']]['from_holder'] = $trans['recipient'];
            $this->_transactions[$trans['id']]['to_holder'] = $trans['sender'];
            $this->_transactions[$trans['id']]['url'] = $trans['url'];
            $this->_transactions[$trans['id']]['transfer_type'] = $trans['transfer_type'];
            $this->_transactions[$trans['id']]['transfer_id'] = $trans['transfer_id'];


            if ($trans['transfer_type'] == 'outgoing') {
                if ($trans['type'] == 'negative') {
                    $this->_transactions[$trans['id']]['to_number'] = $trans['out_to_account_number'];
                    $this->_transactions[$trans['id']]['from_number'] = $trans['user_account_number'];
                }

            } elseif ($trans['transfer_type'] == 'incoming') {
                $this->_transactions[$trans['id']]['from_number'] = $trans['from_account_number'];
                $this->_transactions[$trans['id']]['to_number'] = $trans['inc_to_account_number'];
            }
            //$this->_transactions[$trans['id']] =
        }
        return $this->_transactions;
    }
}
