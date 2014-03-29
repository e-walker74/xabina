<?php

class WebUser extends CWebUser {

    public $defaultRole;
	private $_notifications = false;
    private $_model = null;
    private $_id = null;
	
    private function _getModel() {
        if (!$this->isGuest && $this->_model === null && $this->id) {
            $this->_model = Users::model()->findByPk($this->id /* array('select' => 'role') */);
        }
        return $this->_model;
    }
	
	public function getNotifications(){
		if($this->_notifications !== false){
			return $this->_notifications;
		}
		if($this->getId() !== null ){
			$this->_model = $this->_getModel();
			$arr = array();
			foreach($this->_model->notifications_active as $notify){
				$arr[$notify->id] = $notify;
			}
			$this->_notifications = $arr;
			return $this->_notifications;
		}
        else
            return $this->_notifications;
	}
	
	public function addNotification($code, $message, $type = 'close', $style = 'green', $user_id = false){
		if(!$user_id){
			$user_id = Yii::app()->user->id;
		}
		if($this->getId() !== null ){
			$notify = Users_Notification::model()->find('code = :code AND user_id = :uid AND closed = 0', array(
				'code' => $code,
				':uid' => $user_id,
			));
			if($notify){
				return false;
			}
			$this->_model = $this->_getModel();
			$notify = new Users_Notification();
			$notify->user_id = $user_id;
			$notify->code = $code;
			$notify->message = $message;
			$notify->type = $type;
			$notify->style = $style;
			if($notify->save()){
				$this->_notifications = false;
				return true;
			}
			return false;
		}
        else
            return false;
	}
	
	public function removeNotification($code){
		if($this->getId() !== null ){
			$this->_model = $this->_getModel();
			$notifies = Users_Notification::model()->findAll('code = :code AND user_id = :ui', array(':code' => $code, ':ui' => $this->_model->id));
			foreach($notifies as $notify){
				$notify->closed = 1;
				if($notify->save()){
					$this->_notifications = false;
				}
			}
			return true;
		}
        else
            return false;
	}

    /**
     * Returns the unique identifier for the user (e.g. username).
     * This is the unique identifier that is mainly used for display purpose.
     * @return string the user name. If the user is not logged in, this will be {@link guestName}.
     */
    public function getRole() {
        if (($name = $this->getState('__role')) !== null)
            return $name;
		
		if($this->getId() !== null ){
			Yii::log(array('user_id' => $this->getId(), 'action' => 'getRole'), CLogger::LEVEL_ERROR, 'webUser');
			$this->_model = $this->_getModel();
			$this->setRole($this->model->role);
			return $this->getRole();
		}
        else
            return $this->defaultRole;
    }

	public function getEmail() {
        if (($name = $this->getState('__email')) !== null)
            return $name;
		
		if($this->getId() !== null){
			Yii::log(array('user_id' => $this->getId(), 'action' => 'getEmail'), CLogger::LEVEL_ERROR, 'webUser');
			$this->_model = Users::model()->findByPk($this->getId(), array('select' => 'email'));
			$this->setEmail($this->_model->email);
			return $this->getEmail();
		}
        else
            return false;
    }

	public function getPhone() {
        if (($name = $this->getState('__phone')) !== null)
            return $name;
		
        if($this->getId() !== null){
			Yii::log(array('user_id' => $this->getId(), 'action' => 'getPhone'), CLogger::LEVEL_ERROR, 'webUser');
			$this->_model = Users::model()->findByPk($this->getId(), array('select' => 'phone'));
			$this->setPhone($this->_model->phone);
			return $this->getPhone();
		}
        else
            return false;
    }
	
	public function getStatus() {
        if (($name = $this->getState('__status')) !== null)
            return $name;
		
        if($this->getId() !== null){
			Yii::log(array('getStatus' => $this->getId(), 'action' => 'getStatus'), CLogger::LEVEL_ERROR, 'webUser');
			$this->_model = Users::model()->findByPk($this->getId(), array('select' => 'status'));
			$this->setStatus($this->_model->status);
			return $this->getStatus();
		}
        else
            return false;
    }
	
	public function getLastIp(){
		if (($name = $this->getState('__last_ip')) !== null)
            return $name;
			
		return '';
	}
	
	public function getLastTime(){
		if (($name = $this->getState('__last_time')) !== null)
            return $name;
			
		return '';
	}

    /**
     * Sets the unique identifier for the user (e.g. username).
     * @param string $value the user name.
     * @see getName
     */
    public function setRole($value) {
        $this->setState('__role', $value);
    }
	
	public function setEmail($value) {
        $this->setState('__email', $value);
    }
	
	public function setPhone($value) {
        $this->setState('__phone', $value);
    }
	
	public function setLastIp($value) {
        $this->setState('__last_ip', $value);
    }
	
	public function setLastTime($value) {
        $this->setState('__last_time', $value);
    }
	
	public function setStatus($value) {
        $this->setState('__status', $value);
    }

    public function login($identity, $duration = 0) {
        $this->id = $identity->getId();
        $user = $this->_getModel();

        $this->setRole($user->role);
		$this->setEmail($user->email);
		$this->setPhone($user->phone);
		$this->setStatus($user->status);
		
		$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
		$country = $SxGeo->getCountry(CHttpRequest::getUserHostAddress());
		$log = new Users_Log;
		$log->region = $country;
		$log->type = 'login';
		$log->user_id = $user->id;
		$log->save();

		if($user->last_auth){
			$this->setLastIp($user->last_auth->ip_address);
			$this->setLastTime($user->last_auth->created_at);
		}
		
        parent::login($identity);
		
    }

	public function logout(){
		$user = $this->_getModel();
	
		$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
		$country = $SxGeo->getCountry(CHttpRequest::getUserHostAddress());
		$log = new Users_Log;
		$log->region = $country; 
		$log->type = 'logout';
		$log->user_id = $user->id;
		$log->save();
	
		parent::logout();
	}
}