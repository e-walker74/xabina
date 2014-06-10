<?php

/**
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Social $contact
 */
class Users_Contacts_Data_Social extends Users_Contacts_Data_Model
{

	public $social = 'fb';
	public $url;
	
	public static $socials = array(
		'fb' => 'Facebook',
		//'google' => 'Google+',
		'linkedin' => 'LinkedIn',
		'twitter' => 'Twitter',
		//'vk' => 'VKontakte',
	);
	
	public static $socialsImages = array(
		'fb' => '/images/soc_img_03.png',
		//'google' => 'Google+',
		'linkedin' => '/images/soc_img_09.png',
		'twitter' => '/images/soc_img_06.png',
		//'vk' => 'VKontakte',
	);

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('social, url', 'required'),
			array('url', 'socialUrlValidate'),
			array('url', 'url'),
			array('social', 'in', 'range' => array_keys(self::$socials)),
		);
	}
	
	public function socialUrlValidate($attribute, $params){
		$elementsArr = explode('/', $this->{$attribute});
		if(count($elementsArr) < 4 || !array_pop($elementsArr)){
			$this->addError($attribute, Yii::t('Front', 'Url is incorrect'));
		}
	}
	
	public function attributeNames(){
		return array(
			'social',
			'url',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersContactsData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
