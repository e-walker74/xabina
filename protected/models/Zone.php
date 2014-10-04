<?php

/**
 * This is the model class for table "zone".
 *
 * The followings are the available columns in table 'zone':
 * @property integer $zone_id
 * @property string  $country_code
 * @property string  $zone_name
 */
class Zone extends CActiveRecord
{

    public static $showZones = array(
        239 => '(GMT -12:00) Eniwetok, Kwajalein',
        369 => '(GMT -11:00) Midway Island, Samoa',
        286 => '(GMT -10:00) Hawaii',
        397 => '(GMT -9:00) Alaska',
        398 => '(GMT -8:00) Pacific Time (US &amp; Canada)',
        391 => '(GMT -7:00) Mountain Time (US &amp; Canada)',
        128 => '(GMT -6:00) Central Time (US &amp; Canada), Mexico City',
        127 => '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima',
        139 => '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz',
        10 => '(GMT -3:00) Brazil, Buenos Aires, Georgetown',
        177 => '(GMT -2:00) Mid-Atlantic',
        130 => '(GMT -1:00 hour) Azores, Cape Verde Islands',
        172 => '(GMT) Western Europe Time, London, Lisbon, Casablanca',
        160 => '(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris',
        231 => '(GMT +2:00) Kaliningrad, South Africa',
        364 => '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg',
        2   => '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi',
        291 => '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
        225 => '(GMT +6:00) Almaty, Dhaka, Colombo',
        187 => '(GMT +7:00) Bangkok, Hanoi, Jakarta',
        332 => '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong',
        203 => '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
        179 => '(GMT +10:00) Eastern Australia, Guam, Vladivostok',
        34  => '(GMT +11:00) Magadan, Solomon Islands, New Caledonia',
        324 => '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'zone';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country_code, zone_name', 'required'),
            array('country_code', 'length', 'max' => 2),
            array('zone_name', 'length', 'max' => 35),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('zone_id, country_code, zone_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'zone_id' => 'Zone',
            'country_code' => 'Country Code',
            'zone_name' => 'Zone Name',
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

        $criteria = new CDbCriteria;

        $criteria->compare('zone_id', $this->zone_id);
        $criteria->compare('country_code', $this->country_code, true);
        $criteria->compare('zone_name', $this->zone_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Zone the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function setUserTimeZone($zName)
    {
        $offset = self::getOffset($zName);
        Yii::app()->db->createCommand("SET `time_zone`='" . $offset . "'")->execute();
    }

    public static function getOffset($zName)
    {
        $date = new DateTimeZone($zName);
        $dateTime = new DateTime('now', $date);

        $mins = $date->getOffset($dateTime) / 60;

        $sgn = ($mins < 0 ? '-' : '+');
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;

        $offset = $sgn . sprintf('%02d:%02d', $hrs, $mins);

        return $offset;
    }
}
