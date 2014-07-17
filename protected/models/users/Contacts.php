<?php

/**
 * This is the model class for table "users_contacts".
 *
 * The followings are the available columns in table 'users_contacts':
 * @property integer                     $id
 * @property integer                     $user_id
 * @property integer                     $xabina_id
 * @property string                      $fullname
 * @property string                      $last_name
 * @property string                      $first_name
 * @property string                      $photo
 * @property string                      $type
 * @property string                      $nickname
 * @property string                      $company
 *
 * The followings are the available model relations:
 * @property Users                       $user
 * @property UsersContactsData[]         $usersContactsDatas
 * @property Users_Contacts_Categories[] $categories
 */
class Users_Contacts extends ActiveRecord
{

    const AVATAR_PATH = '/images/contacts/';
    public $delete;

    protected $_contacts_data = array();
    protected $_contacts_data_masters = array();

    private $_transactions = false; //flag for delete image

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users_Contacts the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_contacts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            // TODO trim and filter fullname

            array('fullname', 'requiredOne'),
            array('first_name', 'required', 'on' => 'personal'),
            array('company', 'required', 'on' => 'company'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('type', 'in', 'range' => array('personal', 'company')),
            array('type', 'safe', 'on' => 'insert'),
            array('fullname, photo', 'length', 'max' => 255),
            array('photo', 'file', 'types' => 'jpg, gif, png', 'safe' => false, 'allowEmpty' => true),
            array('xabina_id', 'ext.validators.XabinaUserIdValidator'),
            array('xabina_id', 'length', 'max' => 20),
            array('hint', 'length', 'max' => 30),
            array('first_name, last_name', 'length', 'max' => 30),
            array('company', 'length', 'max' => 40),
            array('user_id', 'length', 'max' => 20),
            array('sex', 'in', 'range' => array('male', 'female')),
            array(
                'first_name, last_name, company',
                'match',
                'pattern' => '/^[0-9a-zA-Z_ ]+$/u',
                'message' => Yii::t('Front', 'Is incorrect'),
            ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, xabina_id, fullname', 'safe', 'on' => 'search'),
            array('delete', 'safe'),
        );
    }

    public function requiredOne()
    {
        if (!$this->fullname) {
//            $this->addError('first_name', Yii::t('Front', 'Fill in one of the fields'));
//            $this->addError('company', Yii::t('Front', 'Fill in one of the fields'));
        }
    }

