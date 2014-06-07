<?php

class RbacController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function actionSwitchAccount() {
        $uid = (int)$_POST['account'];
        $rbacUid = Yii::app()->user->getRbacCurrentUid();
        if($rbacUid != $uid) {
            if($uid == Yii::app()->user->getId()) {
                Yii::app()->user->switchRbacAccount();
            } else {
                Yii::app()->user->switchRbacAccount($uid);
            }
        }
        $this->redirect(array('/banking'));
    }
    
    public function actionRoles() {
        $this->render('roles_management');
    }
    
    public function actionAddRole() {
        
        if(isset($_POST['RbacRoles'])) {
            $role = new RbacRoles();
            $role->name = $_POST['RbacRoles']['name'];
            $role->is_system = 0;
            $role->create_uid = Yii::app()->user->getId();
            $role->save();
            
            RbacRoleAccessRights::model()->saveRoleRights($role->id, $_POST['RbacRoles']['rights']);
        }
        
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Settings'))] = '';
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new role'))] = '';
        
        $roles = RbacRoles::model()->findAll('is_system=1 or create_uid = ' . Yii::app()->user->getId());
        $rightsTree = RbacAccessRights::model()->getAccessRightsTree();
        $this->render('add_role', array('rightsTree' => $rightsTree, 'roles'=>$roles));
    }
    
    public function actionAddUser() {
        $this->render('add_user');
    }
}