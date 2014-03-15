<?php

class UsersController extends Controller
{

	public function actionCreate(){
		$model=new Users;
		$model->scenario = 'adminCreate';
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(!empty($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if(!$model->email && !$model->login){
				$model->addError('login', Yii::t('Users', 'Email and Login is empty'));
			}elseif($model->email && !$model->login){
				$model->login = $model->email;
			}
			
			$pass = substr(md5(time() . 'xabina_pass' . $model->login), 2, 8);
			$model->role = 1;
			$model->status = Users::USER_IS_NOT_ACTIVE;
			$model->createHash();
			$model->password = md5($pass);
			if(!$model->email){
				unset($model->email);
			}

			if(!count($model->getErrors()) && $model->validate() && $model->save()){
				if($model->email){
					$mail = new Mail();
					if($mail->send(
						$model, // this user
						'registrationsFromAdmin', // sys mail code
						array(	// params
							'{:userPassword}' => $pass,
							'{:date}' => date('Y m d', $model->created_at),
							'{:activateUrl}' => Yii::app()->getBaseUrl(true).'/emailconfirm/'.$model->hash,
						)
					)){
						$result = true;
					} else {
						Yii::log('registration fail '.print_r($model->attributes, 1), CLogger::LEVEL_ERROR, 'error');
						$model->delete();
					}
				} else {
					$mail = new Mail();
					$mail_id = $mail->printEmail(
						$model, // this user
						'registrationsFromAdmin', // sys mail code
						array(	// params
							'{:userPassword}' => $pass,
							'{:date}' => date('Y m d', $model->created_at),
							'{:activateUrl}' => Yii::app()->getBaseUrl(true).'/emailconfirm/'.$model->hash,
						)
					);
					$this->redirect(array('/admin/users/printEmail', 'id' => $mail_id));
				}
				
				$this->redirect(array('/admin/users/update', 'id' => $model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionPrintEmail($id){
		$mail = Mail_log::model()->findByPk($id);
		echo $mail->body;
		Yii::app()->end();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		//$model->scenario = 'admin';
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(!$model->profile){
			$profile = new Users_Profile();
			$profile->user_id = $model->id;
			$model->profile = $profile;
			$model->profile->save();
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save()){
				$this->redirect(array('/admin/users/admin/'));
			}
		}
		
		$accounts = new Accounts('search');
		$accounts->unsetAttributes();  // clear any default values
		if(isset($_GET['Accounts'])){
			$accounts->attributes=$_GET['Accounts'];
		}
		$accounts->user_id = $model->id;
		
		$logs = new Users_Log('search');
		$logs->unsetAttributes();  // clear any default values
		if(isset($_GET['Users_Log'])){
			$logs->attributes=$_GET['Users_Log'];
		}
		$logs->user_id = $model->id;
		
		$this->render('update',array(
			'model'=>$model,
			'accounts' => $accounts,
			'logs' => $logs,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users'])){
			$model->attributes=$_GET['Users'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
