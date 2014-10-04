<?php

/**
 * This is the model class for table "users_contacts_data".
 *
 * The followings are the available columns in table 'users_contacts_data':
 * @property integer $id
 * @property integer $contact_id
 * @property string $data_type
 * @property string $value
 * @property integer $category_id
 * @property string $field1
 * @property string $field2
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
        'others' => 'Users_Contacts_Data_Others',
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
            array('field1, field2', 'safe'),
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
            'category' => array(self::BELONGS_TO, 'Users_Contacts_Data_Categories', 'category_id'),
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
	 * @return Users_Contacts_Data the static model class
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

    /**
     * @return Users_Contacts_Data_Model
     */
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

    public function renderContactData($contact_id, $data_type, $dbModel = false, $scenario = 'saved'){
        $contact = Users_Contacts::model()->findByPk($contact_id);
        $data_categories = Users_Contacts_Data_Categories::model()->findAll(
            array(
                'condition' => '(user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
            )
        );
        $new_model_id = false;
        if($dbModel){
            $new_model_id = $dbModel->id;
        }
        $instMessengers = array();
        if($data_type == "instmessaging"){
            $instMessengers = InstmessagerSystems::model()->findAll();
        }

        return CJSON::encode(
            array(
                'success' => true,
                'message' => Yii::t('Front', 'contact_success_' . $data_type . '_' . $scenario),
                'html' => Yii::app()->controller->renderPartial(
                        'update/_'.$data_type,
                        array(
                            'model' => $contact,
                            'data_categories' => $data_categories,
                            'instMessengers' => $instMessengers,
                        ),
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
        $model->changeFields();

        $dbModel->attributes = $model->attributes;

        if(isset($_POST['Data_Category']) && !$model->category_id){
            $model->category_id = $this->getDataCategoryForModel($_POST['Data_Category'], $dbModel->data_type);
        }

        if(isset($_POST['Data_Category_Incoming'])){
            $model->incoming_category = $this->getDataCategoryForModel($_POST['Data_Category_Incoming'], 'incoming_category');
        }

        if(isset($_POST['Data_Category_Outgoing'])){
            $model->outgoing_category = $this->getDataCategoryForModel($_POST['Data_Category_Outgoing'], 'outgoing_category');
        }

        if($model->category_id){
            $dbModel->category_id = $model->category_id;
        }

        if($dbModel->data_type == 'contact' && $dbModel->isNewRecord){
            foreach(explode(',', $model->contact_id) as $cid){
                $cid = trim($cid);
                $newDbModel1 = clone($dbModel); // Save contacts
                $newModel = clone($model);
                $newModel->contact_id = $cid;
                $newDbModel1->contact_id = $contact_id;
                $newDbModel1->value = serialize($newModel->attributes);
                $newDbModel1->save();
//                dd($newDbModel1->save());
                // Save link for links contacts
                $newDbModel2 = clone($dbModel);
                $newModel = clone($model);
                $newModel->contact_id = $contact_id;//$newDbModel1->contact_id;
                $newDbModel2->contact_id = $cid;
                $newDbModel2->value = serialize($newModel->attributes);
                $newDbModel2->save();
//                dd($newDbModel2->save());
//                d($newDbModel1->attributes);
//                d($newDbModel2->attributes);
//                die;
            }
            return $this->renderContactData($contact_id, $dbModel->data_type, $dbModel);
        }

		$dbModel->value = serialize($model->attributes);
        $scenario = $dbModel->scenario;

        if(!Users_Contacts_Data::model()->countByAttributes(array('contact_id' => $dbModel->contact_id, 'data_type' => $dbModel->data_type))){
            $dbModel->is_primary = 1;
        }

		if($dbModel->save()){
            $this->deleteNotUsedCategories($dbModel);
            return $this->renderContactData($contact_id, $dbModel->data_type, $dbModel, $scenario);
		}
		return CJSON::encode(array('success' => false));
	}

    public function getDataCategoryForModel($data, $data_type){

        if(!$data){
            return false;
        }

        $model = Users_Contacts_Data_Categories::model()->find(
            array(
                'condition' => '(user_id = :uid or user_id is NULL) AND value = :data AND data_type = :type',
                'params' => array(
                    ':uid' => Yii::user()->getCurrentId(),
                    ':data' => $data,
                    ':type' => $data_type,
                )
            )
        );

        if(!$model){
            $model = new Users_Contacts_Data_Categories();
            $model->value = $data;
            $model->user_id = Yii::user()->getCurrentId();
            $model->data_type = $data_type;
            $model->save();
        }
        return $model->id;
    }

    public function deleteNotUsedCategories($model){
        if($this->hasAttribute('category_id')){
            $sql = 'DELETE
                    FROM users_contacts_data_categories
                    WHERE
                      NOT EXISTS
                        (
                          SELECT NULL FROM users_contacts_data uct
                          INNER JOIN users_contacts uc ON (uc.id = uct.contact_id)
                          WHERE uct.category_id = users_contacts_data_categories.id
                          AND uc.user_id = :user
                          AND uct.data_type = :data_type
                        )
                      AND user_id = :user
                      AND data_type = :data_type';

            Yii::app()->db->createCommand($sql)->execute(array(
                ':data_type' => $model->data_type,
                ':user' => $model->contact->user_id,
            ));
        }
    }
}
