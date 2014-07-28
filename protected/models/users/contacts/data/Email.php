<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Account $contact
 */
class Users_Contacts_Data_Email extends Users_Contacts_Data_Model
{

	public $email;
	public $category;


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return
            array_merge(
                parent::rules(),
                array(
                    array('email', 'email'),
                    array('email, category', 'required'),
                    array('email, category', 'length', 'max' => 140),
                )
            );
	}
	
	public function attributeNames(){
		return array(
			'email',
			'category',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersContactsData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function getDataTitle(){
        return Yii::t('Front', 'E-Mail');
    }
}
