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

	public function actionDelete($notification_id){

		Users_NotificationsStatuses::model()->deleteAllByAttributes(array('notification_id'=>$notification_id));
		Users_Notifications::model()->deleteByPk($notification_id);
		//$this->redirect('/admin/notifications/manage');
	}

	public function actionUpdateStatus($status_id){

		$model = Users_NotificationsStatuses::model()->findByPk($status_id);

		if (Yii::app()->getRequest()->isAjaxRequest) {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }

		if(isset($_POST['Users_NotificationsStatuses'])){
			$model->attributes = $_POST['Users_NotificationsStatuses'];

			if ($model->save() ) {

				$this->redirect('/admin/notifications/users/notification_id/'.$model->notification_id);

			}
			echo CHtml::errorSummary($model);
		}

		$this->render('updatestatus', array('model' => $model));
	}

	public function actionView($notification_id){

		$model = Users_Notifications::model()->findByPk($notification_id);

		$this->render('view', array('model' => $model));
	}
	
	public function actionCreate($notification_id = 0){

		if(isset($_GET['checked_id'])){
			$state = Yii::app()->user->getState('notif_user_id');
			if ($state == null) $state = array();
			$state[$_GET['checked_id']] = $_GET['checked_status']=='checked';
			Yii::app()->user->setState('notif_user_id',$state);

			return;
		}


		Yii::import('application.ext.imperavi-redactor-widget.ImperaviRedactorWidget');
		Yii::import('application.ext.CJuiDateTimePicker.CJuiDateTimePicker');
		$model = new Users_Notifications();

		if (Yii::app()->getRequest()->isAjaxRequest &&  @$_GET['ajax'] != 'userList') {
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

			if ($model->validate() && !empty($_POST['userList_c0'])) {
				$model->published_at = (int)strtotime($model->published_at);

				if ($model->published_at) $_POST['Users_Notifications']['published_at'] = $model->published_at;

				$id = Users::addNotification($model->code, $model->announce, $model->type, $_POST['userList_c0'], $_POST['Users_Notifications']);

				$files = CUploadedFile::getInstancesByName('files');
				echo $folder=Yii::app()->getBasePath(true) . '/../documents/notifications/'; // folder for uploaded files
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
