<?php

/**
 * This is the model class for table "users_emails".
 *
 * The followings are the available columns in table 'users_emails':
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string  $hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $is_master
 * @property string  $email
 *
 * The followings are the available model relations:
 * @property Users   $user
 * @property Users_Categories $category
 */
class Users_Emails extends Users_Profile
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_emails';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, category_id', 'required', 'on' => 'editemails'),
            array('email', 'email'),
            array('user_id, category_id, status, is_master', 'numerical', 'integerOnly' => true),
            array('hash', 'length', 'max' => 32, 'message' => Yii::t('Front', 'Entry is to long')),
            array('email', 'length', 'max' => 200, 'message' => Yii::t('Front', 'Entry is to long')),
            array('email', 'checkEmailUnique', 'on' => 'editemails'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, category_id, hash, status, is_master, email', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Проверка на уникальность емейла
     * @param $attribute
     * @param $params
     */
    public function checkEmailUnique($attribute, $params)
    {
        $this->email = trim($this->email);
        $email1 = false;
        $email2 = false;
        if ($this->isNewRecord) {
            $email1 = Users_Emails::model()->find('email = :email AND status=1', array(':email' => $this->email));
            $email2 = Users_Emails::model()->find('email = :email AND user_id=:user_id', array(':email' => $this->email, ':user_id' => Yii::app()->user->id));
        } else {
            $email1 = Users_Emails::model()->find('email = :email AND id != :id AND status=1', array(':email' => $this->email, ':id' => $this->id));
            $email2 = Users_Emails::model()->find('email = :email AND id != :id AND user_id=:user_id', array(':email' => $this->email, ':id' => $this->id, ':user_id' => Yii::app()->user->id));
        }
        if ($email1 || $email2) {
            $this->addError('email', Yii::t('Front', 'This E-mail is already registered'));
        }
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
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
            'category_id' => Yii::t('Personal', 'Category'),
            'hash' => 'Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'is_master' => 'Is Master',
            'email' => 'Email',
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
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->generateHash();
        }
        return parent::beforeSave();
    }

    public function generateHash()
    {
        $this->hash = md5('email' . time() . $this->email);
    }
}
