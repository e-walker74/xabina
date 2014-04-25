<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property integer $status
 * @property integer $date_add
 * @property integer $date_edit
 */
class Users extends ActiveRecord
{

	const USER_IS_VERIFICATED = 1;
	const USER_IS_ACTIVATED = 2;
	const USER_EMAIL_IS_ACTIVE = 3;
	const USER_IS_NOT_ACTIVE = 4;

	public static $roles = array(1 => 'individual', 2 => 'legalentity');

    public $newpassword;
	public $repassword;
    public $old_password;
    public $reemail;

	public static function getModelByType($type){
		$className = 'Users_' . $type;
        return parent::model($className, true);
	}

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
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
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password, email, status, created_at, updated_at, role', 'required', 'except' => 'adminCreate'),
			//array('password', 'required', 'on' => array('general_update')),
            array('email, reemail', 'email'),
			//array('login', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify'), 'on' => 'update'),
            //array('reemail', 'compareEmail', 'on' => 'general_update'),
            array('email, login', 'unique', 'message' => Yii::t('Front', 'E-Mail is incorrect')),
            array('status, created_at, updated_at, gift', 'numerical', 'integerOnly' => true),
			//array('phone', 'phone', 'length' => 9),
			array('email', 'length', 'max' => 255),
			//array('login', 'match', 'pattern' => '/^[0-9a-zA-Z\-\@\_\.]{1,}$/'),
			array('hash', 'length', 'max' => 32),
            array('password', 'length', 'max' => 32, 'min' => 6),
            array('repassword', 'compare', 'compareAttribute' => 'newpassword', 'on' => 'general_update', 'message' => Yii::t('Front', 'Введенные пароли не совпадают')),
			array('first_name, last_name', 'match', 'pattern' => '/^[a-zA-Z\-]{1,}$/', 'message' => Yii::t('Front', 'Add Your name using latin alphabet')),
			/*array('phone', 'match', 'pattern' => '/^\+\d+$/', 'message' => Yii::t('Front', 'Mobile Phone must be like +311..')),*/
			array('phone', 'length', 'min' => 10, 'max' => 19, 'message' => Yii::t('Front', 'Mobile Phone is incorrect')),
			array('phone', 'authenticatePhone'),
			// The following rule is used by search().
            // Please remove those attributes that should not be searched.
            //array('first_name, last_name, phone', 'safe', 'on' => 'insert'),
			array('first_name, last_name, phone, email', 'safe', 'on' => 'update'),
            array('password, email, reemail, repassword, newpassword, phone', 'safe', 'on' => 'general_update'),
			array('login, email, phone, role', 'safe', 'on' => 'admin'),
        );
    }

	public function authenticatePhone($attribute,$params)
	{
		//if(!$this->hasErrors())
		//{
			$this->phone = trim($this->phone, '+');
			if($this->isNewRecord){
				$user = Users::model()->find('phone = :phone', array(':phone' => $this->phone));
			} else {
				$user = Users::model()->find('phone = :phone AND id != :id', array(':phone' => $this->phone, ':id' => $this->id));
			}
			if($user){
				$this->addError('phone', Yii::t('Front', 'This Mobile Phone is already registered'));
			}
		//}
	}

