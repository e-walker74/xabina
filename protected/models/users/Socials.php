<?php

/**
 * This is the model class for table "user_providers".
 *
 * The followings are the available columns in table 'user_providers':
 * @property integer $id
 * @property integer $user_id
 * @property integer $provider_id
 * @property integer $soc_id
 */
class Users_Socials extends ActiveRecord
{
    public function tableName()
	{
		return 'users_providers'; // default table
	}
	
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
		return array(
			array('user_id, rel_id', 'required'),
            array('provider', 'length', 'max' => 60),
//            array('is_master'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, rel_id', 'safe', 'on'=>'search'),
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

    public function getProvider(){
        $model = new $this->provider;
        return $model->findByPk($this->rel_id);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'soc_id' => 'Soc',
		);
	}
}