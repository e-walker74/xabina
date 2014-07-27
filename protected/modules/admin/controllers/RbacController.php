<?php

class RbacController extends Controller
{

    public function actionIndex(){
        $model = new RbacRoles('search');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RbacRoles'])){
			$model->attributes=$_GET['RbacRoles'];
		}
		$model->create_uid = 0;
		
		$this->render('index', array('model' => $model));
    }

	public function actionUpdate($id){
		$rights = RbacAccessRights::model()->getRightTree();

        $model = RbacRoles::model()->findByPk($id);

        if(isset($_POST['rights'])){
			RbacRoleAccessRights::model()->deleteAll('role_id = :rid', array(':rid' => $id));
			foreach($_POST['rights'] as $rightId => $val){
				$access = new RbacRoleAccessRights;
				$access->role_id = $model->id;
				$access->access_right_id = $rightId;
				$access->save();
			}
		}

        $checkedArr = array();
        foreach($model->rbacRoleAccessRights as $access){
            $checkedArr[] = $access->access_right_id;
        }

		$this->render('update', array('model' => $model, 'rights' => $rights, 'checkedArr' => $checkedArr));
	}
	
}