<?php


class Messages extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('message, subject_id, to_id', 'required', 'on'=> 'Save'),
            array('message', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			array('archive, subject_id, to_id', 'numerical', 'integerOnly'=>true),
            array('to_id, user_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dialog_id, message, archive, draft, subject_id, to_id', 'safe', 'on'=>'search'),
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

			'subject' => array(self::BELONGS_TO, 'Messages_Subject', 'subject_id'),
            'to' => array(self::BELONGS_TO, 'Messages_To', 'to_id'),
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
			'dialog_id' => 'Dialog',
			'message' => 'Message',
			'archive' => 'Archive',
			'draft' => 'Draft',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'subject_id' => 'Subject',
            'to_id' => 'To'
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('dialog_id',$this->dialog_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('archive',$this->archive);
		$criteria->compare('draft',$this->draft);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('subject_id',$this->subject_id);
        $criteria->compare('to_id',$this->to_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Общие данные по сообщениям
     * @param $condition
     * @param $params
     * @return array
     */
    public function getData($condition, $params){
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->condition = $condition;
        $criteria->params = $params;
        $count = self::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $messages = self::model()->findAll($criteria);
        return array('pages' => $pages,  'messages' => $messages);
    }
}
