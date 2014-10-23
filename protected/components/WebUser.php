<?php

class WebUser extends CWebUser
{

    public $defaultRole;
    private $_notifications = false;
    private $_model = null;
    private $_id = null;

    /**
     * Updates the authentication status according to {@link authTimeout}.
     * If the user has been inactive for {@link authTimeout} seconds, or {link absoluteAuthTimeout} has passed,
     * he will be automatically logged out.
     * @since 1.1.7
     */
    protected function updateAuthStatus()
    {
        if(($this->authTimeout!==null || $this->absoluteAuthTimeout!==null) && !$this->getIsGuest())
        {
            $expires=$this->getState(self::AUTH_TIMEOUT_VAR);
            $expiresAbsolute=$this->getState(self::AUTH_ABSOLUTE_TIMEOUT_VAR);

            if ($expires!==null && $expires < time() || $expiresAbsolute!==null && $expiresAbsolute < time())
                $this->logout(false);
            elseif(!Yii::request()->isAjaxRequest)
                $this->setState(self::AUTH_TIMEOUT_VAR,time()+$this->authTimeout);
        }
    }

    public function getNotifications()
    {
        if ($this->_notifications !== false) {
            return $this->_notifications;
        }
        if ($this->getId() !== null) {
            $this->_model = $this->_getModel();
            $arr = array();
            foreach ($this->_model->notifications_active as $notify) {
                $arr[$notify->id] = $notify;
            }
            $this->_notifications = $arr;
            return $this->_notifications;
        } else
            return $this->_notifications;
    }

    /**
     * @return Users
     */
    private function _getModel($refresh = false)
    {
        if ((!$this->isGuest && $this->_model === null && $this->id) || $refresh) {
            $this->_model = Users::model()->findByPk($this->id /* array('select' => 'role') */);
        }
        return $this->_model;
    }

    public function addNotification($code, $message, $type = Users_Notifications::TYPE_NOTE, $user_id = false, $attributes = array())
    {
        if (!$user_id) {
            $user_id = Yii::app()->user->id;
        }

        $this->_notifications = false;

        Users::addNotification($code, $message, $type, $user_id, $attributes);
    }

    public function removeNotification($code)
    {
        if ($this->getId() !== null) {
            $this->_model = $this->_getModel();
            $notifies = Users_Notification::model()->findAll('code = :code AND user_id = :ui', array(':code' => $code, ':ui' => $this->_model->id));
            foreach ($notifies as $notify) {
                $notify->closed = 1;
                if ($notify->save()) {
                    $this->_notifications = false;
                }
            }
            return true;
        } else
            return false;
    }

    /********************** GETTERS *************************/

    /**
     * Returns the unique identifier for the user (e.g. username).
     * This is the unique identifier that is mainly used for display purpose.
     * @return string the user name. If the user is not logged in, this will be {@link guestName}.
     */
    public function getRole()
    {
        if (($name = $this->getState('__role')) !== null)
            return $name;

        if ($this->getId() !== null) {
            Yii::log(array('user_id' => $this->getId(), 'action' => 'getRole'), CLogger::LEVEL_ERROR, 'webUser');
            $this->_model = $this->_getModel();
            $this->setRole(Users::$roles[$this->model->role]);
            return $this->getRole();
        } else
            return $this->defaultRole;
    }

    /**
     * Sets the unique identifier for the user (e.g. username).
     * @param string $value the user name.
     * @see getName
     */
    public function setRole($value)
    {
        $this->setState('__role', $value);
    }

    public function getEmail()
    {
        if (($name = $this->getState('__email')) !== null)
            return $name;

        if ($this->getId() !== null) {
            //Yii::log(array('user_id' => $this->getId(), 'action' => 'getEmail'), CLogger::LEVEL_ERROR, 'webUser');
            $this->_model = $this->_getModel();
            $this->setEmail($this->_model->email);
            return $this->getEmail();
        } else
            return false;
    }

    public function setEmail($value)
    {
        $this->setState('__email', $value);
    }

    public function setPhotoUrl($value)
    {
        $this->setState('__photo_url', $value);
    }

    public function getPhone()
    {
        if (($name = $this->getState('__phone')) !== null)
            return $name;

        if ($this->getId() !== null) {
            //Yii::log(array('user_id' => $this->getId(), 'action' => 'getPhone'), CLogger::LEVEL_ERROR, 'webUser');
            $this->_model = Users::model()->findByPk($this->getId(), array('select' => 'phone'));
            $this->setPhone($this->_model->phone);
            return $this->getPhone();
        } else
            return false;
    }

    public function setPhone($value)
    {
        $this->setState('__phone', $value);
    }

