<?php

class MessagesController extends Controller
{

	public function actionIndex(){
	
		$model = new Messages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Messages'])){
			$model->attributes=$_GET['Messages'];
		}
		
		$this->render('index', array('model' => $model));
	}
	
	public function actionView($id){
		$messages = Messages::model()->findAll(array('order' => 'created_at desc', 'condition' => 'dialog_id = :gid AND draft = 0', 'params' => array(':gid' => $id)));
		if(empty($messages)){
			throw new CHttpException(404, Yii::t('Messages', 'Page not found'));
		}
		$model = Users::model()->findByPk($messages[0]->user_id);
		
		$this->render('view', array('model' => $model, 'messages' => $messages));
	}
	
	public function actionCreate(){
		$mes = new Messages();
		if($dialog_id = Yii::app()->request->getParam('dialog_id', '', 'int')){
			$messages = Messages::model()->find(array('order' => 'created_at desc', 'condition' => 'dialog_id = :gid AND draft = 0', 'params' => array(':gid' => $dialog_id)));
			
			$mes->subject_id = $messages->subject_id;
			$mes->to_id = $messages->to_id;
			$mes->dialog_id = $messages->dialog_id;
			$mes->user_id = $messages->user_id;
		} else {
			throw new CHttpException(404, Yii::t('Messages', 'Page not found'));
		}
		
		if(isset($_POST['Messages'])){
			$mes->attributes = $_POST['Messages'];
			$mes->from_id = 0;
			$mes->draft = 0;
			$mes->archive = 0;
			$mes->save();
			$this->redirect('/admin/messages/index');
		}
		
		$this->render('create', array('model' => $mes));
	}
}
