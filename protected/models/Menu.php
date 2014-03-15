<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id
 * @property string $name
 * @property string $action
 * @property string $url
 * @property integer $number
 */
class Menu extends CActiveRecord
{

    const ON_MAIN = 'front';
    const ON_ADMIN_PANEL = 'admin';
    const ON_PROFILE_PANEL = 'profile';
    const MODEL = 'model';
    
    static $menu_types = array('front' => 'front', 'admin' => 'admin', 
//            'profile' => 'profile'
        );

	/**
	 * Returns the static model of the specified AR class.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number', 'numerical', 'integerOnly'=>true),
			array('name, action, url', 'length', 'max'=>255),
                        array('showIn', 'in', 'range' => Menu::$menu_types),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, action, url, number', 'safe', 'on'=>'search'),
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
                    'parent'=>array(self::BELONGS_TO, 'Menu', 'parent_id'),
                    'childs'=>array(self::HAS_MANY, 'Menu', 'parent_id', 'order' => 'name'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('Admin', 'Name'),
			'action' => Yii::t('Admin', 'Action'),
			'url' => Yii::t('Admin', 'Url'),
			'number' => Yii::t('Admin', 'Number'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('number',$this->number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}