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
            array('message, to, subject', 'required', 'on'=> 'update'),
            array('message, subject, to', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify'), 'message' => 'Purifier'),
			array('to', 'validateToField', 'on' => 'update'),
			array('archive', 'numerical', 'integerOnly'=>true),
            array('to, user_id, dialog_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dialog_id, message, archive, draft, subject, to', 'safe', 'on'=>'search'),
		);
	}
	
	public function validateToField($attribute,$params){
		$toArr = explode(',', trim($this->to));
		foreach($toArr as $to){
			$to = trim($to);
			if(Messages_To::model()->find('name = :name', array(':name' => $to))){
				continue;
			} elseif(is_numeric($to) && Users::model()->find('login = :login', array(':login' => $to))){
				continue;
			}
			$this->addError('to', Yii::t('Front', 'To is incorrect'));
		}
		return true;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            //'to' => array(self::BELONGS_TO, 'Messages_To', 'to'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
			'subject' => 'Subject',
            'to' => 'To'
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
		$criteria->compare('subject',$this->subject);
        $criteria->compare('to',$this->to);
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

        $condition = 'dialog_id=:dialog_id AND id !=:id AND user_id=:user_id AND archive=:archive AND draft=0';
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
