<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Form_Search extends CFormModel
{
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
			array('account_number, from_date, to_date, from_sum, to_sum', 'numerical', 'message' => Yii::t('Front', 'field is not numeric')),
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
		
		$criteria->params = array(':uid' => Yii::app()->user->id);
		$criteria->condition = 'account.user_id = :uid
		';
		if($this->keyword){
			$criteria->condition .= '
				AND 
				(
					info.sender LIKE :keyword OR
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
		
		$criteria->with = array('account','info');
		$criteria->together = true;
		$criteria->order = 't.created_at desc';

		//d($criteria);
		
		return Transactions::model()->findAll($criteria);
	}
}
