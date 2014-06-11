<?php

/**
 * This is the model class for table "transfers_outgoing".
 *
 * The followings are the available columns in table 'transfers_outgoing':
 */
class Transfers_Incoming_Favorite extends Transfers_Incoming
{
	public $favorite;

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
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transfers_incoming_favorite';
	}
	
	public function rules() {
        return array_merge(
            parent::rules(),
            array(
                array('to_account_id, to_account_number, currency_id, amount', 'safe', 'on' => 'quickUpdate'),
            )
        );
    }
    
    public function scopes()
    {
        $alias = $this->getTableAlias(false, false);
        return Array(
            'own' => Array(
                'condition' => "$alias.user_id = :uid",
                'params' => array(':uid' => Yii::app()->user->id),
                'order' => "$alias.created_at desc",
            ),
        );
    }
}
