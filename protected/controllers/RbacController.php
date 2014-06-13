<?php

class RbacController extends Controller
{

    public $layout = 'banking';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
                    'SwitchAccount',
                    'Roles',
                    'AddRole',
                    'AddUser',
                    'deleterole',
                    'manageusers',
                ),
                'roles' => array('client'),
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function init()
    {
        Yii::app()->clientScript->registerScriptFile("/js/rbac.js", CClientScript::POS_HEAD);
        return parent::init();
    }

    public function actionSwitchAccount()
    {
        $uid = (int)$_POST['account'];
        $rbacUid = Yii::app()->user->getRbacCurrentUid();
        if ($rbacUid != $uid) {
            if ($uid == Yii::app()->user->getId()) {
                Yii::app()->user->switchRbacAccount();
            } else {
                Yii::app()->user->switchRbacAccount($uid);
            }
        }
        $this->redirect(array('/banking'));
    }

    public function actionRoles()
    {

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Personal Account')))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'RBAC'))] = '';

        $criteria = new CDbCriteria();
        $criteria->compare('t.create_uid', Yii::app()->user->getId(), false, 'OR');
        $criteria->compare('t.create_uid', 0, false, 'OR');
        $criteria->compare('t.is_system', 0, false);
        $criteria->with = array('rbacUserRoles');
        $criteria->together = true;
        $criteria->order = 't.create_uid asc';

        $roles = RbacRoles::model()->findAll($criteria);

        $this->render('roles_management', array('roles' => $roles));
    }

    public function actionAddRole()
    {
        $role = new RbacRoles();
        if (Yii::app()->request->getParam('role_id', '', 'int')) {
            $role = RbacRoles::model()->findByAttributes(array(
                'create_uid' => Yii::app()->user->id,
                'id' => Yii::app()->request->getParam('role_id', '', 'int'),
            ));
            if (!$role) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
        }
        $this->performAjaxValidation($role, 'add-role-form');
        $tplVars = array();

        if (isset($_POST['RbacRoles'])) {
            if ($_POST['RbacRoles']['id']) {
                $model = RbacRoles::model()->findByAttributes(array(
                    'create_uid' => Yii::app()->user->id,
                    'id' => (int)$_POST['RbacRoles']['id'],
                ));
                if ($model) {
                    $role = $model;
                }
            }
            $role->name = $_POST['RbacRoles']['name'];
            $role->is_system = 0;
            $role->create_uid = Yii::app()->user->getId();
            $role->rightsArr = 1; // after ajax validation this flag don't needed
            if ($role->validate() && isset($_POST['RbacRoles']['rights'])) {
                $role->save();
                RbacRoleAccessRights::model()->saveRoleRights($role->id, $_POST['RbacRoles']['rights']);
                $this->redirect("/rbac/roles");
            } else if (!isset ($_POST['RbacRoles']['rights'])) {
                $tplVars['rightsError'] = "Select access right.";
            }
        }

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Personal Account')))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'rbac')))] = array('/rbac/roles');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new role'))] = '';

        $roles = RbacRoles::model()->findAll('is_system=1 or create_uid = ' . Yii::app()->user->getId());
        $rightsTree = RbackService::getAccessRightsTreeByModel(RbacAccessRights::model()
            ->findAllByAttributes(array(
                'is_system' => 0
            )));

        $tplVars['rightsTree'] = $rightsTree;
        $tplVars['roles'] = $roles;
        $tplVars['role'] = $role;

        $this->render('add_role', $tplVars);
    }

    protected function performAjaxValidation($model, $formId)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formId) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddUser()
    {

        $addUserForm = new RbacAddUserForm();
        if(Yii::app()->request->getParam('rid', '', 'int')){
            $rur = RbacUserRoles::model()->with('user')->findByAttributes(
                array(
                    'id' => Yii::app()->request->getParam('rid', '', 'int'),
                    'create_uid' => Yii::app()->user->id,
                )
            );
            if(!$rur){
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
            $addUserForm->user = $rur->user->login;
            $addUserForm->role = $rur->role_id;
            $addUserForm->account = $rur->account_id;
            $addUserForm->access_id = $rur->id;
        }
        $this->performAjaxValidation($addUserForm, 'add-user-form');

        if (isset($_POST['RbacAddUserForm'])) {
            $data = $_POST['RbacAddUserForm'];
            $addUserForm->scenario = 'save';
            $addUserForm->account = $data['account'];
            $addUserForm->user = $data['user'];
            $addUserForm->role = $data['role'];
            if(isset($data['access_id'])){
                $addUserForm->access_id = $data['access_id'];
            }
            $addUserForm->rights = isset($_POST['RbacRoles']['rights']) ? $_POST['RbacRoles']['rights'] : NULL;
            if ($addUserForm->validate()) {
                $addUserForm->save();
                $this->redirect("/rbac/manageusers");
            }
        }

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Personal Account')))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Manage Users')))] = array('/rbac/manageusers');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Adding a new user'))] = '';

        $accounts = Accounts::model()->with('user')->findAllByAttributes(array('user_id' => Yii::app()->user->id));

        if (empty($accounts)) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $roles = RbacRoles::model()->findAll('is_system=1 or create_uid = ' . Yii::app()->user->getId());

        $rightsTree = RbackService::getAccessRightsTreeByModel(RbacAccessRights::model()
            ->findAllByAttributes(array(
                'is_system' => 0
            )));

        $this->render('add_user', array(
            'accounts' => $accounts,
            'roles' => $roles,
            'rightsTree' => $rightsTree,
            'addUserForm' => $addUserForm
        ));

    }

    /**
     * @author ekazak
     * html http://xabina.dev/layout/account/user_managment.html
     */
    public function actionManageUsers()
    {

        if(Yii::app()->request->getParam('acc_id', '', 'int')){
            $account = Accounts::model()->findByAttributes(array(
                'number' => Yii::app()->request->getParam('acc_id', '', 'int'),
                'user_id' => Yii::app()->user->id,
            ));
            if(!$account){
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
            $roles = RbacUserRoles::model()->with('role')->findAllByAttributes(
                array(
                    'create_uid' => Yii::app()->user->id,
                    'account_id' => $account->id,
                )
            );
            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('manage_users/_table', array('roles' => $roles), true, false)
            ));
            Yii::app()->end();
        }

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Personal Account')))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'User Management')))] = '';

        $accounts = Accounts::model()->with('user')->findAllByAttributes(
            array('user_id' => Yii::app()->user->id)
        );
        if(!$accounts){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $selectedAcc = $accounts[0];

        $this->render('manage_users',
            array(
                'accounts' => $accounts,
                'selectedAcc' => $selectedAcc,
            ));
    }

    /**
     * @param int $id RbacRoles->id
     */
    public function actionDeleteRole($id)
    {
        $model = RbacRoles::model()->with(array('rbacRoleAccessRights', 'rbacUserRoles'))->findByAttributes(array(
            'create_uid' => Yii::app()->user->id,
            'id' => $id,
        ));
        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        echo CJSON::encode(array('success' => $model->deleteRoleWithRelations(), 'message' => Yii::t('RBAC', 'Role successfully deleted')));
    }

    public function deleteUser($id){
        $rur = RbacUserRoles::model()->findByAttributes(array(
            'id' => $id,
            'create_uid' => Yii::app()->user->id,
        ));
        if(!$rur){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $rur->deleteWithAccessRights();
    }
}