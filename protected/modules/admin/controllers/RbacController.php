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
		$rights = RbacAccessRights::model()->findAll('action_id is not null');
		
		$model = RbacRoles::model()->findByPk($id);
		
		if(isset($_POST['rights'])){
			RbacRoleAccessRights::model()->deleteAll('role_id = :rid', array(':rid' => $id));
			foreach($_POST['rights'] as $rightId => $val){
				$access = new RbacRoleAccessRights;
				$access->role_id = 5;
				$access->acces_right_id = $rightId;
				$access->save();
			}
		}
		
		$this->render('update', array('model' => $model, 'rights' => $rights));
	}
	
}