<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Search extends CFormModel
{
	public $account_id;
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
			array('account_id, account_number, from_date, to_date, from_sum, to_sum', 'numerical', 'message' => Yii::t('Front', 'field is not numeric')),
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

		//$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account.user_id',Yii::app()->user->id);
		$criteria->compare('account.number', $this->account_number);
		$criteria->compare('info.sender', $this->sender, true);
		$criteria->compare('info.details_of_payment', $this->keyword, true);
		if($this->type == 'incoming'){
			$criteria->compare('t.type','positive');
		} elseif($this->type == 'outgoing'){
			$criteria->compare('t.type','negative');
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
		
		$criteria->with = array('account','info');
		$criteria->together = true;
		$criteria->order = 't.created_at desc';
		
		return Transactions::model()->findAll($criteria);
	}
}
