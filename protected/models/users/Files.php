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
		'Users_Personal_Edit' => array('count' => 999, 'fileSize' => 20971520, 'ext' => array("jpg","jpeg","gif","png"), 'user_check' => 1),
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
			array('name, form, document_type, document', 'length', 'max'=>30, 'message' => Yii::t('Front', 'Entry is to long')),
			array('user_file_name, description', 'length', 'max'=>255, 'tooLong' => Yii::t('Front', 'The comment is too long. It should be no longer than 250 symbols.')),
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
			'personal_document' => array(self::HAS_ONE, 'Users_Personal_Documents', 'file_id'),
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

		$criteria->compare('form',$this->form);
		$criteria->with = 'personal_document';
		$criteria->together = true;
		

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
	
	public function getShortDescription(){
		if(mb_strlen($this->description) > 100){
			$str = '<span class="show_more">
				<span>' . SiteService::subStrEx($this->description, 100) . '</span>
				<a href="javaScript:void(0)" onclick="$(document).find(\'.show_less\').hide(); $(this).parents(\'.show_more\').hide(); $(this).parents(\'.show_more\').next(\'.show_less\').slideDown(\'slow\');" class="show-more">' . Yii::t('Front', 'show more') . '</a>
			</span>
			<span class="show_less" style="display:none;">' . $this->description . '
				<a class="show-more" href="javaScript:void(0)" onclick="$(this).parents(\'.show_less\').hide().prev(\'.show_more\').slideDown(\'slow\');">' . Yii::t('Front', 'Show less') . '</a>
			</span>';
		} else {
			$str = $this->description;
		}
		return $str;
	}
}
