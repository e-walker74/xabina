<?php

/**
 * Class AjaxController
 * For all common ajax requests
 */
class AjaxController extends Controller
{

    public $layout = '';
    public $title  = '';

    /**
     *  Ajax request countries autocomleate action
     *
     */
    public function actionCountryAutoComplete() {

        if (isset($_GET['q'])) {

            $criteria = new CDbCriteria;
            $criteria->addSearchCondition('name', $_GET['q'].'%', false);
            if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
                $criteria->limit = $_GET['limit'];
            }

            $countries = countries::model()->findAll($criteria);

            $resStr = '';
            foreach ($countries as $country) {
                $resStr .= $country->name."\n";
            }
            echo $resStr;
        }
    }

    public function actionGetRoleRights($roleId) {
        $rights = RbacRoleAccessRights::model()->with('role')->findAll(
            array(
                'condition' => 't.role_id = :rid AND role.create_uid = :cuid',
                'params' => array(
                    ':rid' => Yii::app()->request->getParam('roleId', '', 'int'),
                    ':cuid' => Yii::app()->user->id,
                ),
            )
        );
        echo CJSON::encode($rights);
	}

    public function actionSetManagerWidgetState() {
        if (isset($_GET['state'])) {
            $model = new UsersPersonalManagers();
            $model->updateAll(array('widget_state' => $_GET['state']),'user_id="'.Yii::app()->user->id.'"');
        }
    }

    public function actionGetManagerWidgetState() {
        $model = new UsersPersonalManagers();
        $ret = $model->find('user_id = '.Yii::app()->user->id);
        echo $ret['widget_state'];
    }

    public function actionGetUserRights() {
        $addUserForm = new RbacAddUserForm();
        if(isset($_GET['RbacAddUserForm'])){
            $addUserForm->attributes = $_GET['RbacAddUserForm'];
            if($addUserForm->validate()){

                $query = "SELECT
                t.*,
                account.number
                FROM `rbac_user_access_rights` `t`
                LEFT OUTER JOIN `users` `user` ON (`t`.`user_id`=`user`.`id`)
                LEFT OUTER JOIN `accounts` `account` ON (`t`.`account_id`=`account`.`id`)
                LEFT OUTER JOIN `rbac_roles` `role` ON (`t`.`role_id`=`role`.`id`)
                WHERE (
                t.role_id = {$addUserForm->role}
                AND role.create_uid = ".Yii::app()->user->id."
                AND account.number = {$addUserForm->account}
                AND user.login = {$addUserForm->user}
                )";

                $command = Yii::app()->db->createCommand($query);
                echo CJSON::encode($command->queryAll());
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array('success' => false));

    }
}