    public function beforeValidate()
    {
        $this->scenario = $this->type;

        if ($this->scenario == 'personal') {
            $this->fullname = $this->first_name;
            if($this->last_name){
                $this->fullname .= ' ' . $this->last_name;
            }
        } elseif ($this->scenario == 'company') {
            $this->fullname = $this->company;
        }
        return true;
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->url = md5($this->fullname . time());
        }
        return parent::beforeSave();
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
            'data' => array(self::HAS_MANY, 'Users_Contacts_Data', 'contact_id', 'order' => 'is_primary desc'),
            'usersContactsCategoriesLinks' => array(self::HAS_MANY, 'Users_Contacts_Categories_Links', 'contact_id'),
            'categories' => array(self::HAS_MANY, 'Users_Contacts_Categories', array('category_id' => 'id'), 'through' => 'usersContactsCategoriesLinks'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'xabina_id' => 'Xabina',
            'fullname' => 'Fullname',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('xabina_id', $this->xabina_id);
        $criteria->compare('fullname', $this->fullname, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDataByType($type, $primary = false)
    {
        if (isset($this->_contacts_data[$type])) {
            if ($primary) {
                foreach ($this->_contacts_data[$type] as $data) {
                    if ($data->getDbModel()->is_primary) {
                        return $data;
                    }
                }
            } else {
                return $this->_contacts_data[$type];
            }
        }
        return array();
    }

    public function afterFind()
    {
        foreach ($this->getRelated('data') as $data) {
            if ($data->once) {
                $this->_contacts_data[$data->data_type] = $data->value;
                $this->_contacts_data_masters[$data->data_type] = $data->value;
            } else {
                $dataModel = $data->getParamsModel();
                $this->_contacts_data[$data->data_type][] = $dataModel;
                if ($dataModel->getDbModel()->is_primary) {
                    $this->_contacts_data_masters[$data->data_type] = $dataModel;
                }
            }
        }
    }

    public function getContactData()
    {
        return $this->_contacts_data;
    }

    public function getPrimaryData()
    {
        return $this->_contacts_data_masters;
    }

    public function getAvatarUrl()
    {
        if (!$this->photo) {
            return false;
        }
        $imgUrl = self::AVATAR_PATH . $this->user_id . '/' . $this->id . '/' . $this->photo;
        return $imgUrl;
    }

    public function getNameWithCompany()
    {
        return $this->hint;
    }

    public function getTransactionsArray()
    {

        if ($this->_transactions !== false) {
            return $this->_transactions;
        }

        $sql = "
			SELECT 
				t.id, 
				t.amount,
				t.type,
				t.acc_balance,
				t.created_at,
				t.transfer_type,
				t.url,
				t.transfer_id,
				acc.number user_account_number,
				cur.code currency,
				tout.form_type outgoing_form_type,
				tout.account_number,
				tout.to_account_number out_to_account_number,
				tout.to_account_holder,
				tout.bic,
				tout.bank_name,
				tout.description,
				tinc.form_type incoming_form_type,
				tinc.from_account_number,
				tinc.from_account_holder,
				tinc.to_account_number inc_to_account_number,
				tinc.electronic_method,
				tinc.card_type,
				ti.sender,
				ti.recipient
			FROM 
				`transactions` t
			INNER JOIN accounts acc on (t.account_id = acc.id AND acc.user_id = {$this->user_id})
			INNER JOIN currencies cur on (acc.currency_id = cur.id)
			INNER JOIN transactions_info ti on (t.info_id = ti.id)
			LEFT JOIN transfers_outgoing tout on (tout.id = t.transfer_id and t.transfer_type = 'outgoing')
			LEFT JOIN transfers_incoming tinc on (tinc.id = t.transfer_id and t.transfer_type = 'incoming')
			WHERE t.user_id = {$this->user_id}  and (tinc.counter_agent = {$this->id} or tout.counter_agent = {$this->id}) limit 5;
		";

        $connection = Yii::app()->db;

        $command = $connection->createCommand($sql);
        $rows = $command->queryAll();
        $this->_transactions = array();

        foreach ($rows as $trans) {
            $this->_transactions[$trans['id']]['id'] = $trans['id'];
            $this->_transactions[$trans['id']]['amount'] = $trans['amount'];
            $this->_transactions[$trans['id']]['type'] = $trans['type'];
            $this->_transactions[$trans['id']]['acc_balance'] = $trans['acc_balance'];
            $this->_transactions[$trans['id']]['created_at'] = $trans['created_at'];
            $this->_transactions[$trans['id']]['currency'] = $trans['currency'];
            $this->_transactions[$trans['id']]['outgoing_form_type'] = $trans['outgoing_form_type'];
            $this->_transactions[$trans['id']]['account_number'] = $trans['account_number'];
            $this->_transactions[$trans['id']]['description'] = $trans['description'];
            $this->_transactions[$trans['id']]['incoming_form_type'] = $trans['incoming_form_type'];
            $this->_transactions[$trans['id']]['from_account_number'] = $trans['from_account_number'];
            $this->_transactions[$trans['id']]['from_account_holder'] = $trans['from_account_holder'];
            $this->_transactions[$trans['id']]['electronic_method'] = $trans['electronic_method'];
            $this->_transactions[$trans['id']]['card_type'] = $trans['card_type'];
            $this->_transactions[$trans['id']]['from_holder'] = $trans['recipient'];
            $this->_transactions[$trans['id']]['to_holder'] = $trans['sender'];
            $this->_transactions[$trans['id']]['url'] = $trans['url'];
            $this->_transactions[$trans['id']]['transfer_type'] = $trans['transfer_type'];
            $this->_transactions[$trans['id']]['transfer_id'] = $trans['transfer_id'];


            if ($trans['transfer_type'] == 'outgoing') {
                if ($trans['type'] == 'negative') {
                    $this->_transactions[$trans['id']]['to_number'] = $trans['out_to_account_number'];
                    $this->_transactions[$trans['id']]['from_number'] = $trans['user_account_number'];
                }

            } elseif ($trans['transfer_type'] == 'incoming') {
                $this->_transactions[$trans['id']]['from_number'] = $trans['from_account_number'];
                $this->_transactions[$trans['id']]['to_number'] = $trans['inc_to_account_number'];
            }
            //$this->_transactions[$trans['id']] =
        }
        return $this->_transactions;
    }
}
