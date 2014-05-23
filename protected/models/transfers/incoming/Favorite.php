<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 */
class Transfers_Incoming_Favorite extends Transfers_Incoming
{
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_incoming_favorite';
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
