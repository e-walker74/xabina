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
        $rights = RbacRoleAccessRights::model()->findAll('role_id='. intval($roleId));
        echo CJSON::encode($rights);
    }
}