    public function getTimeZone($refresh = false){
        if (($name = $this->getState('__time_zone')) !== null && !$refresh)
            return $name;

        if ($this->getId() !== null) {
            //Yii::log(array('getTimezone' => $this->getId(), 'action' => 'getTimezone'), CLogger::LEVEL_ERROR, 'webUser');

            $model = $this->_getModel($refresh);
            $this->setTimeZone($model->settings->time_zone->zone_name);
            return $this->getTimeZone();
        } else
            return false;
    }

    public function getPhotoUrl($refresh = false){
        if (($name = $this->getState('__photo_url')) !== null && !$refresh)
            return $name;

        if ($this->getId() !== null) {
            //Yii::log(array('getPhotoUrl' => $this->getId(), 'action' => 'getPhotoUrl'), CLogger::LEVEL_ERROR, 'webUser');

            $model = $this->_getModel($refresh);
            $this->setPhotoUrl($model->getPhotoUrl());
            return $model->getPhotoUrl();
        } else
            return false;
    }

    public function getStatus()
    {
        if (($name = $this->getState('__status')) !== null)
            return $name;

        if ($this->getId() !== null) {
            //Yii::log(array('getStatus' => $this->getId(), 'action' => 'getStatus'), CLogger::LEVEL_ERROR, 'webUser');
            $this->_model = Users::model()->findByPk($this->getId());
            $this->setStatus($this->_model->status);
            return $this->getStatus();
        } else
            return false;
    }

    public function setStatus($value)
    {
        $this->setState('__status', $value);
    }

    public function getLastIp()
    {
        if (($name = $this->getState('__last_ip')) !== null)
            return $name;

        return '';
    }

    /************* SETTERS **************/

    public function getThisIp()
    {
        if (($name = $this->getState('__this_ip')) !== null)
            return $name;

        return '';
    }

    public function getLastTime($refresh = false)
    {
        if (($name = $this->getState('__last_time')) !== null && !$refresh)
            return $name;

        if ($this->getId() !== null) {
            //Yii::log(array('getTimezone' => $this->getId(), 'action' => 'getTimezone'), CLogger::LEVEL_ERROR, 'webUser');

            $model = $this->_getModel($refresh);
			if($model->last_auth){
				$this->setLastTime(strtotime($model->last_auth->created_at));
			} else {
				$this->setLastTime(false);
			}
            
            return $this->getLastTime();
        } else
            return false;

        return '';
    }

    /**
     * Getting user language
     * by default user language from users settings
     * @return null|string
     */
    public function getLanguage()
    {
        if (($name = $this->getState('__language')) !== null)
            return $name;

        return '';
    }

    /**
     * Getting user font size
     * by default user font size from users settings
     * @return null|string
     */
    public function getFontSize()
    {
        if (($name = $this->getState('__font_size')) !== null)
            return $name;

        return '';
    }

    public function login($identity, $duration = 0)
    {
        $this->id = $identity->getId();
        $user = $this->_getModel();

        $this->setRole(Users::$roles[$user->role]);
        $this->setEmail($user->email);
        $this->setPhone($user->phone);
        $this->setStatus($user->status);
        $this->setThisIp(ip2long(Yii::app()->request->getUserHostAddress()));
        $this->setLanguage($user->settings->language);
        $this->setFontSize($user->settings->font_size);
        $this->setFullName($user->getFullName());
        $this->getTimeZone();
        $this->getPhotoUrl();

        //$SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
        //$country = $SxGeo->getCountry(Yii::app()->request->getUserHostAddress());
        //$log = new Users_Log;
        //$log->region = $country;
        //$log->type = 'login';
        //$log->user_id = $user->id;
        //$log->save();

        $this->initRback();

        if ($user->last_auth) {
            $this->setLastIp($user->last_auth->ip_address);
            $this->setLastTime(strtotime($user->last_auth->created_at));
        }

        parent::login($identity);

    }

    public function setThisIp($value)
    {
        $this->setState('__this_ip', $value);
    }

    public function setLanguage($value)
    {
        $this->setState('__language', $value);
        return $this;
    }

    public function setFontSize($value)
    {
        $this->setState('__font_size', $value);
        return $this;
    }

    public function setFullName($fullName)
    {
        $this->setState('__full_name', $fullName);
    }

    public function setTimeZone($value){
        Zone::setUserTimeZone($value);
        $this->setState('__time_zone', $value);
    }

    /**
     * Download access rights for user
     */
    public function initRback()
    {
        $user = $this->_getModel();
        $settings = $user->getRbacSettings($this->getRbacCurrentUid());
        $accounts = $user->getRbacAllowedAccounts();
        $this->setState('__rbac', $settings);
        $this->setState('__rbac_allowed_accounts', $accounts);
    }

