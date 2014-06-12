<?php

class RbacController extends Controller
{

    public $layout = 'banking';
    public $title  = '';
	
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

        $roles = RbacRoles::model()->findAllByAttributes(
            array(
                'create_uid' => Yii::app()->user->getId(),
            )
        );
        $this->render('roles_management', array('roles' => $roles));
    }
    
    protected function performAjaxValidation($model, $formId)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']===$formId)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAddRole() {
        
        $role = new RbacRoles();
        $this->performAjaxValidation($role, 'add-role-form');
        $tplVars = array();
        
        if(isset($_POST['RbacRoles'])) {
            
            $role->name = $_POST['RbacRoles']['name'];
            $role->is_system = 0;
            $role->create_uid = Yii::app()->user->getId();
            if($role->validate() && isset($_POST['RbacRoles']['rights']) ) {
                $role->save();
                if( RbacRoleAccessRights::model()->saveRoleRights($role->id, $_POST['RbacRoles']['rights']) ) {
                    $this->redirect("/settings/roles");
                };
            } else if (!isset ($_POST['RbacRoles']['rights'])) {
                $tplVars['rightsError'] = "Select access right.";
            }
        }

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Personal Account')))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'rbac')))] = array('/rbac/roles');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new role'))] = '';

        $roles = RbacRoles::model()->findAll('is_system=1 or create_uid = ' . Yii::app()->user->getId());
        $rightsTree = RbacAccessRights::model()->getAccessRightsTree();

        $tplVars['rightsTree'] = $rightsTree;
        $tplVars['roles']      = $roles;
        $tplVars['role']       = $role;

        $this->render('add_role', $tplVars);
    }
    
    public function actionAddUser() {

        $addUserForm = new RbacAddUserForm();
        $this->performAjaxValidation($addUserForm, 'add-user-form');
        
        if(isset($_POST['RbacAddUserForm'])) {
            $data = $_POST['RbacAddUserForm'];
            $addUserForm->scenario = 'save';
            $addUserForm->account = $data['account'];
            $addUserForm->user    = $data['user'];
            $addUserForm->role    = $data['role'];
            $addUserForm->rights  = isset($_POST['RbacRoles']['rights']) ? $_POST['RbacRoles']['rights'] : NULL;
            if($addUserForm->validate()) {
                $addUserForm->save();
                $this->redirect("/settings/roles");
            }
        }

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'Personal Account')))] = array('/personal/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', Yii::t('Front', 'rbac')))] = array('/rbac/roles');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Adding a new user'))] = '';

        $accounts = Accounts::model()->with('user')->findAllByAttributes(array('user_id' => Yii::app()->user->id));

        if (empty($accounts)) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $selectedAcc = NULL;
        if ($accountNumber = Yii::app()->request->getParam('account', false, 'int')) {
            $selectedAcc = Accounts::model()->currentUser()->find('number = :number', array(':number' => $accountNumber));
        } elseif (!$selectedAcc) {
            $selectedAcc = $accounts[0];
        }

        $roles = RbacRoles::model()->findAll('is_system=1 or create_uid = ' . Yii::app()->user->getId());

        $rightsTree = RbackService::getAccessRightsTreeByModel(RbacAccessRights::model()
            ->findAllByAttributes(array(
                'is_system' => 0
            )));

        $this->render('add_user', array(
            'accounts' => $accounts,
            'selectedAcc' => $selectedAcc,
            'roles' => $roles,
            'rightsTree' => $rightsTree,
            'addUserForm' => $addUserForm
        ));

    }
}