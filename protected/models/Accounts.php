<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property string     $number
 * @property integer    $user_id
 * @property integer    $status
 * @property integer    $type_id
 * @property string     $currency_id
 * @property integer    $is_master
 * @property string     $name
 * @property string     $sub_type
 * @property integer    $balance
 * @property integer    $multi_balance
 *
 * The followings are the available model relations:
 * @property Users      $user
 * @property Currencies $currency
 */
class Accounts extends ActiveRecord
{
    const STATUS_APPROVED = -1;
    const STATUS_PENDING = 0;
    const STATUS_REJECTED = 2;
    const STATUS_LOCKED = 3;
    const STATUS_CLOSED = 4;

    public static $status_names = array(
        self::STATUS_PENDING => 'pending',
        self::STATUS_APPROVED => 'approved',
        self::STATUS_REJECTED => 'rejected',
        self::STATUS_LOCKED => 'locked',
        self::STATUS_CLOSED => 'closed',
    );

    public $holderEmail;
    public $terms;
    public $fees;
    public $new_name;
//    public $sub_type;

    public static $sub_types = array(
        'personal' => 'personal',
        'anonymous' => 'anonymous',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'accounts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name, currency_id, sub_type', 'required'),
            array('terms, fees', 'compare', 'compareValue' => 1, 'message' => 'You should accept term to use our service', 'on' => 'create'),
            array('user_id, status, type_id, currency_id', 'numerical', 'integerOnly' => true),
            array('number', 'length', 'max' => 12),
//            array('number', 'unique'),
//            array('number', 'UniqueAttributesValidator', 'with'=>'secondKey'),
            array('number', 'unique', 'criteria' => array(
                'condition' => '`currency_id`=:currency_id',
                'params' => array(
                    ':currency_id' => $this->currency_id
                )
            )),
            array('multi_balance', 'numerical'),
            array('new_name', 'validateNewName'),
            array('sub_type', 'in', 'range' => self::getAccountSubTypesForUser()),
            array('name, new_name', 'length', 'max' => 25, 'min' => 3),
            array('currency_id', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('number, status, sub_type, multi_balance', 'safe', 'on' => 'search'),
            array('id, number, user_id, status, type_id, currency_id', 'safe', 'on' => 'save'),
            array('id, number, user_id, status, type_id, currency_id, holderEmail', 'safe', 'on' => 'adminSearch'),
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
            'type_info' => array(self::BELONGS_TO, 'Accounts_Types', 'type_id'),
            'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
            'transactions' => array(self::HAS_MANY, 'Transactions', 'account_id', 'order' => 'created_at desc'),
            'multi_accounts' => array(self::HAS_MANY, 'Accounts', array('number' => 'number'), 'condition' => 'basic = 0'),
            'cross_tags' => array(self::HAS_MANY, 'CrossLinks', 'entity_id', 'condition' => 'cross_tags.link_table_name = "users_tags" AND cross_tags.entity_name = "accounts"'),
            'tags' => array(self::HAS_MANY, 'Users_Tags', array('link_table_id' => 'id'), 'through'=>'cross_tags'),
        );
    }

    public function afterSave(){
        if($this->getOldAttribute('balance') != $this->balance){
            $this->updateGroupBalance();
        }
        return parent::afterSave();
    }

    public function updateGroupBalance(){
        Accounts::model()->currentUser()->updateAll(
            array('multi_balance' => $this->getGroupBalance()),
            'number = :n AND basic = 1',
            array(':n' => $this->number)
        );
    }

    public function getGroupBalance()
    {
        if (!$this->multi_accounts) {
            return $this->balance;
        }
        $balance = $this->balance;
        $conversionData = CurrencyService::getConversionData();
        foreach ($this->multi_accounts as $account) {
            $balance += $account->balance * $conversionData[$account->currency->code]['rates'][$this->currency->code]['rate'];
        }
        return $balance;
    }

    public function beforeValidate()
    {
        if ($this->new_name) {
            $this->name = $this->new_name;
        }
        return parent::beforeValidate();
    }

    public function validateNewName($attr, $params)
    {
        if (!$this->name && !$this->new_name) {
            $this->addError($attr, Yii::t('Accounts', 'Name is incorrect'));
        }
    }

    public function getBalanceInEUR()
    {
        return $this->balance / $this->currency->last_value;
    }

    /**
     * check account balance
     */
    public function checkBalance($amount, $currency)
    {
        $sum = Currencies::convert($amount, $currency, $this->currency_id);
        return ($sum < $this->balance);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'number' => 'Number',
            'user_id' => 'User',
            'status' => 'Status',
            'type_id' => 'type_id',
            'currency' => Yii::t('Front', 'Currency'),
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user.email', $this->holderEmail, true);
        $criteria->with = array('user');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'balance desc',
            ),
            'pagination' => false,
        ));
    }

    public function searchWithGroup()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $this->user_id);
