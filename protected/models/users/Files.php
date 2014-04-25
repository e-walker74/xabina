<?php

/**
 * This is the model class for table "users_files".
 *
 * The followings are the available columns in table 'users_files':
 * @property integer $user_id
 * @property string $name
 * @property string $ext
 * @property string $form
 * @property string $type
 */
class Users_Files extends ActiveRecord
{

	public static $fileTypes = array(
		'Transactions' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg","jpeg","gif","png","pdf","txt","doc","docx"), 'user_check' => 1),
		'Users_Activation' => array('count' => 4, 'fileSize' => 20971520, 'ext' => array("jpg","jpeg","gif","png"), 'user_check' => 1),
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name, ext', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('name, form, document_type, document', 'length', 'max'=>30),
			array('user_file_name', 'length', 'max'=>255),
			array('ext', 'length', 'max'=>11),
			array('description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, name, ext, user_file_name, type', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'name' => 'Name',
			'ext' => 'Ext',
			'user_file_name' => 'user_file_name',
			'type' => 'Type',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('user_file_name',$this->user_file_name,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersFiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
