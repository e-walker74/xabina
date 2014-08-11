<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 */
class Transfers_Outgoing_Standing extends Transfers_Outgoing
{
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_outgoing_standing';
	}
	
	public function rules(){
        return array_merge(
            parent::rules(),
            array(
                array('id', 'required'),
				array('id', 'numerical'),
            )
        );
    }
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
