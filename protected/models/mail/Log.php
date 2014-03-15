<?php

/**
 * This is the model class for table "user_providers".
 *
 * The followings are the available columns in table 'user_providers':
 * @property integer $id
 * @property integer $user_id
 * @property integer $provider_id
 * @property integer $soc_id
 */
class Mail_Log extends ActiveRecord
{

	public $login;
    
    public function tableName()
    {
        return 'mail_log';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserProviders the static model class
     */
    /*public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }*/

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, template', 'required'),
			array('templates, login', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'user_id')
        );
    }
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user.login', $this->login, true);
        $criteria->compare('template', $this->template, true);
		$criteria->compare('email', $this->email, true);
		$criteria->with = 'user';
		$criteria->together = true;
		if(!isset($_GET['Mail_Log'])){
			$criteria->order = 't.created_at desc';
		}

        return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
    }
}