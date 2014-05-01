<?php

class PersonalController extends Controller
{

	public function actionDocuments(){
		$files = Users_Files::model()->with('personal_document')->findAll(
			array('condition' => 'form = "Users_Personal_Edit"', 'order' => 't.created_at desc')
		);
		
		$model = new Users_Files();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users_Files'])){
			$model->attributes=$_GET['Users_Files'];
		}
		$model->form = 'Users_Personal_Edit';
		
		$this->render('index', array('model' => $model));
	}
	
	public function actionUpdate($id){
		$model = Users_Files::model()->findByPk($id);
		
		if(!$model->personal_document){
			$model->personal_document = new Users_Personal_Documents;
		}
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Users_Personal_Documents'])){
			$model->personal_document->attributes = $_POST['Users_Personal_Documents'];
			$model->personal_document->expiry_date = (time() + rand(3600*24, 3600*24*365)); //TODO for test
			$model->personal_document->file_id = $id;
			$model->personal_document->user_id = $model->user_id;
			if($model->personal_document->save()){
				$this->redirect(array('/admin/personal/documents'));
			}
		}
		
		$this->render('update', array('model' => $model->personal_document));
		
	}

}