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
class Users_Providers extends CActiveRecord
{
        public static $providers = array(1 => 'google_oauth', 2 => 'vkontakte', 3 => 'facebook', 4 => 'linkedin', 5 => 'twitter');
        public static $providersModel = array('google_oauth' => 'Users_Providers_Google', 'vkontakte' => 'Users_Providers_Vkontakte', 'facebook' => 'Users_Providers_Facebook', 'linkedin' => 'Users_Providers_Linkedin', 'twitter' => 'Users_Providers_Twitter');
        public $provider_id;
        public $provider_name;

        public function tableName()
	{
		return 'users_providers_google_oauth'; // default table
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserProviders the static model class
	 */
	public static function model($className=__CLASS__)
	{
        if($className != __CLASS__){
            $className = self::$providersModel[$className];
        }
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
			array('user_id, soc_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
            array('soc_id', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, soc_id', 'safe', 'on'=>'search'),
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
                    'user' => array(self::BELONGS_TO, 'Users', 'user_id')
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
			'soc_id' => 'Soc',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('soc_id',$this->soc_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function beforeSave() {
            parent::beforeSave();
            if($this->provider_id){
                $this->getTableSchema()->rawName = '`users_providers_' . self::$providers[$this->provider_id] . '`';
            }
            return true;
        }

        public function addSocialToUser($identity, $user_id){
            $userProviders = new Users_Providers();
            $userProviders->soc_id          = $identity->getAttribute('soc_id');
            $userProviders->full_name          = $identity->getAttribute('full_name');
            $userProviders->url          = $identity->getAttribute('url');
			$userProviders->login          = $identity->getAttribute('login');
            $userProviders->avatar          = $identity->getAttribute('avatar');
            $userProviders->user_id         = $user_id;
            $userProviders->provider_id = array_search($identity->getProviderName(), Users_Providers::$providers);
            if($userProviders->save()){
				$firstsoc = Users_Socials::model()->findAll('user_id = :uid', array(':uid' => $userProviders->user_id));
                $provider = new Users_Socials;
                $provider->user_id = $userProviders->user_id;
				if(empty($firstsoc)){
					$provider->is_master = 1;
				}
                $provider->rel_id = $userProviders->id;
                $provider->provider = self::$providersModel[self::$providers[$userProviders->provider_id]];
                $provider->save();
            }
        }
}