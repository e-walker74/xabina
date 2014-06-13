<?php

/**
 * This is the model class for table "rbac_user_access_rights".
 *
 * The followings are the available columns in table 'rbac_user_access_rights':
 * @property string $user_id
 * @property string $role_id
 * @property string $access_right_id
 * @property string $account_id
 * @property string $additional_parameters
 */
class RbacUserAccessRights extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rbac_user_access_rights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, role_id, access_right_id', 'required'),
			array('user_id, role_id, access_right_id, account_id', 'length', 'max'=>11),
			array('additional_parameters', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, role_id, access_right_id, account_id, additional_parameters', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
    public function relations()
    {
        return array(
            'account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
            'user' => array(self::BELONGS_TO, 'users', 'user_id'),
            'role' => array(self::BELONGS_TO, 'RbacRoles', 'role_id'),
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
			'access_right_id' => 'Access Right',
			'account_id' => 'Account',
			'additional_parameters' => 'Additional Parameters',
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
		$criteria->compare('access_right_id',$this->access_right_id,true);
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('additional_parameters',$this->additional_parameters,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RbacUserAccessRights the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function saveUserRights($userRole, $rights) {

        $query = "
        DELETE FROM rbac_user_access_rights WHERE role_id = {$userRole->role_id} AND user_id = {$userRole->user_id} AND account_id = {$userRole->account_id};
        INSERT INTO rbac_user_access_rights (`user_id`, `role_id`, "
            . "`access_right_id`, `account_id`) VALUES ";
        $queryArr = array();
        foreach ($rights as $rid => $v) {
            $buff = array($userRole->user_id, $userRole->role_id, $rid, $userRole->account_id);
            $queryArr[] = '('. implode(',', $buff). ')';
        }
        $query .= implode(',', $queryArr);
        $command = Yii::app()->db->createCommand($query);
        
        return $command->execute();
    }
}
