<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Phone $contact
 */
class Users_Contacts_Data_Phone extends Users_Contacts_Data_Model
{

    public $phone;
    public $category;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UsersContactsData the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array_merge(
            parent::rules(),
            array(
                array('phone', 'required'),
                array('phone', 'numerical'),
                array('category', 'length', 'max' => 140),
                array('phone', 'length', 'max' => 20),
            ));
    }

    public function attributeNames()
    {
        return array(
            'phone',
            'category',
        );
    }

    public function getDataTitle()
    {
        return Yii::t('Front', 'Phone');
    }
}
