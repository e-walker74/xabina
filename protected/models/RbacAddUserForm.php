<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RbacAddUserForm extends CFormModel
{
    public $account;
	public $user;
	public $role;
    public $rights;
    public $access_id;

    private $account_id;
    private $user_id;
    private $role_id;

    public function rules()
	{
		return array(
			array('account', 'required', 'message' => Yii::t('Front', 'Account is incorrect')),
            array('account', 'checkAccount', 'message' => Yii::t('Front', 'Account not exists')),
            array('user', 'required', 'message' => Yii::t('Front', 'User is incorrect')),
            array('user', 'checkUser', 'message' => Yii::t('Front', 'User not exists')),
            array('role', 'required', 'message' => Yii::t('Front', 'Role is incorrect')),
            array('role', 'checkRole', 'message' => Yii::t('Front', 'Role not exists')),
            array('access_id', 'numerical'),
            array('access_id', 'checkAccess'),
            array('rights', 'checkRights', 'on'=>'save', 'message' => Yii::t('Front', 'Select at least one access right')),
		);
	}

    public function checkAccess($attribute,$params){
        if($this->$attribute){
            $userRole = RbacUserRoles::model()->findByPk($this->$attribute);
            if($userRole && $userRole->create_uid == Yii::app()->user->id){
                return true;
            } else {
                $this->addError($attribute, Yii::t('Front', 'Access is incorrect'));
            }
        }

    }
    
    public function checkAccount($attribute,$params) {
        $account = Accounts::model()->findByAttributes(array('number' => $this->account));
        if($account != NULL) {
            $this->account_id = $account->id;
        } else {
            $this->addError($attribute, $params['message']);
        }
    }
    
    public function checkUser($attribute,$params) {
        $user = Users::model()->findByAttributes(array('login' => $this->user));
        if($user != NULL) {
            $this->user_id = $user->id;
        } else {
            $this->addError($attribute, $params['message']);
        }
    }
    
    public function checkRole($attribute,$params) {
        $role = RbacRoles::model()->findByPk($this->role);
        if($role != NULL) {
            $this->role_id = $role->id;
        } else {
            $this->addError($attribute, $params['message']);
        }
    }
    
    public function checkRights($attribute,$params) {
        if(!is_array($this->rights)) {
            $this->addError($attribute, $params['message']);
        }
    }
    
    public function save() {
        if($this->access_id){
            $userRole = RbacUserRoles::model()->findByAttributes(
                array(
                    'id' => $this->access_id,
                    'create_uid' => Yii::app()->user->id,
                )
            );
        } else {
            $userRole = new RbacUserRoles();
        }
        $userRole->account_id = $this->account_id;
        $userRole->user_id    = $this->user_id;
        $userRole->role_id    = $this->role_id;
        $userRole->create_uid = Yii::app()->user->getId();
        $userRole->save();
        RbacUserAccessRights::model()->saveUserRights($userRole, $this->rights);
    }


    public function beforeValidate() {
        if(parent::beforeValidate())
        {

            return true;
        }
    }
}