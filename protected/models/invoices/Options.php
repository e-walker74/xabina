<?php

/**
 * This is the model class for table "invoices_options".
 *
 * The followings are the available columns in table 'invoices_options':
 * @property integer $id
 * @property integer $invoice_id
 * @property string $name
 * @property integer $quantity
 * @property double $price
 * @property integer $tax
 * @property string $description
 */
class Invoices_Options extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoices_options';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('invoice_id, quantity, tax', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name, description', 'safe'),

			array('id, invoice_id, name, quantity, price, tax, description', 'safe'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('Front', 'Item name/ID'),
			'quantity' => Yii::t('Front', 'Quantity'),
			'price' => Yii::t('Front', 'Unit price'),
			'tax' => Yii::t('Front', 'Tax'),
			'description' => Yii::t('Front', 'Description'),
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
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('tax',$this->tax);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices_InvoicesOptions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function saveInvoiceGroup($data, $invoiceId){
        foreach($data as $item){
            $this->attributes = $item;
            $this->invoice_id = $invoiceId;
            $this->save();
        }
    }
}
