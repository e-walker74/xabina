<?php

class AccountsController extends Controller
{

	public function actionIndex(){
		$accounts = new Accounts('adminSearch');
		$accounts->unsetAttributes();  // clear any default values
		if(isset($_GET['Accounts'])){
			$accounts->attributes=$_GET['Accounts'];
		}
		
		$this->render('index', array('accounts' => $accounts));
	}
	
	public function actionActivations(){
		$activations = new Users_Activation();
		$activations->unsetAttributes();  // clear any default values
		if(isset($_GET['Users_Activation'])){
			$activations->attributes=$_GET['Users_Activation'];
		}
		$this->render('activations', array('activations' => $activations));
	}
	
	public function actionActivationUpdate($id){
		$model = Users_Activation::model()->findByPk($id);
		
		if(isset($_POST['Users_Activation'])){
			$model->description = $_POST['Users_Activation']['description'];
			$model->moderator_id = Yii::app()->user->id;
			$model->step = 4;
			if($model->save()){
				if($model->user->status == Users::USER_EMAIL_IS_ACTIVE){
					$model->user->status = Users::USER_IS_ACTIVATED;
					$model->user->save();
				}
				Yii::app()->user->addNotification(
					'vericate_your_account', //код
					'Your account has been successfully activated. We recommend you to go through a verification procedure to use your account without restrictions.', 
					'close', // возможность закрыть
					'yellow', //желтая рамка
					$model->user_id
				);
				$mail = new Mail();
				$mail->send(
					$model->user, // this user
					'activation', // sys mail code
					array(	// params
						'{:date}' => date('Y m d', time()),
					)
				);
				$this->redirect(array('/admin/accounts/activations'));
			}
		}
		
		$this->render('activations/update', array('model' => $model));
	}
	
	public function actionGetFile(){
		$user_id = Yii::app()->request->getParam('user_id', 'int');
		$name = Yii::app()->request->getParam('name', 'str');
		$model = Users_Files::model()->find('user_id = :user_id AND name = :name', array(':user_id' => $user_id, ':name' => $name));
		
		if(!$model){
			throw new CHttpException(404, Yii::t('Admin', 'Page not found'));
		}
		$file=Yii::app()->getBasePath(true) . '/../../documents/'.$user_id.'/'.$model->name;
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
		}
	}
}
