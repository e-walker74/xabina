<?php

/**
 * This is the model class for table "currencies".
 *
 * The followings are the available columns in table 'currencies':
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property double $last_value
 * @property integer $last_update
 */
class Currencies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title, last_value, last_update', 'required'),
			array('last_update', 'numerical', 'integerOnly'=>true),
			array('last_value', 'numerical'),
			array('code, title', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, title, last_value, last_update', 'safe', 'on'=>'search'),
		);
	}
	
	public static function convert($sum, $from, $to){
		if(is_numeric($from)){
            $from = Currencies::model()->findByPk($from);
        } else {
            $from = Currencies::model()->find('code = :f', array(':f' => $from));
        }
        if(is_numeric($to)){
            $to = Currencies::model()->findByPk($to);
        } else {
            $to = Currencies::model()->find('code = :f', array(':f' => $to));
        }

		$eurFrom = $sum / $from->last_value;
		$return = $eurFrom * $to->last_value;

		return $return;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'title' => 'Title',
			'last_value' => 'Last Value',
			'last_update' => 'Last Update',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('last_value',$this->last_value);
		$criteria->compare('last_update',$this->last_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currencies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getTotalByTransactionsInEUR($transes = array()){
		
		$total = 0;
		foreach($transes as $trans){
			$total += ($trans->amount / $trans->account->currency->last_value);
		}
		return $total;
	}
}
