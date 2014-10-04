<?php

/**
 * This is the model class for table "users_notifications".
 *
 * The followings are the available columns in table 'users_notifications':
 * @property integer $id
 * @property string $code
 * @property string $type
 * @property integer $moderator_id
 * @property integer $manager_id
 * @property string $title
 * @property string $announce
 * @property string $text
 * @property string $section
 * @property string $section_link
 * @property string $button
 * @property string $button_link
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users_Notifications extends CActiveRecord
{
	const TYPE_NOTE = "note";
	const TYPE_PROMOTION = "promotion";
	const TYPE_INFORMATION = "information";
	const TYPE_WARNING = "warning";
	const TYPE_EMERGENCY = "emergency";


	const SECTION_SETTINGS = "settings";
	const SECTION_APPS = "apps";
	const SECTION_MESSAGE = "message";
	const SECTION_LIST = "list";
	const SECTION_ALERT = "alert";
	const SECTION_DIALOGUE = "dialogue";
	const SECTION_HOME = "home";
	const SECTION_CARD = "card";
	const SECTION_PAYMENT = "payment";
	const SECTION_BALANCE = "balance";
	const SECTION_CREDIT = "credit";
	const SECTION_EXTRA = "extra";


	public $sections = array(
		self::SECTION_SETTINGS=>'set',
		self::SECTION_APPS=>self::SECTION_APPS,
		self::SECTION_MESSAGE=>self::SECTION_MESSAGE,
		self::SECTION_LIST=>self::SECTION_LIST,
		self::SECTION_ALERT=>self::SECTION_ALERT,
		self::SECTION_DIALOGUE=>self::SECTION_DIALOGUE,
		self::SECTION_CARD=>self::SECTION_CARD,
		self::SECTION_PAYMENT=>self::SECTION_PAYMENT,
		self::SECTION_BALANCE=>self::SECTION_BALANCE,
		self::SECTION_CREDIT=>self::SECTION_CREDIT,
		self::SECTION_EXTRA=>self::SECTION_EXTRA,
	);

	public $css_types = array(
		//self::TYPE_NOTE=>'info',
		self::TYPE_PROMOTION=>'blue',
		self::TYPE_INFORMATION=>'white',
		self::TYPE_WARNING=>'yellow',
		self::TYPE_EMERGENCY=>'pink',
	);

	public $css_mini_types = array(
		//self::TYPE_NOTE=>'info',
		self::TYPE_PROMOTION=>'info',
		self::TYPE_INFORMATION=>'info',
		self::TYPE_WARNING=>'warn',
		self::TYPE_EMERGENCY=>'danger',
	);

	public $types = array(
		//self::TYPE_NOTE=>self::TYPE_NOTE,
		self::TYPE_PROMOTION=>self::TYPE_PROMOTION,
		self::TYPE_INFORMATION=>self::TYPE_INFORMATION,
		self::TYPE_WARNING=>self::TYPE_WARNING,
		self::TYPE_EMERGENCY=>self::TYPE_EMERGENCY,
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, code, announce, published_at', 'required'),
			array('moderator_id, manager_id, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>11),
			array('title, section_link, button_link', 'length', 'max'=>255),
			array('section, button, code', 'length', 'max'=>30),
			array('id, type, moderator_id, manager_id, title, announce, text, section, section_link, button, button_link, published_at, created_at, updated_at', 'safe', 'on'=>'search'),
			array('id, type, moderator_id, manager_id, title, announce, text, section, section_link, button, button_link, published_at, created_at, updated_at, users', 'safe', 'on'=>'searchForCurrentUser'),
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
			'users' => array(self::HAS_MANY, 'Users_NotificationsStatuses', 'notification_id'),
			'manager' => array(self::HAS_ONE, 'PersonalManagers', array('id' => 'manager_id')),
			'files' => array(self::HAS_MANY, 'Users_NotificationsFiles', 'notification_id'),
		);
	}

	public function beforeSave() {
		if($this->isNewRecord) {

        	$this->created_at = $this->updated_at = time();
        } else {
			$this->updated_at = time();
		}
        return parent::beforeSave();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'code' => 'Code',
			'moderator_id' => 'Moderator',
			'manager_id' => 'Manager',
			'title' => 'Title',
			'announce' => 'Announce',
			'text' => 'Text',
			'section' => 'Section',
			'section_link' => 'Section Link',
			'button' => 'Button',
			'button_link' => 'Button Link',
			'published_at' => 'Published At',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('announce',$this->announce,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('section_link',$this->section_link,true);
		$criteria->compare('button',$this->button,true);
		$criteria->compare('button_link',$this->button_link,true);
		$criteria->compare('published_at',$this->published_at);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
