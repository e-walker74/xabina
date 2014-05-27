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

		$this->_notifications = false;
		
		Users::addNotification($code, $message, $type, $style, $user_id);
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

    /********************** GETTERS *************************/

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
			$this->setRole(Users::$roles[$this->model->role]);
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

    /**
     * Getting user language
     * by default user language from users settings
     * @return null|string
     */
    public function getLanguage(){
        if (($name = $this->getState('__language')) !== null)
            return $name;

        return '';
    }

    /**
     * Getting user font size
     * by default user font size from users settings
     * @return null|string
     */
    public function getFontSize(){
        if (($name = $this->getState('__font_size')) !== null)
            return $name;

        return '';
    }

    /************* SETTERS **************/

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
	
	public function setThisIp($value) {
        $this->setState('__this_ip', $value);
    }
	
	public function setLastTime($value) {
        $this->setState('__last_time', $value);
    }
	
	public function setStatus($value) {
        $this->setState('__status', $value);
    }

    public function setLanguage($value){
        $this->setState('__language', $value);
        return $this;
    }

    public function setFontSize($value){
        $this->setState('__font_size', $value);
        return $this;
    }

    public function login($identity, $duration = 0) {
        $this->id = $identity->getId();
        $user = $this->_getModel();

        $this->setRole(Users::$roles[$user->role]);
		$this->setEmail($user->email);
		$this->setPhone($user->phone);
		$this->setStatus($user->status);
		$this->setThisIp(ip2long(CHttpRequest::getUserHostAddress()));
		$this->setLanguage($user->settings->language);
        $this->setFontSize($user->settings->font_size);
        $this->setFullName($user->getFullName());

		$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
		$country = $SxGeo->getCountry(CHttpRequest::getUserHostAddress());
		$log = new Users_Log;
		$log->region = $country;
		$log->type = 'login';
		$log->user_id = $user->id;
		$log->save();
		
        $this->initRback();

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

    public function getFullName()
    {
		if(($name=$this->getState('__full_name'))!==null)
			return $name;
		else
			return $this->guestName;
	}
    
    public function setFullName($fullName)
    {
		$this->setState('__full_name', $fullName);
	}
    
    
    /**
     * Download access rights for user
     */
    public function initRback() {
        $user = $this->_getModel();
        $settings = $user->getRbacSettings($this->getRbacCurrentUid());
        $accounts = $user->getRbacAllowedAccounts();
        $this->setState('__rbac', $settings);
        $this->setState('__rbac_allowed_accounts', $accounts);
    }

    public function getRbac() {
        if($this->getState('__rbac') == NULL) {
            $this->initRback();
        }
        return $this->getState('__rbac');
    }
    
    public function getRbacAllowedAccounts() {
        if($this->getState('__rbac_allowed_accounts') == NULL) {
            $this->initRback();
        }
        return $this->getState('__rbac_allowed_accounts');
    }
    
    public function getRbacCurrentUid() {
        return $this->getState('__rbac_current_uid');
    }
    
    public function setRbacCurrentUid($uid) {
        $this->setState('__rbac_current_uid', $uid);
    }
    
    public function switchRbacAccount($uid = NULL) {
        $this->setRbacCurrentUid($uid);
        $this->initRback();
    }
    
    
    
    /**
     * check if user has access to Controller.Action
     */
    public function checkRbacAccess($ca) {
        $rights = $this->getRbac();
        foreach ((array)$rights as $right) {
            if($this->actionAllowed($ca, $right['action_id'])) {
                return true;
            }
        }
        return false;
    }

    private function actionAllowed($controllerAction, $accessRight) {
        
        $res = false;
        
        $a = explode('.', $controllerAction);
        $b = explode('.', $accessRight);

        if($a[0] == $b[0] && $a[1] == $b[1]) {
            $res = true;
        } 
        elseif($a[0] == $b[0] && $b[1] == '*') {
            $res = true;
        }
        
        return $res;
    }
}