    public function getRbacCurrentUid()
    {
        return $this->getState('__rbac_current_uid');
    }

    public function setLastIp($value)
    {
        $this->setState('__last_ip', $value);
    }

    public function setLastTime($value)
    {
        $this->setState('__last_time', $value);
    }

    public function logout($destroySession = true)
    {
        $user = $this->_getModel();
        if($user){
            $SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH);
            $country = $SxGeo->getCountry(Yii::app()->request->getUserHostAddress());
            $log = new Users_Log;
            $log->region = $country;
            $log->type = 'logout';
            $log->user_id = $user->id;
            $log->save();
        }

        parent::logout();
    }

    public function getCurrentId()
    {
        if (!Yii::app()->user->getRbacCurrentUid()) {
            return Yii::app()->user->id;
        } else {
            return Yii::app()->user->getRbacCurrentUid();
        }
    }

    public function switchRbacAccount($uid = NULL)
    {
        $this->setRbacCurrentUid($uid);
        $this->initRback();
    }

    public function setRbacCurrentUid($uid)
    {
        $this->setState('__rbac_current_uid', $uid);
    }

    public function getRbacAccountSwitcherMenu()
    {

        $menu = array(
            'active' => array(),
            'other' => array()
        );

        $buff = (array)$this->getRbacAllowedAccounts();
        $me = array(
            'id' => $this->getId(),
            'account_name' => $this->getFullName()
        );
        if ($this->getRbacCurrentUid() == NULL) {
            $menu['active'] = $me;
            foreach ($buff as $account) {
                $menu['other'][] = $account;
            }
        } else {
            $menu['other'][] = $me;
            foreach ($buff as $account) {
                if ($account['id'] == $this->getRbacCurrentUid()) {
                    $menu['active'] = $account;
                } else {
                    $menu['other'][] = $account;
                }
            }
        }
        return $menu;
    }

    public function getRbacAllowedAccounts()
    {
        if ($this->getState('__rbac_allowed_accounts') == NULL) {
            $this->initRback();
        }
        return $this->getState('__rbac_allowed_accounts');
    }

    public function getFullName()
    {
        if (($name = $this->getState('__full_name')) !== null)
            return $name;
        else
            return $this->guestName;
    }

    /**
     * check if user has access to Controller.Action
     */
    public function checkRbacAccess($ca)
    {
        $ca = strtolower($ca);
        $rights = $this->getRbac();

        foreach ((array)$rights as $right) {
            if ($this->actionAllowed($ca, $right['action_id'])) {
                return true;
            }
        }
        return false;
    }

    public function getRbac()
    {
        if ($this->getState('__rbac') == NULL) {
            $this->initRback(); //TODO put rbac to cache, and drop cache on update
        }

        return $this->getState('__rbac');
    }

    private function actionAllowed($controllerAction, $accessRight)
    {

        $res = false;

        $a = explode('.', $controllerAction);
        $b = explode('.', $accessRight);


        if ($controllerAction == $accessRight) {
            $res = true;
        } elseif ($a[0] == $b[0] && $a[1] == $b[1]) {
            $res = true;
        } elseif ($a[0] == $b[0] && $b[1] == '*') {
            $res = true;
        }

        return $res;
    }

    public function getActivityStatus($xabina_id = null)
    {
        if (($ret = Yii::app()->cache->get("__userActivityState_" . $xabina_id))) {
            return $ret;
        }
        return 0;
    }

    public function getSelfActivityStatus()
    {
        if (($value = Yii::app()->cache->get('__userActivityState_' . $this->getXabinaId())) !== false) {
            Yii::app()->cache->set("__userActivityState_"  . $this->getXabinaId(),  $value, 240);
            return $value;
        }

        if ($this->getId() !== null) {
            $this->setActivityStatus($this->_getModel()->activity_status);
            return $this->getSelfActivityStatus();
        } else {
            return 0;
        }
    }

    public function setActivityStatus($value)
    {
        $this->_model = $this->_getModel();
        $this->_model->activity_status = $value;
        $this->_model->save();
        Yii::app()->cache->set("__userActivityState_"  . $this->getXabinaId(),  $value, 240);
    }

    public function getXabinaId()
    {
        if (($value = $this->getState('__xabina_id')) !== null) {
            return $value;
        } else {
            $this->_model = $this->_getModel();
            $value = $this->_model->login;
            $this->setState('__xabina_id', $value);
            return $value;
        }
    }

    public function checkAccessByUrl($operation, $params = array(), $allowCaching = true)
    {
        $operation = str_replace('/', '.', trim($operation, '/'));
        return parent::checkAccess($operation, $params, $allowCaching);
    }
}
