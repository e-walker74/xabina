<?php

/**
 * This is the model class for table "users_ids".
 *
 * The followings are the available columns in table 'users_ids':
 * @property string $id
 * @property string $user_id
 * @property string $new_user_id
 * @property string $confirm_code
 * @property string $confirm_at
 * @property string $created_at
 * @property string $compare_confirm_code
 * @property string $confirm_new_user_id
 *
 * The followings are the available model relations:
 * @property Users  $user
 */
class Users_Ids extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVE = 1;
    const STATUS_CANCELED = 2;

    public $confirm_new_user_id;
    public $compare_confirm_code;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_ids';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('new_user_id, confirm_new_user_id', 'required', 'on' => 'insert'),
            array('new_user_id', 'length', 'min' => 5, 'max' => 20, 'tooShort' => Yii::t('Front', 'User ID is too short'), 'tooLong' => Yii::t('Front', 'User ID is too long')),
            array('new_user_id', 'match', 'pattern' => '/^[0-9a-zA-Z\_]{1,}$/', 'message' => Yii::t('Front', 'Insert Your User ID using latin alphabet')),
            array('compare_confirm_code', 'required', 'on' => 'update'),
            array('user_id, confirm_at, created_at', 'length', 'max' => 11),
            array('new_user_id', 'length', 'max' => 20),
            array('new_user_id', 'unique', 'attributeName' => 'login', 'className' => 'Users', 'caseSensitive' => false, 'allowEmpty' => false, 'on' => 'insert'),
            array('confirm_code', 'length', 'max' => 6),
            array('confirm_new_user_id', 'compare', 'compareAttribute' => 'new_user_id', 'on' => 'insert'),
            array('compare_confirm_code', 'compare', 'compareAttribute' => 'confirm_code', 'on' => 'update', 'message' => Yii::t('Personal', 'Code is incorrect')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, new_user_id, confim_code, confirm_at, created_at', 'safe', 'on' => 'search'),
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
            'new_user_id' => 'New User',
            'confim_code' => 'Confim Code',
            'confirm_at' => 'Confirm At',
            'created_at' => 'Created At',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('new_user_id', $this->new_user_id, true);
        $criteria->compare('confim_code', $this->confim_code, true);
        $criteria->compare('confirm_at', $this->confirm_at, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return $this the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getIsCanChange()
    {
        if($this->isNewRecord){
            return true;
        }
        if($this->status != Users_Ids::STATUS_APPROVE){
            return true;
        }
        if(time() - $this->confirm_at > 3600*24*30*3){
            return true;
        }
        return false;
    }
}
