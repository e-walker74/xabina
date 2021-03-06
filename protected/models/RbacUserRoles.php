<?php

/**
 * This is the model class for table "rbac_user_roles".
 *
 * The followings are the available columns in table 'rbac_user_roles':
 * @property int $user_id
 * @property int $role_id
 * @property int $create_uid
 * @property int $account_id
 *
 * The followings are the available model relations:
 * @property RbacRoles $role
 */
class RbacUserRoles extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rbac_user_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, role_id', 'required'),
			array('user_id, role_id, create_uid, account_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, role_id, create_uid, account_id', 'safe', 'on'=>'search'),
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
			'role' => array(self::BELONGS_TO, 'RbacRoles', 'role_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'role_id' => 'Role',
			'create_uid' => 'Create Uid',
			'account_id' => 'Account',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('create_uid',$this->create_uid,true);
		$criteria->compare('account_id',$this->account_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RbacUserRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function addUserRole($data) {
        $userRole = new RbacUserRoles();
        $userRole->account_id = Accounts::model()->findByAttributes(array('number' => $data['account']))->id;
        $userRole->create_uid = Yii::app()->user->getId();
        $userRole->user_id    = Users::model()->findByAttributes(array('login' => $data['user']))->id;
        $userRole->role_id    = $data['role'];
        $userRole->save();
        return $userRole;
    }

    public function deleteWithAccessRights(){

    }
}
