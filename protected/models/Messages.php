<?php


class Messages extends ActiveRecord
{

	public function tableName()
	{
		return 'messages';
	}

	public function rules()
	{
		return array(
            array('message, subject_id, to_id', 'required', 'on'=> 'Save'),
            array('message', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
			array('archive, subject_id, to_id', 'numerical', 'integerOnly'=>true),
            array('to_id, user_id, dialog_id', 'safe'),
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
		return array(
			'subject' => array(self::BELONGS_TO, 'Messages_Subject', 'subject_id'),
            'to' => array(self::BELONGS_TO, 'Messages_To', 'to_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
           // 'dialog' => array(self::HAS_MANY, 'Messages', 'dialog_id'),
		);
	}

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
		$criteria->compare('t.dialog_id',$this->dialog_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('archive',0);
		$criteria->compare('draft',0);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('subject_id',$this->subject_id);
        $criteria->compare('to_id',$this->to_id);
		$criteria->with = array('user');
		$criteria->together = true;
		$criteria->group = 't.dialog_id desc';

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
        $pages = null;
        $criteria = new CDbCriteria();
        $criteria->condition = $condition;
        $criteria->params = $params;
        $criteria->order = 'updated_at DESC';
        $messages = self::model()->findAll($criteria);
        return array('pages' => $pages,  'messages' => $messages);
    }

    public function getDialog($dialog_id, $id = 0, $archive = 0){
        if(empty($dialog_id)){
            return null;
        }

        $condition = 'dialog_id=:dialog_id AND id !=:id AND user_id=:user_id  AND archive=:archive AND subject_id > 0 AND draft=0';
        $params = array(
            ':user_id' => (int)Yii::app()->user->id,
            ':id' => $id,
            ':dialog_id' => $dialog_id,
            ':archive' => $archive,
        );
        $criteria = new CDbCriteria();
        $criteria->condition = $condition;
        $criteria->params = $params;
        $criteria->order = 'updated_at DESC';
        return self::model()->findAll($criteria);
    }
}
