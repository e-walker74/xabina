<?php

/**
 * This is the model class for table "rbac_roles".
 *
 * The followings are the available columns in table 'rbac_roles':
 * @property string $id
 * @property string $name
 * @property integer $is_system
 * @property string $create_uid
 * @property string $parent_id
 *
 * The followings are the available model relations:
 * @property RbacRoleAccessRights[] $rbacRoleAccessRights
 * @property RbacUserRoles[] $rbacUserRoles
 */
class RbacRoles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rbac_roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, is_system, create_uid', 'required'),
			array('is_system', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('create_uid, parent_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, is_system, create_uid, parent_id', 'safe', 'on'=>'search'),
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
			'rbacRoleAccessRights' => array(self::HAS_MANY, 'RbacRoleAccessRights', 'role_id'),
			'rbacUserRoles' => array(self::HAS_MANY, 'RbacUserRoles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'is_system' => 'Is System',
			'create_uid' => 'Create Uid',
			'parent_id' => 'Parent',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_system',$this->is_system);
		$criteria->compare('create_uid',$this->create_uid,true);
		$criteria->compare('parent_id',$this->parent_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RbacRoles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
}
