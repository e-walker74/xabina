<?php

class Transfers_Outgoing_Favorite extends Transfers_Outgoing
{

	public $favorite;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_outgoing_favorite';
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
			//'xabina_account' => array(self::BELONGS_TO, 'Accounts', 'account_number'),
		);
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

}
