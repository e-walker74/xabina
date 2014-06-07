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
            
            $query = "INSERT INTO rbac_role_access_rights(role_id, acces_right_id) VALUES";
            foreach ($_POST['RbacRoles']['rights'] as $rid => $v) {
                $query .= '(' . $role->id . ', ' . intval($rid). '),';
            }
            $query = rtrim($query, ",");
            $command = Yii::app()->db->createCommand($query);
            $command->execute();
        }
        
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Settings'))] = '';
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new role'))] = '';
        
        $rightsTree = RbacAccessRights::model()->getAccessRightsTree();
        $this->render('add_role', array('rightsTree' => $rightsTree));
    }
    
    public function actionAddUser() {
        $this->render('add_user');
    }
}