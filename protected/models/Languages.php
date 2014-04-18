<?php

class Languages extends CModel
{
	
    public static $languages = array('en', 'ch', 'du', 'fr', 'ge', 'ru');
	public static $languagesDomains = array('http://xabina.intwall.com' => 'en', 'ch' => 'ch', 'du' => 'du', 'fr' => 'fr', 'ge' => 'ge', 'http://ruxabina.intwall.com' => 'ru');
	
	public static function setLang(){	
		if(isset(Languages::$languagesDomains[Yii::app()->getBaseUrl(true)])){
			Yii::app()->sourceLanguage = Languages::$languagesDomains[Yii::app()->getBaseUrl(true)] . '_' . strtoupper(Languages::$languagesDomains[Yii::app()->getBaseUrl(true)]);
			Yii::app()->language = Languages::$languagesDomains[Yii::app()->getBaseUrl(true)];
		} else {
			Yii::app()->sourceLanguage = 'en_EN';
			Yii::app()->language = 'en';
		}
	}
	
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