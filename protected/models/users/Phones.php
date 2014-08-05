<?php

/**
 * This is the model class for table "users_phones".
 *
 * The followings are the available columns in table 'users_phones':
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $hash
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $is_master
 * @property string $phone
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property EmailTypes $emailType
 */
class Users_Phones extends Users_Profile
{

	public $withOutHash = false;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_phones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('category_id', 'required', 'on'=>'editphones', 'message' => Yii::t('Front', 'Phone Type is cannot be blank.')),
            array('phone', 'required', 'message' => Yii::t('Front', 'Mobile Phone is incorrect'),'on'=>'editphones'),
            array('phone', 'match', 'pattern' => '/^\+\d+$/', 'message' => Yii::t('Front', 'Mobile Phone must be like +311..'),'on'=>'editphones'),
            array('phone', 'checkPhoneUnique', 'on'=>'editphones'),
            array('phone', 'length', 'min' => 11, 'max' => 19, 'tooShort' => Yii::t('Front', 'Mobile Phone is too short'), 'tooLong' => Yii::t('Front', 'Mobile Phone is too long')),
            array('user_id, category_id, status, is_master', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, category_id, hash, status, is_master, phone', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Проверка на повторяемость телефона
     * @param $attribute
     * @param $params
     */
    public function checkPhoneUnique($attribute, $params){
        // сверяем телефоны без +
        $this->phone = trim($this->phone,'+');
        $phone1 = false;
        $phone2 = false;
        if($this->isNewRecord){
            $phone1 = Users_Phones::model()->find('phone = :phone AND status=1', array(':phone' => $this->phone));
            $phone2 = Users_Phones::model()->find('phone = :phone AND user_id=:user_id', array(':phone' => $this->phone, ':user_id' =>  Yii::app()->user->id));

        } else {
            $phone1 = Users_Phones::model()->find('phone = :phone AND id != :id AND status=1', array(':phone' => $this->phone, ':id' => $this->id));
            $phone2 = Users_Phones::model()->find('phone = :phone AND id != :id AND user_id=:user_id', array(':phone' => $this->phone, ':id' => $this->id, ':user_id' =>  Yii::app()->user->id));
        }
        if($phone1 || $phone2){
            $this->addError('phone', Yii::t('Front', 'This Phone is already registered'));
        }
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
			'category_id' => 'Email Type',
			'hash' => 'Hash',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'status' => 'Status',
			'is_master' => 'Is Master',
			'phone' => 'Phone',
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_master',$this->is_master);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function generateHash(){
		if(!$this->withOutHash){
			$this->hash = rand(1000, 9999);
		}
	}
	
    public function beforeSave(){
        if($this->isNewRecord){
            $this->generateHash();
        }
        // телефон должен попадать в базу без +
        $this->phone = trim($this->phone, '+');
        return parent::beforeSave();
    }
}
