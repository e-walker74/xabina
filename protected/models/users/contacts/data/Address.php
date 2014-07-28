<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Address $contact
 */
class Users_Contacts_Data_Address extends Users_Contacts_Data_Model
{

    public $address;
    public $address_line_2;
    public $index;
    public $country_id;
    public $country_code;
    public $category;
    public $city;

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
                array('address, country_id', 'required'),
                array('city, index, category', 'length', 'max' => 140),
                array('address, address_line_2', 'length', 'max' => 50),
                array('index', 'length', 'max' => 10),
                array('country_id', 'numerical'),
            ));
    }

    public function getCountry()
    {
        return Countries::model()->findByPk($this->country_id);
    }

    public function attributeNames()
    {
        return array(
            'address',
            'index',
            'country_id',
            'category',
            'city',
            'address_line_2',
        );
    }

    public function getDataTitle()
    {
        return Yii::t('Front', 'Dates');
    }

    public function getAddressHtml($doc = false)
    {
        $br = "<br/>";
        $ao = ($this->address_line_2) ? $this->address_line_2 . $br : "";
        $html = "{$this->address} {$br} {$ao} {$this->index} {$this->city} ({$this->country->code})";
        return $html;
    }
}
