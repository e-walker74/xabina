<?php

class MailerController extends Controller
{

	public function actionMails(){
		$mails = MailTemplates::model();
		$templates = MailerService::getTemplates();
		$this->render('mails', array('mails' => $mails, 'templates' => $templates));
	}
	
	public function actionUpdate($id){
		$mail_template = MailTemplates::model()->findByPk($id);

		if(isset($_POST['MailTemplates'])){
			$mail_template->attributes = $_POST['MailTemplates'];
			if($mail_template->save())
				$this->redirect(array('/admin/mailer/mails'));
		}
		$templates = MailerService::getTemplates();
		$this->render('update', array('model' => $mail_template, 'templates' => $templates['workFiles']));
	}
}
