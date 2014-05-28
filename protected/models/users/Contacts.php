<?php

/**
 * This is the model class for table "users_contacts".
 *
 * The followings are the available columns in table 'users_contacts':
 * @property integer $id
 * @property integer $user_id
 * @property integer $xabina_id
 * @property string $fullname
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property UsersContactsData[] $usersContactsDatas
 */
class Users_Contacts extends ActiveRecord
{

	protected $_contacts_data = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		
			// TODO trim and filter fullname
			
			array('user_id, fullname', 'required'),
			array('user_id, xabina_id', 'numerical', 'integerOnly'=>true),
			array('fullname', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, xabina_id, fullname', 'safe', 'on'=>'search'),
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
			'data' => array(self::HAS_MANY, 'Users_Contacts_Data', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'xabina_id' => 'Xabina',
			'fullname' => 'Fullname',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('xabina_id',$this->xabina_id);
		$criteria->compare('fullname',$this->fullname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users_Contacts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDataValues($type){
		if(isset($this->_contacts_data[$type])){
			return $this->_contacts_data[$type];
		}
		return array();
	}
	
	public function afterFind(){
		foreach($this->getRelated('data') as $data){
			if($data->once){
				$this->_contacts_data[$data->data_type] = $data->value;
			} else {
				$this->_contacts_data[$data->data_type][] = $data->value;
			}
		}
	}
}
