<?php

/**
 * This is the model class for table "cross_links".
 *
 * The followings are the available columns in table 'cross_links':
 * @property integer $id
 * @property string $user_id
 * @property string $entity_name
 * @property integer $entity_id
 * @property string $link_table_name
 * @property integer $link_table_id
 * @property integer $category_id
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class CrossLinks extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cross_links';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, entity_name, entity_id, link_table_name, link_table_id', 'required'),
			array('entity_id, link_table_id, category_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('entity_name, link_table_name, comment', 'length', 'max'=>255),
            array('comment', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, entity_name, entity_id, link_table_name, link_table_id, category_id, comment', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'user_id' => 'User',
			'entity_name' => 'Entity Name',
			'entity_id' => 'Entity',
			'link_table_name' => 'Link Table Name',
			'link_table_id' => 'Link Table',
			'category_id' => 'Category',
			'comment' => 'Comment',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('entity_name',$this->entity_name,true);
		$criteria->compare('entity_id',$this->entity_id);
		$criteria->compare('link_table_name',$this->link_table_name,true);
		$criteria->compare('link_table_id',$this->link_table_id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CrossLinks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
