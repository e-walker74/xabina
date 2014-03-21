<?php

class Mail extends CModel{
    
    const MAX_PRIORITY = 100;
    const MEDIUM_PRIORITY = 50;
    const MIN_PRIORITY = 1;
    const WORKER = 'mail send';
	const AN_WORKER = 'mail activityNotification';
    
    public function attributeNames(){
        return array('template', 'params');
    }
    
    public function send(Users $user, $template, $params = array(), $anotherEmail = false)
	{
		$mailTemplate = MailTemplates::model()->find('code = :template', array(':template' => $template));
		if(!$mailTemplate){
			Yii::log('mail template not found. code: '.$template, CLogger::LEVEL_ERROR, 'mailer');
		}
		$params['{:userFullName}'] = $user->fullName;
		$params['{:userEmail}'] = $user->email;
		$params['{:userLogin}'] = $user->login;
		$params['{:xabinaBaseUrl}'] = Yii::app()->getBaseUrl(true);
	
		$mailer = Yii::app()->mailer;
		$mailer->IsSMTP();
		$mailer->ClearAddresses();
		$mailer->AddAddress(($anotherEmail) ? $anotherEmail : $user->email);
        $mailer->FromName = $mailTemplate->fromName;
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $mailTemplate->subject;
		$mailer->SingleTo = true;
		$mailer->Mailer = 'smtp';
		$mailer->Hostname = Yii::app()->getBaseUrl(true);
		$mailer->Sender = $mailTemplate->sender;

		try {
            $mailer->getView(Yii::app()->language . '/' . $mailTemplate->template, $params);
			$result = $mailer->Send();
			if($result){
				$mailLog = new Mail_log();
				$mailLog->user_id = $user->id;
				$mailLog->template = $template;
				$mailLog->email = $user->email;
				$mailLog->save();
			}
        } catch (CException $exc) {
			$errors = array('message' => Yii::t('Front', 'Email error: {ex}', array('{ex}' => $exc->getTraceAsString())));
            Yii::log($errors['message'], CLogger::LEVEL_ERROR, 'console');
			$result = false;
        }
        
        if(!$result){
            $errors = array('message' => Yii::t('Front', 'Email not send (email = :email, template = :template)', array(':email' => $user->email, ':template' => $template)));
            Yii::log($errors['message'], CLogger::LEVEL_ERROR, 'console');
        }
        return $result;
    }
	
	public function printEmail(Users $user, $template, $params = array())
	{
		$mailTemplate = MailTemplates::model()->find('code = :template', array(':template' => $template));
		if(!$mailTemplate){
			Yii::log('mail template not found. code: '.$template, CLogger::LEVEL_ERROR, 'mailer');
		}
		$params['{:userFullName}'] = $user->fullName;
		$params['{:userEmail}'] = $user->email;
		$params['{:userLogin}'] = $user->login;
		$params['{:xabinaBaseUrl}'] = Yii::app()->getBaseUrl(true);
	
		$mailer = Yii::app()->mailer;

		$mailer->getView(Yii::app()->language . '/' . $mailTemplate->template, $params);
		//$result = $mailer->Send();
		$mailLog = new Mail_log();
		$mailLog->user_id = $user->id;
		$mailLog->template = $mailTemplate->template;
		$mailLog->body = $mailer->html;
		$mailLog->is_print = 1;
		$mailLog->save();
        
        return $mailLog->id;
    }
}