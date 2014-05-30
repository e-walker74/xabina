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
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Settings'))] = '';
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new role'))] = '';
        
        
        $this->render('add_role');
    }
    
    public function actionAddUser() {
        $this->render('add_user');
    }
}