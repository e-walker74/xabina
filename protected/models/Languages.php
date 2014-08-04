<?php

class Languages extends CModel
{
	
    public static $languages = array('en' => 'English', 'ch' => 'CH', 'du' => 'DU', 'fr' => 'FR', 'ge' => 'GE', 'ru' => 'Русский');
	public static $languagesDomains = array('http://xabina.intwall.com' => 'en', 'ch' => 'ch', 'du' => 'du', 'fr' => 'fr', 'ge' => 'ge', 'http://ruxabina.intwall.com' => 'ru');
	
	public function attributeNames(){}
	
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}