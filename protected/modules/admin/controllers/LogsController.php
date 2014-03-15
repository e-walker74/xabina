<?php

class LogsController extends Controller
{

	public function actionMail(){
		$mail = new Mail_Log('search');
		$mail->unsetAttributes();  // clear any default values
		if(isset($_GET['Mail_Log'])){
			$mail->attributes=$_GET['Mail_Log'];
		}
		
		$this->render('mail', array('mail' => $mail));
	}
	
	public function actionUsers(){
		$logs = new Users_Log('search');
		$logs->unsetAttributes();  // clear any default values
		if(isset($_GET['Users_Log'])){
			$logs->attributes=$_GET['Users_Log'];
		}
		
		$this->render('users', array('logs' => $logs));
	}
}
