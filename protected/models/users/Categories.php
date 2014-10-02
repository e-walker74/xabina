<?php

/**
 * This is the model class for table "users_contacts_data_categories".
 *
 * The followings are the available columns in table 'users_contacts_data_categories':
 * @property string $id
 * @property string $user_id
 * @property string $data_type
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Users  $user
 * @property Users_Contacts_Data)Categories_Links[] $usersContactsDataCategoriesLinks
 */
class Users_Categories extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users_Contacts_Data_Categories the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, data_type, value', 'required'),
            array('user_id', 'length', 'max' => 11),
            array('data_type', 'length', 'max' => 30),
            array('value', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, data_type, value', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'data_type' => 'Data Type',
            'value' => 'Value',
        );
    }
}