//        $criteria->compare('user.email', $this->holderEmail, true);
        $criteria->compare('basic', true);
        $criteria->with = array('user');
        if(!isset($_GET['Accounts_sort'])){
            $criteria->order = 'number asc';
        }

        if(isset($_GET['sort'])){
            $params = explode('.', $_GET['sort']);
            if(!isset($params[1]) || !($params[1] == 'desc' || $params[1] == 'asc')){
                throw new CHttpException(404, 'Page not found');
            }
            $searchFields = array('number', 'name', 'multi_balance', 'status');
            if(!in_array($params[0], $searchFields)){
                throw new CHttpException(404, 'Page not found');
            }
            $criteria->order = 't.' . $params[0] . ' ' . $params[1];
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Accounts the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            if (!$this->number) {
                for ($number = AccountService::generateNumber();
                     Accounts::model()->find('number = :number', array(':number' => $number));
                     $number = AccountService::generateNumber()) {
                    Yii::log('generate for user_id ' . $this->user_id, CLogger::LEVEL_ERROR, 'generateAccountNumner');
                }
                $this->number = $number;
            }
            //$this->currency_id = 1;
            //$this->type_id = 1;
            $this->status = self::STATUS_PENDING;
        }
        return parent::beforeSave();
    }

    public function getSubAccounts()
    {
        return Accounts::model()
            ->ownUser()
            ->with('currency')
            ->findAllByAttributes(
                array(
                    'number' => $this->number,
                ),
                array(
                    'order' => 'basic desc',
                )
            );
    }

    public function getUserBalanceInEUR($number = false)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $this->user_id);
        $criteria->with = 'currency';
        $criteria->together = true;
        $accounts = Accounts::model()->findAll($criteria);
        $total = 0;
        foreach ($accounts as $acc) {
            $total += ($acc->balance / $acc->currency->last_value);
        }
        if ($number) {
            return $total;
        }
        $currencies = CurrencyService::getCurrenciesList();
        return Yii::app()->controller->renderPartial('application.views.banking._totalCurrencies', array('total' => $total, 'currencies' => $currencies), true);
    }

    public static function getAccountSubTypesForUser()
    {
		if(Yii::user()->checkAccess('admin')){
			return self::$sub_types;	
		}
        if (Yii::user()->getStatus() == Users::USER_IS_VERIFICATED) {
            return self::$sub_types;
        } else {
            return array('anonymous' => 'anonymous');
        }
    }

    public static function getTempAccountsTypeAndSubtype()
    {
        if (Yii::user()->getStatus() == Users::USER_IS_VERIFICATED) {
            return array(
                'personal' => 'Платежный personal',
                'anonymous' => 'Платежный anonymous',
            );
        } else {
            return array('anonymous' => 'Платежный anonymous');
        }
    }

    public function generateUrl()
    {
        return $this->prefix . '_' . $this->number;
    }
}
