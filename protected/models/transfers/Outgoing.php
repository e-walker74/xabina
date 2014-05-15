<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 */
class Transfers_Outgoing extends ActiveRecord
{

	public static $charges = array('1' => 'Shared (mandatory for EC payments)', 2 => 'Receiver pays the fees', 3 => 'Sender pays the fees');
	
	const PENDING_STATUS = 0;
	const APPROVED_STATUS = 1;
	const REJECTED_STATUS = 2;
	
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
            array('amount, account_number, currency_id, charges, form_type', 'required'),
            array('amount, account_number, currency_id, charges, remaining_balance, counter_agent, each_period, category_id, external_bank_id', 'numerical'),
            array('urgent, favorite, is_iban', 'boolean'),
            array('tag1, tag2, tag3, to_account_number', 'length', 'max' => 255),
            array('period', 'in', 'range' => array('day', 'week', 'month', 'year')),
            array('frequency_type', 'in', 'range' => array(1, 2)),
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
			'account' => array(self::BELONGS_TO, 'Accounts', 'account_number'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			//'xabina_account' => array(self::BELONGS_TO, 'Accounts', 'account_number'),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
            $this->status = self::PENDING_STATUS;
			$this->user_id = Yii::app()->user->id;
            if($this->frequency_type == 1 && !$this->execution_date){
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

		$criteria=new CDbCriteria;

		$criteria->compare('t.status',0);
		$criteria->compare('t.need_confirm',0);
		$criteria->compare('amount',$this->amount);
		$criteria->with = 'user';
		$criteria->together = true;
		$criteria->order = 't.created_at desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function log()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('t.status',0);
		$criteria->compare('amount',$this->amount);
		$criteria->with = 'user';
		$criteria->together = true;
		$criteria->order = 't.created_at desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransfersOutgoing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getHtmlOperationDescription(){
		switch($this->form_type){
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
	
	public function getHtmlStatus(){
		switch($this->status){
			case self::PENDING_STATUS:
				return '<span class="pending">Pending</span>';
				break;
			case self::APPROVED_STATUS:
				return '<span class="approved">Approved</span>';
				break;
			case self::REJECTED_STATUS:
				return '<span class="rejected">Rejected</span>';
				break;
		}
	}
}
