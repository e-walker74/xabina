<?php

/**
 * This is the model class for table "banks_info".
 *
 * The followings are the available columns in table 'banks_info':
 * @property string $id
 * @property string $tag
 * @property string $modification_flag
 * @property string $bic_code
 * @property string $branch_code
 * @property string $institution_name
 * @property string $branch_information
 * @property string $city_heading
 * @property string $subtype_indication
 * @property string $value_added_services
 * @property string $extra_info
 * @property string $physical_address_1
 * @property string $physical_address_2
 * @property string $physical_address_3
 * @property string $physical_address_4
 * @property string $location
 * @property string $country_name
 * @property string $pob_number
 * @property string $pob_location
 * @property string $pob_country_name
 * @property string $created_at
 * @property string $updated_at
 */
class Banks_Info extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banks_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag, modification_flag, bic_code, branch_code, institution_name, city_heading, subtype_indication, physical_address_1, location, country_name, created_at, updated_at', 'required'),
			array('tag', 'length', 'max'=>4),
			array('modification_flag', 'length', 'max'=>1),
			array('bic_code, institution_name, branch_information, city_heading, value_added_services, extra_info, physical_address_1, physical_address_2, physical_address_3, physical_address_4, country_name, pob_number, pob_location, pob_country_name', 'length', 'max'=>255),
			array('branch_code', 'length', 'max'=>3),
			array('subtype_indication', 'length', 'max'=>30),
			array('location', 'length', 'max'=>2),
			array('created_at, updated_at', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tag, modification_flag, bic_code, branch_code, institution_name, branch_information, city_heading, subtype_indication, value_added_services, extra_info, physical_address_1, physical_address_2, physical_address_3, physical_address_4, location, country_name, pob_number, pob_location, pob_country_name, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'tag' => 'Tag',
			'modification_flag' => 'Modification Flag',
			'bic_code' => 'Bic Code',
			'branch_code' => 'Branch Code',
			'institution_name' => 'Institution Name',
			'branch_information' => 'Branch Information',
			'city_heading' => 'City Heading',
			'subtype_indication' => 'Subtype Indication',
			'value_added_services' => 'Value Added Services',
			'extra_info' => 'Extra Info',
			'physical_address_1' => 'Physical Address 1',
			'physical_address_2' => 'Physical Address 2',
			'physical_address_3' => 'Physical Address 3',
			'physical_address_4' => 'Physical Address 4',
			'location' => 'Location',
			'country_name' => 'Country Name',
			'pob_number' => 'Pob Number',
			'pob_location' => 'Pob Location',
			'pob_country_name' => 'Pob Country Name',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('modification_flag',$this->modification_flag,true);
		$criteria->compare('bic_code',$this->bic_code,true);
		$criteria->compare('branch_code',$this->branch_code,true);
		$criteria->compare('institution_name',$this->institution_name,true);
		$criteria->compare('branch_information',$this->branch_information,true);
		$criteria->compare('city_heading',$this->city_heading,true);
		$criteria->compare('subtype_indication',$this->subtype_indication,true);
		$criteria->compare('value_added_services',$this->value_added_services,true);
		$criteria->compare('extra_info',$this->extra_info,true);
		$criteria->compare('physical_address_1',$this->physical_address_1,true);
		$criteria->compare('physical_address_2',$this->physical_address_2,true);
		$criteria->compare('physical_address_3',$this->physical_address_3,true);
		$criteria->compare('physical_address_4',$this->physical_address_4,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('country_name',$this->country_name,true);
		$criteria->compare('pob_number',$this->pob_number,true);
		$criteria->compare('pob_location',$this->pob_location,true);
		$criteria->compare('pob_country_name',$this->pob_country_name,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     *
     */
    public function searchIBAN(){
        $criteria=new CDbCriteria;

        $criteria->compare('tag',$this->tag,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BanksInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
