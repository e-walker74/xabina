<?php

class WebUser extends CWebUser {

    public $defaultRole;
	private $_notifications = false;
    private $_model = null;
    private $_id = null;

    private function _getModel() {
        if (!$this->isGuest && $this->_model === null && $this->id) {
            $this->_model = Admins::model()->findByPk($this->id /* array('select' => 'role') */);
        }
        return $this->_model;
    }

	public function getLastIp(){
		if (($name = $this->getState('__last_ip')) !== null)
            return $name;

		return '';
	}

	public function getThisIp() {
		if (($name = $this->getState('__this_ip')) !== null)
            return $name;

		return '';
    }

	public function getLastTime(){
		if (($name = $this->getState('__last_time')) !== null)
            return $name;

		return '';
	}


	public function setLastIp($value) {
        $this->setState('__last_ip', $value);
    }

	public function setThisIp($value) {
        $this->setState('__this_ip', $value);
    }

	public function setLastTime($value) {
        $this->setState('__last_time', $value);
    }

    public function login($identity, $duration = 0) {
        $this->id = $identity->getId();
        $user = $this->_getModel();

		$this->setThisIp(ip2long(CHttpRequest::getUserHostAddress()));

		$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
		$country = $SxGeo->getCountry(CHttpRequest::getUserHostAddress());
		$log = new Admin_Users_Log;
		$log->region = $country;
		$log->type = 'login';
		$log->user_id = $user->id;
		$log->save();

		/*if($user->last_auth){
			$this->setLastIp($user->last_auth->ip_address);
			$this->setLastTime($user->last_auth->created_at);
		}*/

        parent::login($identity);

    }

	public function logout(){
		$user = $this->_getModel();

		$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
		$country = $SxGeo->getCountry(CHttpRequest::getUserHostAddress());
		$log = new Admin_Users_Log;
		$log->region = $country;
		$log->type = 'logout';
		$log->user_id = $user->id;
		$log->save();

		parent::logout();
	}
}