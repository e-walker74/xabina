<?php

/**
 * This is the model class for table "users_contacts".
 *
 * The followings are the available columns in table 'users_contacts':
 * @property integer $id
 * @property integer $user_id
 * @property integer $xabina_id
 * @property string $fullname
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property UsersContactsData[] $usersContactsDatas
 */
class Users_Contacts extends ActiveRecord
{

	const AVATAR_PATH = '/images/contacts/';

	protected $_contacts_data = array();
	private $_transactions = false;

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
			array('user_id, xabina_id', 'numerical', 'integerOnly'=>true),
			array('fullname, photo', 'length', 'max'=>255),
			array('photo', 'file', 'types'=>'jpg, gif, png', 'safe'=>false, 'allowEmpty' => true),
			array('xabina_id', 'ext.validators.XabinaUserIdValidator'),
			array('first_name, last_name, company, nickname', 'length', 'max'=>123),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, xabina_id, fullname', 'safe', 'on'=>'search'),
		);
	}
	
	public function requiredOne(){
		if(!$this->fullname){
			$this->addError('nickname', Yii::t('Front', 'Name is incorrect'));
		}
	}
	
	public function beforeValidate(){
		if($this->nickname){
			$this->fullname = $this->nickname;
		} elseif($this->first_name && $this->last_name){
			$this->fullname = $this->last_name . ' ' . $this->first_name; 
		} elseif($this->first_name || $this->last_name){
			$this->fullname = $this->last_name . $this->first_name; 
		} elseif($this->company){
			$this->fullname = $this->company;
		}
		return true;
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('xabina_id',$this->xabina_id);
		$criteria->compare('fullname',$this->fullname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users_Contacts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDataByType($type){
		if(isset($this->_contacts_data[$type])){
			return $this->_contacts_data[$type];
		}
		return array();
	}
	
	public function afterFind(){
		foreach($this->getRelated('data') as $data){
			if($data->once){
				$this->_contacts_data[$data->data_type] = $data->value;
			} else {
				$this->_contacts_data[$data->data_type][] = $data->getParamsModel();
			}
		}
	}
	
	public function getAvatarUrl(){
		if(!$this->photo){
			return false;
		}
		$imgUrl = self::AVATAR_PATH . $this->user_id . '/' . $this->id . '/' . $this->photo;
		return $imgUrl;
	}
	
	public function getTransactionsArray(){
	
		if($this->_transactions !== false){
			return $this->_transactions;
		}
		
		$sql = "
			SELECT 
				t.id, 
				t.sum,
				t.type,
				t.acc_balance,
				t.created_at,
				t.transfer_type,
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
		
		$connection=Yii::app()->db;
		
		$command=$connection->createCommand($sql);
		$rows = $command->queryAll();
		$this->_transactions = array();

		foreach($rows as $trans){
			$this->_transactions[$trans['id']]['amount'] = $trans['sum'];
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
			
			if($trans['transfer_type'] == 'outgoing'){
				if($trans['type'] == 'negative'){
					$this->_transactions[$trans['id']]['to_number'] = $trans['out_to_account_number'];
					$this->_transactions[$trans['id']]['from_number'] = $trans['user_account_number'];
				}
				
			} elseif($trans['transfer_type'] == 'incoming'){
				$this->_transactions[$trans['id']]['from_number'] = $trans['from_account_number'];
				$this->_transactions[$trans['id']]['to_number'] = $trans['inc_to_account_number'];
			}
			//$this->_transactions[$trans['id']] = 
		}		
		return $this->_transactions;
	}
}
