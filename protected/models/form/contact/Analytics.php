<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Contact_Analytics extends CFormModel
{
	
	protected $_result = false;

	public $from_date;
	public $to_date;
	public $type;
	public $contact_id;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('type', 'length', 'max' => 255, 'message' => Yii::t('Front', 'is to long')),
			array('from_date, to_date, contact_id', 'numerical', 'message' => Yii::t('Front', 'field is not numeric')),
			array('type, from_date, to_date', 'safe'),
			// password needs to be authenticated
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}

	public function search(){
	
		if($this->_result !== false){
			return $this->_result;
		}
		
		$user_id = Yii::app()->user->getCurrentId();
		
		$condition = '';
		if($this->type == 'outgoing'){
			$condition .= '
				AND t.transfer_type = "outgoing"';
		} elseif($this->type == 'incoming'){
			$condition .= '
				AND t.transfer_type = "incoming"';
		}
		
		if($this->from_date){
			$condition .= '
				AND t.created_at > ' . strtotime($this->from_date);
		}
		
		if($this->to_date){
			$condition .= '
				AND t.created_at < ' . strtotime($this->to_date);
		}
	
		$sql = "
			SELECT sum(allamount) value, avg(allamount) average, currency, count(1) count_transfers
			FROM(
				SELECT 
					t.sum,
					t.type,
					t.transfer_type,
					cur.code currency,
					IF(t.type = 'positive', +sum, -sum) allamount
				FROM 
					`transactions` t
				INNER JOIN accounts acc on (t.account_id = acc.id AND acc.user_id = {$user_id})
				INNER JOIN currencies cur on (acc.currency_id = cur.id)
				INNER JOIN transactions_info ti on (t.info_id = ti.id)
				LEFT JOIN transfers_outgoing tout on (tout.id = t.transfer_id and t.transfer_type = 'outgoing')
				LEFT JOIN transfers_incoming tinc on (tinc.id = t.transfer_id and t.transfer_type = 'incoming')
				WHERE 
					t.user_id = {$user_id}   
					AND (tinc.counter_agent = {$this->contact_id} OR tout.counter_agent = {$this->contact_id})
					{$condition}
				) t
           	GROUP BY currency
		";
		
		$connection=Yii::app()->db;
		
		$command=$connection->createCommand($sql);
		$this->_result = $command->queryAll();
		return $this->_result;
	}
}
