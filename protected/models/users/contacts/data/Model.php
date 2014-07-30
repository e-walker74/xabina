<?php

/**
 *
 * The followings are the available model relations:
 * @property Users_Contacts_Data_Model $contact
 */
class Users_Contacts_Data_Model extends CModel
{

	public $id;
	protected $_dbModel;
    public $category_id;
	
	public function setDbModel($model){
		$this->_dbModel = $model;
	}

    /**
     * @return Users_Contacts_Data
     */
    public function getDbModel(){
		return $this->_dbModel;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('category_id', 'categoryValidate'),
		);
	}

    public function categoryValidate($attribute, $param){
        if(!$this->category_id && isset($_POST['Data_Category'])){
            if(empty($_POST['Data_Category'])){
                $this->addError('category_id', Yii::t('Front','Category is incorrect'));
            }
        } elseif($this->category_id && !is_numeric($this->category_id)){
            $this->addError('category_id', Yii::t('Front','Category is incorrect'));
        }
    }
	
	public function attributeNames(){
		return array();
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

    public function beforeValidate(){
        foreach($this->attributes as $key => $value){
            $this->$key = strip_tags($value);
        }
        return parent::beforeValidate();
    }
	
	public function save(){
		if(!$this->_dbModel){
			return false;
		}
		$this->_dbModel->value = serialize($this->attributes);
		return $this->_dbModel->save();
	}
}
