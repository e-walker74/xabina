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
}