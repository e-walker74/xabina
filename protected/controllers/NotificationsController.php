<?php

class NotificationsController extends Controller
{
    public $layout = 'banking';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow',
                'actions' => array(
                    'index','getfile'
                ),
                'roles' => array('client')
            ),
            array('deny',
                'users' => array('*')
            ),
        );
    }
	


    public function actionIndex()
    {
		$this->breadcrumbs[Yii::t('Front', 'Notifications')] = '';
        $model = new Users_NotificationsStatuses('search');

		if(isset($_GET['Users_NotificationsStatuses']))
        	$model->attributes=$_GET['Users_NotificationsStatuses'];

		$model->user_id = Yii::app()->user->id;
        Yii::app()->clientScript->registerScriptFile('/js/jquery.lavalamp.js');
        Yii::app()->clientScript->registerScriptFile('/js/accounts.js');
        Yii::app()->clientScript->registerScriptFile('/js/notifications.js', CClientScript::POS_END);

		$this->render('index',array(
			'model'=>$model,
		));

//		$items = $model->search()->getData();
//		foreach($items as $item) {
//			if($item->status != Users_NotificationsStatuses::STATUS_DONE && in_array($item->message->type, array(Users_Notifications::TYPE_PROMOTION, Users_Notifications::TYPE_INFORMATION ))){
//				$item->status = Users_NotificationsStatuses::STATUS_DONE;
//				$item->save();
//			}
//		}
    }

	public function actionGetFile($id){

		$model = Users_NotificationsFiles::model()->findByPk($id);
		$status = Users_NotificationsStatuses::model()->findByAttributes(array('user_id'=>Yii::app()->user->id, 'notification_id'=>$model->notification_id));

		if ($status === null)
            throw new CHttpException(404, Yii::t('Font', 'Page not found'));

		$file=Yii::app()->getBasePath(true) . '/../documents/notifications/'.$model->file;
		if (file_exists($file)) {
			// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
			// если этого не сделать файл будет читаться в память полностью!
			if (ob_get_level()) {
			  ob_end_clean();
			}
			// заставляем браузер показать окно сохранения файла
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			// читаем файл и отправляем его пользователю
			if ($fd = fopen($file, 'rb')) {
				while (!feof($fd)) {
					print fread($fd, 1024);
				}
				fclose($fd);
			}
			exit;
		} else {
			 throw new CHttpException(404, Yii::t('Font', 'Page not found'));
		}
	}

    public function loadModel($id)
    {
        $model = Messages::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('Font', 'Page not found'));
        return $model;
    }

}