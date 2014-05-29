<?php

abstract class ActiveRecord extends CActiveRecord
{
    private $_oldAttributes = array();
    public function setOldAttributes($value)
    {
        $this->_oldAttributes = $value;
    }
    public function getOldAttributes()
    {
        return $this->_oldAttributes;
    }
    
    public static function model($className = __CLASS__, $new = false)
    {
        if($new){
            return new $className();
        }
        return parent::model($className);
    }
	
	protected function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            if ($this->hasAttribute('created_at')) {
                $this->created_at = time();
            }
        }
		if ($this->hasAttribute('updated_at')) {
			$this->updated_at = time();
		}
        return parent::beforeSave();
    }
	
	public function notifyRules(){
		return array();
	}
	
	/**
	*	For ajax validation with notifications. Use in outgoing form only
	**/
	public function validateWithNotify($returnJSON = true){
		$class = get_class($this);
		if(!isset($_POST[$class])){
			return array();
		}
		$this->attributes = $_POST[$class];
		$this->validate();
		
		$notifications = array();
		foreach($this->notifyRules() as $functionName){
			$notifications = array_merge($notifications, $this->{$functionName}());
		}
		$errors = array();
		foreach($this->getErrors() as $errorKey => $errorMessage){
			$errors[$class.'_'.$errorKey] = $errorMessage;
		}
		$arrayRes = array_merge($errors, array('notify' => $notifications));
		return CJSON::encode($arrayRes);
	}
	
	public function currentUser()
    {
        if($this->hasAttribute('user_id')) {
            $this->getDbCriteria()->mergeWith(array(
                    'condition' => 't.user_id = :uid',
                    'params' => array(':uid' => Yii::app()->user->getCurrentId())
                ));
        } else {
			throw new CHttpException(500, 'No user in this table!');
		}
		return $this;
	}

    public function byUserId($userID)
    {
        if($this->hasAttribute('user_id')) {
            $this->getDbCriteria()->mergeWith(array(
                    'condition' => 'user_id = :uid',
                    'params' => array(':uid' => $userID)
                ));
        }
        return $this;
    }
}