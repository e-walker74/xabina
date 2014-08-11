<?php


class Messages_Subject extends ActiveRecord
{

	public function tableName()
	{
		return 'messages_subject';
	}


	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		return array(
			'messages' => array(self::HAS_MANY, 'Messages', 'subject_id'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Все темы
     * @return array
     */
    public static function all(){
        $models = self::model()->findAll();
        $array = array( '' => 'Choose');
        foreach ($models as $v) {
            $array[$v->id] = $v->title;
        }
        return $array;
    }
}
