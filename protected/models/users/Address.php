<?php

/**
 * This is the model class for table "users_address".
 *
 * The followings are the available columns in table 'users_address':
 * @property integer          $id
 * @property integer          $user_id
 * @property integer          $category_id
 * @property string           $hash
 * @property integer          $created_at
 * @property integer          $updated_at
 * @property integer          $status
 * @property integer          $is_master
 * @property string           $address
 * @property string           $address_optional
 * @property string           $city
 * @property string           $indx
 * @property integer          $country_id
 *
 * The followings are the available model relations:
 * @property Users            $user
 * @property Users_Categories $category
 * @property Countries        $country
 */
class Users_Address extends Users_Profile
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_address';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array('country_id, address, indx, city', 'required', 'on' => 'editaddress'),
            //array('indx', 'match', 'pattern' => '/*\d+*/'),
            array('user_id, category_id, status, is_master, country_id', 'numerical', 'integerOnly' => true),
            array('hash', 'length', 'max' => 32, 'message' => Yii::t('Front', 'Entry is to long')),
            array('indx', 'length', 'max' => 10, 'message' => Yii::t('Front', 'Entry is to long')),
            array('address, address_optional, city', 'length', 'max' => 50, 'message' => Yii::t('Front', 'Entry is to long')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, category_id, hash, status, is_master, address, address_optional, city, indx, country_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {

        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Users_Categories', 'category_id'),
            'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
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
            'category_id' => 'category',
            'hash' => 'Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'is_master' => 'Is Master',
            'address' => 'Address',
            'address_optional' => 'Address_optional',
            'indx' => 'Index',
            'city' => 'City',
            'country_id' => 'Country_id'
        );
    }


    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('hash', $this->hash, true);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);
        $criteria->compare('status', $this->status);
        $criteria->compare('is_master', $this->is_master);
        $criteria->compare('address', $this->address, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users_Address the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getAddressHtml($doc = false)
    {
        $br = "<br/>";
        if ($doc) {
            $br = "\n\r";
        }
        $ao = ($this->address_optional) ? $this->address_optional . $br : "";
        $html = "{$this->address} {$br} {$ao} {$this->indx} {$this->city} ({$this->country->code})";

        return $html;
    }

    public function beforeSave()
    {
        if(!self::model()->ownUser()->findAll()){
            $this->is_master = 1;
        }
        return parent::beforeSave();
    }

}
