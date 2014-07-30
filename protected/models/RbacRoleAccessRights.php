<?php

/**
 * This is the model class for table "rbac_role_access_rights".
 *
 * The followings are the available columns in table 'rbac_role_access_rights':
 * @property string $role_id
 * @property string $access_right_id
 * @property string $additional_parameters
 *
 * The followings are the available model relations:
 * @property RbacAccessRights $accessRight
 * @property RbacRoles $role
 */
class RbacRoleAccessRights extends CActiveRecord
{
	public function primaryKey(){
		return array(
			'role_id',
			'access_right_id'
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rbac_role_access_rights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, access_right_id', 'required'),
			array('role_id, access_right_id', 'length', 'max'=>11),
			array('additional_parameters', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('role_id, access_right_id, additional_parameters', 'safe', 'on'=>'search'),
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
			'accesRight' => array(self::BELONGS_TO, 'RbacAccessRights', 'access_right_id'),
			'role' => array(self::BELONGS_TO, 'RbacRoles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role_id' => 'Role',
			'access_right_id' => 'Acces Right',
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

		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('access_right_id',$this->access_right_id,true);
		$criteria->compare('additional_parameters',$this->additional_parameters,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RbacRoleAccessRights the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function saveRoleRights($roleId, $rights) {
        $query = "
        DELETE FROM rbac_role_access_rights WHERE role_id = {$roleId};
        INSERT INTO rbac_role_access_rights(role_id, access_right_id) VALUES ";
        $queryArr = array();
        foreach ($rights as $rid => $v) {
            $queryArr[] = '(' . $roleId . ', ' . intval($rid). ')';
        }
        $query .= implode(',', $queryArr);
        $command = Yii::app()->db->createCommand($query);
        return $command->execute();
    }
}
