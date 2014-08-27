<?php

class NotificationsController extends Controller
{

	public function actionManage(){
	
		$model = new Users_Notifications('search');
		$this->render('manage', array('model' => $model));
	}

	public function actionUsers($notification_id){

		$model = new Users_NotificationsStatuses('admin');
		$model->notification_id = $notification_id;

		$this->render('users', array('model' => $model));
	}
	
	public function actionCreate($notification_id = 0){

		Yii::import('application.ext.imperavi-redactor-widget.ImperaviRedactorWidget');
		Yii::import('application.ext.CJuiDateTimePicker.CJuiDateTimePicker');
		$model = new Users_Notifications();

		if (Yii::app()->getRequest()->isAjaxRequest) {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if ($notification_id > 0 && !isset($_POST['Users_Notifications'])) {
			$notify = Users_Notifications::model()->findByPk($notification_id);
			$notify->id = null;
			$notify->published_at = null;
			$model->attributes = $notify->attributes;
		}

		if(isset($_POST['Users_Notifications'])){
			$model->attributes = $_POST['Users_Notifications'];

			if ($model->validate() && !empty($_POST['user_id'])) {
				$model->published_at = (int)strtotime($model->published_at);
				if ($model->published_at) $_POST['Users_Notifications']['published_at'] = $model->published_at;

				$id = Users::addNotification($model->code, $model->announce, $model->type, $_POST['user_id'], $_POST['Users_Notifications']);

				$files = CUploadedFile::getInstancesByName('files');
				echo $folder=Yii::app()->getBasePath(true) . '/../../documents/notifications/'; // folder for uploaded files
				@mkdir ( $folder, 0777, 1);
				foreach ($files as $file) {
					$name = md5(time()).'.'.$file->getExtensionName();
					$file->saveAs($folder.$name);
					$fileModel = new Users_NotificationsFiles();
					$fileModel->notification_id = $id;
					$fileModel->file = $name;
					$fileModel->save();
				}
				$this->redirect('/admin/notifications/manage');

			}
			echo CHtml::errorSummary($model);
		}
		
		$this->render('create', array('model' => $model));
	}
}
