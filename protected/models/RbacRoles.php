<?php

/**
 * This is the model class for table "rbac_roles".
 *
 * The followings are the available columns in table 'rbac_roles':
 * @property string                 $id
 * @property string                 $name
 * @property integer                $is_system
 * @property string                 $create_uid
 * @property string                 $parent_id
 *
 * The followings are the available model relations:
 * @property RbacRoleAccessRights[] $rbacRoleAccessRights
 * @property RbacUserRoles[]        $rbacUserRoles
 */
class RbacRoles extends ActiveRecord
{

    /**
     * param for validate rigth array
     * @var array
     */
    public $rightsArr;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RbacRoles the static model class
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
            array('is_system', 'numerical', 'integerOnly' => true),
            array('rightsArr', 'required'),
            array('name', 'length', 'max' => 30),
            array('create_uid, parent_id', 'length', 'max' => 11),
        );
    }

    public function beforeValidate()
    {
        $this->create_uid = Yii::app()->user->id;
        $this->is_system = 0;
        return parent::beforeValidate();
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

    public function deleteRoleWithRelations()
    {
        $query = "
        DELETE rr, rrar, rur, ruar FROM rbac_roles rr
        LEFT JOIN rbac_role_access_rights rrar on (rrar.role_id = rr.id)
        LEFT JOIN rbac_user_roles rur on (rur.role_id = rr.id)
        LEFT JOIN rbac_user_access_rights ruar on (ruar.role_id = rr.id)
        where rr.id = {$this->id};";

        Yii::app()->db->createCommand($query)->execute();
        return true;
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('is_system', $this->is_system, true);
        $criteria->compare('create_uid', $this->create_uid, true);
        $criteria->compare('parent_id', $this->parent_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }
}
