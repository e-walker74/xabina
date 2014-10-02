<?php

/**
 * This is the model class for table "users_notifications_statuses".
 *
 * The followings are the available columns in table 'users_notifications_statuses':
 * @property integer $id
 * @property string $user_id
 * @property integer $notification_id
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Users_NotificationsStatuses extends CActiveRecord
{
	const STATUS_NEW = "new";
	const STATUS_SEE = "see";
	const STATUS_HIDDEN = "hidden";
	const STATUS_DONE = "done";

	public $statuses = array(
		self::STATUS_NEW=>self::STATUS_NEW,
		self::STATUS_SEE=>self::STATUS_SEE,
		self::STATUS_HIDDEN=>self::STATUS_HIDDEN,
		self::STATUS_DONE=>self::STATUS_DONE,
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_notifications_statuses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, notification_id, status, created_at, updated_at', 'required'),
			array('notification_id, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('status', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, notification_id, status, created_at, updated_at, message', 'safe', 'on'=>'search'),
			array('id, user_id, notification_id, status, created_at, updated_at, message', 'safe', 'on'=>'admin'),
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
			'message' => array(self::HAS_ONE, 'Users_Notifications', array('id' => 'notification_id')),
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
			'notification_id' => 'Notification',
			'status' => 'Status',
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
	public function search($type = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array(
			'message'
		);
		$criteria->order = "message.published_at desc, message.id desc";
		$criteria->condition = 'message.published_at < '.time();

		$criteria->compare('id',$this->id);
		$criteria->compare('message.type',$type,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
                'pageSize' => 100,
            ),
		));
	}
	public function admin($type = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array(
			'message'
		);
		$criteria->order = "message.published_at desc";
		$criteria->condition = 'message.published_at < '.time();

		$criteria->compare('id',$this->id);
		$criteria->compare('message.type',$type,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users_NotificationsStatuses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function addStatus($notification_id, $user_id, $status = self::STATUS_NEW) {

		$model = new self();
		$model->user_id = $user_id;
		$model->notification_id = $notification_id;
		$model->updated_at = $model->created_at = time();
		$model->status = $status;
		$model->save();
	}
}
