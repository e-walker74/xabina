<?php

/**
 * This is the model class for table "accounts_types".
 *
 * The followings are the available columns in table 'accounts_types':
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property integer $bet
 * @property string $payments
 * @property string $term
 * @property integer $category_id
 * @property integer $currency_id
 *
 * The followings are the available model relations:
 * @property Accounts[] $accounts
 */
class AccountsTypes extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accounts_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title, description', 'required'),
			array('bet, category_id, currency_id', 'numerical', 'integerOnly'=>true),
			array('code, title', 'length', 'max'=>30),
			array('description', 'length', 'max'=>255),
			array('payments, term', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, title, description, bet, payments, term, category_id, currency_id', 'safe', 'on'=>'search'),
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
			'accounts' => array(self::HAS_MANY, 'Accounts', 'type_id'),
            'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
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
			'description' => 'Description',
			'bet' => 'Bet',
			'payments' => 'Payments',
			'term' => 'Term',
			'category_id' => 'Category',
			'currency_id' => 'Currency',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bet',$this->bet);
		$criteria->compare('payments',$this->payments,true);
		$criteria->compare('term',$this->term,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('currency_id',$this->currency_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountsTypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
