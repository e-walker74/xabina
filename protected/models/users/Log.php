<?php

/**
 * This is the model class for table "users_log".
 *
 * The followings are the available columns in table 'users_log':
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $ip_addres
 * @property string $browser
 * @property string $os
 * @property string $request_url
 * @property string $region
 * @property integer $created_at
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Users_Log extends CActiveRecord
{
	public $login;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type', 'required'),
			array('user_id, ip_address', 'numerical', 'integerOnly'=>true),
			array('type, browser, os, request_url', 'length', 'max'=>30, 'message' => Yii::t('Front', 'Entry is to long')),
			array('region', 'length', 'max'=>2, 'message' => Yii::t('Front', 'Entry is to long')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, ip_address, browser, os, request_url, region, login', 'safe', 'on'=>'search'),
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

	public function beforeSave(){
		//$browser = get_browser(null, true);
		$this->ip_address = ip2long(Yii::app()->request->getUserHostAddress());
		//$this->browser = $browser['browser'];
		//$this->os = $browser['platform'];
		//$this->browser_version = $browser['version'];
		$this->request_url = $_SERVER['REQUEST_URI'];
		return parent::beforeSave();
	}

	public function afterFind(){
		$this->ip_address = long2ip($this->ip_address);
	}

	public function getUserBrowser($user_agent){
		$res = 'Unknown';
		if(strpos($user_agent, 'MSIE') !== FALSE)
			$res = 'Internet explorer';
		elseif(strpos($user_agent, 'Trident') !== FALSE) //For Supporting IE 11
			$res = 'Internet explorer';
		elseif(strpos($user_agent, 'Firefox') !== FALSE)
			$res = 'Mozilla Firefox';
		elseif(strpos($user_agent, 'Chrome') !== FALSE)
			$res = 'Google Chrome';
		elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
			$res = "Opera Mini";
		elseif(strpos($user_agent, 'Opera') !== FALSE)
			$res = "Opera";
		elseif(strpos($user_agent, 'Safari') !== FALSE)
			$res = "Safari";

		return $res;
	}

	public function getUserOS($user_agent){
		$os_platform    =   "Unknown OS Platform";

		$os_array       =   array(
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);

		foreach ($os_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
				break;
			}
		}

		return $os_platform;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'ip_address' => 'Ip Addres',
			'browser' => 'Browser',
			'os' => 'Os',
			'request_url' => 'Request Url',
			'region' => 'Region',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('ip_address',ip2long($this->ip_address));
		$criteria->compare('browser',$this->browser,true);
		$criteria->compare('os',$this->os,true);
		$criteria->compare('request_url',$this->request_url,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('user.login',$this->login, true);
		$criteria->with = 'user';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.created_at desc',
			),
			'pagination'=>array(
				'pageSize'=>50,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersLogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
