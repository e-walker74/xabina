<?php

/**
 * This is the model class for table "users_telephones".
 *
 * The followings are the available columns in table 'users_telephones':
 * @property integer $id
 * @property integer $user_id
 * @property integer $number
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users_Telephones extends Users_Profile
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users_Telephones the static model class
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
        return 'users_telephones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('number', 'required', 'message' => Yii::t('Front', 'Phone Number is incorrect')),
//            array('category_id', 'required', 'message' => Yii::t('Front', 'Phone Type is incorrect')),
            array('number', 'length', 'min' => 11, 'max' => 19, 'tooShort' => Yii::t('Front', 'Phone is too short')),
            array('user_id, number', 'numerical', 'integerOnly' => true, 'message' => Yii::t('Front', 'Phone Number is incorrect')),
            array('category_id', 'numerical'),
            array('number', 'uniqueByUser', 'on' => 'create'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, number', 'safe', 'on' => 'search'),
        );
    }

    public function uniqueByUser($attribute, $params)
    {
        if(self::model()->currentUser()->findByAttributes(array($attribute => $this->$attribute))){
            $this->addError($attribute, Yii::t('Personal', 'This ' . $this->getAttributeLabel($attribute) . ' was added below'));
        }
        return true;
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
            'category' => array(self::BELONGS_TO, 'Users_Categories', 'category_id'),
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
            'number' => 'Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('number', $this->number);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
