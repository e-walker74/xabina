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
    
    public function actionGetRoleRights($roleId) {
        $rights = RbacRoleAccessRights::model()->findAllByAttributes(array('role_id' => intval($roleId)));
        echo CJSON::encode($rights);
    }
}