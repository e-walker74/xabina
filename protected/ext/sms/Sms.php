<?php

class SMS extends CComponent
{

	private $_destination = false;
	private $_body = false;
	private $_operation = false;

	public $login;
	public $password;
	public $sendUrl;
	public $sender;
	public $route;
	public $allowlong;
	
	public function init(){
		require_once('autoload.php');
	}
	
	public function to($number){
		$this->_destination = trim(trim($number), '+');
		return $this;
	}
	
	public function body($text, $params = array()){
		$this->_body = Yii::t('Sms', $text, $params);
		return $this;
	}
	
	public function send(){
	
		$MessageBird = new \MessageBird\Client($this->password);

        $Message = new \MessageBird\Objects\Message();
        $Message->originator = $this->sender;
        $Message->recipients = array($this->_destination);
        $Message->body = $this->_body;

		Yii::log(print_r($MessageBird->messages->create($Message), 1), CLogger::LEVEL_ERROR, 'sms');
		return 1;
		$this->_operation = 'send';
		$data = $this->generateRquest();
		// application/xwww8form8urlencoded
		$ch = curl_init($this->sendUrl);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;

		//'&USERNAME=********&PASSWORD=********&DESTINATION=316********&SENDER=Spryng&ROUTE=BUSINESS&BODY=test&ALLOWLONG=1'
	}
	
	public function getTemplate(){
		
	}
	
	public function generateRquest(){
		$data = array();
		$data['OPERATION'] = $this->_operation;
		$data['USERNAME'] = $this->login;
		$data['PASSWORD'] = $this->password;
		$data['DESTINATION'] = $this->_destination;
		$data['SENDER'] = $this->sender;
		$data['ROUTE'] = $this->route;
		$data['BODY'] = $this->_body;
		$data['ALLOWLONG'] = $this->allowlong;
		foreach($data as $key => $value){
			if(!$value){
				throw new CHttpException(404, 'Param '.$key.' not send');
			}
		}
		//$data = http_build_query($data);
		return $data;
	}
}