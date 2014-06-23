<?php

/**
 * This is the model class for table "users_contacts_data".
 *
 * The followings are the available columns in table 'users_contacts_data':
 * @property integer $id
 * @property integer $contact_id
 * @property string $data_type
 * @property string $value
 *
 * The followings are the available model relations:
 * @property UsersContacts $contact
 */
class Users_Contacts_Data extends ActiveRecord
{

	public static $typesMap = array(
		'phone' => 'Users_Contacts_Data_Phone',
		'email' => 'Users_Contacts_Data_Email',
		'account' => 'Users_Contacts_Data_Account',
		'address' => 'Users_Contacts_Data_Address',
		'social' => 'Users_Contacts_Data_Social',
		'default' => 'Users_Contacts_Data_Default',
		'instmessaging' => 'Users_Contacts_Data_Instmessaging',
		'contact' => 'Users_Contacts_Data_Contact',
		'urls' => 'Users_Contacts_Data_Urls',
		'dates' => 'Users_Contacts_Data_Dates',
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_contacts_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_id, data_type, value', 'required'),
			array('contact_id', 'numerical', 'integerOnly'=>true),
			array('data_type', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contact_id, data_type, value', 'safe', 'on'=>'search'),
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
			'contact' => array(self::BELONGS_TO, 'Users_Contacts', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contact_id' => 'Contact',
			'data_type' => 'Data Type',
			'value' => 'Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('data_type',$this->data_type,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	
	public function getParamsModel(){
		if(!isset(self::$typesMap[$this->data_type])){
			return false;
		}
		
		$model = new self::$typesMap[$this->data_type];
		$model->attributes = unserialize($this->value);
		$model->id = $this->id;
		$model->setDbModel($this);
		
		return $model;
	}
	
	protected static function getModelByPost(){
		$paramsModel = false;
		foreach(self::$typesMap as $modelName){
			if(isset($_POST[$modelName])){
				if(isset($_POST[$modelName]['id']) && $_POST[$modelName]['id']){
					$model = self::model()->with('contact')->findByPk($_POST[$modelName]['id']);
					if($model->contact->user_id != Yii::app()->user->getCurrentId()){
						return false;
					}
					$paramsModel = $model->getParamsModel();
					$paramsModel->attributes = $_POST[$modelName];
				}else{
					$paramsModel = new $modelName;
					$paramsModel->attributes = $_POST[$modelName];
				}
				break;
			}
			$model = false;
		}
		return $paramsModel;
	}
	
	public function validateData(){
		$model = self::getModelByPost();
		return CActiveForm::validate($model);
	}

    public function renderContactData($contact_id, $data_type){
        $contact = Users_Contacts::model()->findByPk($contact_id);
        return CJSON::encode(
            array(
                'success' => true,
                'html' => Yii::app()->controller->renderPartial(
                        'update/_'.$data_type,
                        array('model' => $contact),
                        true,
                        true
                    )
            )
        );
    }
	
	public function saveData($contact_id){
		$model = Users_Contacts_Data::getModelByPost();
		if(!$model){
			return CJSON::encode(array('success' => false));
		}

		$dbModel = $model->getDbModel();
		if(!$dbModel){
			$dbModel = new Users_Contacts_Data;
			$dbModel->contact_id = $contact_id;
			$dbModel->data_type = array_search(get_class($model), Users_Contacts_Data::$typesMap);
		}
		$model->validate();
		$dbModel->value = serialize($model->attributes);
		
		if($dbModel->save()){
            return $this->renderContactData($contact_id, $dbModel->data_type);
		}
		return CJSON::encode(array('success' => false));
	}
}