//        fsockopen("mx1.hotmail.com", 25, $errno , $errstr, 15)
    public function compareOldPass(){
        if($this->password){
            if(md5($this->old_password) != $this->oldAttributes['password']){
                $this->addError('old_password', Yii::t('Front', 'Пароль введен не верно'));
            }
        }
    }

    public function compareEmail(){
        if($this->email != $this->oldAttributes['email']){
            if($this->email != $this->reemail){
                $this->addError('reemail', Yii::t('Front', 'Не верно введено поле email'));
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'profile' => array(self::HAS_ONE, 'Users_Profile', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Users_Notification', 'user_id'),
			'notifications_active' => array(self::HAS_MANY, 'Users_Notification', 'user_id', 'condition' => 'closed = 0'),
			'last_auth' => array(self::HAS_ONE, 'Users_Log', 'user_id', 'condition' => 'type = "login"', 'order' => 'created_at desc'),
            'emails' => array(self::HAS_MANY, 'Users_Emails', 'user_id'),
			'addresses' => array(self::HAS_MANY, 'Users_Address', 'user_id'),
			'phones' => array(self::HAS_MANY, 'Users_Phones', 'user_id'),
            'vkontakte' => array(self::HAS_MANY, 'Users_Providers_Vkontakte', 'user_id'),
            'facebook' => array(self::HAS_MANY, 'Users_Providers_Facebook', 'user_id'),
            'linkedin' => array(self::HAS_MANY, 'Users_Providers_Linkedin', 'user_id'),
            'twitter' => array(self::HAS_MANY, 'Users_Providers_Twitter', 'user_id'),
            'socials' => array(self::HAS_MANY, 'Users_Socials', 'user_id'),
			'messagers' => array(self::HAS_MANY, 'Users_Instmessagers', 'user_id', 'order' => 'created_at asc'),
			'questions' => array(self::HAS_MANY, 'Users_Securityquestions', 'user_id', 'order' => 'created_at asc'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'ID',
            'login'        => Yii::t('Front', 'Login'),
			'nickName'     => Yii::t('Front', 'Имя на сайте'),
            'password'     => Yii::t('Front', 'Новый пароль'),
            'email'        => Yii::t('Front', 'email'),
            'reemail'      => Yii::t('Front', 'Повторите (email)'),
            'status'       => Yii::t('Front', 'Status'),
            'created_at'     => Yii::t('Front', 'Date Add'),
            'updated_at'    => Yii::t('Front', 'Date Edit'),
            'repassword'   => Yii::t('Front', 'Повторите'),
            'old_password' => Yii::t('Front', 'Старый пароль'),
			'phone' 	   => Yii::t('Front', 'Мобильный'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);
		//$criteria->select = 't.*, count(orders.id) as order';
		$criteria->together = true;
		if(!isset($_GET['Users_sort'])){
			$criteria->order = 'id desc';
		}

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
					'pagination'=>array(
						'pageSize'=>10,
					),
                ));
    }

    public function remindPassword()
    {
        if (!$this->email) {
            return false;
        }
        $mail = new Mail();
        $pass = substr(md5(time() . $this->email . 'remind evna pass'), 6, 8);
        $mail->send($this, 'remindPassword', array('password' => $pass), true);
        $this->password = md5($pass);
        $this->save();
        return true;
    }

    public function afterDelete()
    {
        $this->profile->delete();
        parent::afterDelete();
    }

	public function getFullName(){
		$res = $this->login;
		if($this->first_name && $this->last_name){
			$res = $this->first_name;
			if($this->last_name){
				$res .= ' ' . $this->last_name;
			}
		}
		return $res;
	}

	public function createHash(){
		$this->hash = md5(crc32('xabina was here' . $this->id . $this->email . time()));
	}

	public function sendEmailConfirm(){
		$mail = new Mail();
		$this->createHash();
		//$mail->send($this, 'emailConfirm', array('hash' => $this->hash), true);
	}

	/*public function addNotification($message, $type = 'close', $style = 'green'){
		$notify = new Users_Notification;
		$notify->message = $message;
		$notify->type = $type;
		$notify->style = $style;
		$notify->user_id = $this->id;
		$notify->save();
	}*/
	
	public static function addNotification($code, $message, $type = 'close', $style = 'green', $user_id = false){
		if(!$user_id){
			$user_id = Yii::app()->user->id;
			$user = Users::model()->findByPk($user_id);
		} else {
			$user = Users::model()->findByPk(Yii::app()->user->id);
		}
		
		$notify = Users_Notification::model()->find('code = :code AND user_id = :uid AND closed = 0', array(
			'code' => $code,
			':uid' => $user_id,
		));
		if($notify){
			return false;
		}
		$notify = new Users_Notification();
		$notify->user_id = $user_id;
		$notify->code = $code;
		$notify->message = $message;
		$notify->type = $type;
		$notify->style = $style;
		if($notify->save()){
			//$this->_notifications = false;
			return true;
		}
		return false;
	}
	
	public static function removeNotification($code, $user_id){
		Users_Notification::model()->findAll('code = :code AND user_id = :ui', array(':code' => $code, ':ui' => $user_id));
	}
}