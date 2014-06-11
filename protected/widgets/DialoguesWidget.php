<?php
class DialoguesWidget extends QWidget {
	
	private $_criteria;
	
	public $entity_type = false;
	public $entity_id = false;
	
    public function run()
    {
		
	}
	
	public function html(){
		
		if($this->entity_type === false || $this->entity_id === false){
			return false;
		}
		
		$this->render('dialogues/html', array(''));
	}
	
	public function renderContactList($return = false, $processOutput = false){
		if($this->withAlphabet){
			$this->render('contactsList/alphabet', array());
		}
		$this->_criteria->order = 'fullname asc';
		if($qname = Yii::app()->request->getParam('qname')){
			$this->_criteria->compare('fullname', $qname, true);
		}
		$model = Users_Contacts::model()->currentUser()->with('data')->findAll($this->_criteria);
		return $this->render('contactsList/contactList', array('model' => $model), $return, $processOutput);
	}
	
	public function renderSearchHolders($return = false, $processOutput = false){

		$this->_criteria->order = 'fullname asc';
		$this->_criteria->compare('data.data_type', 'account');
		$this->_criteria->together = true;
		$this->_criteria->with = 'data';
		if($qname = Yii::app()->request->getParam('qname')){
			$this->_criteria->compare('fullname', $qname, true);
		}
		
		$model = Users_Contacts::model()->currentUser()->with('data')->findAll($this->_criteria);
		if($return){
			return array('success' => !empty($model), 'html' => $this->render('contactsList/searchHolders', array('model' => $model), $return, $processOutput));
		} else {
			$this->render('contactsList/searchHolders', array('model' => $model), $return, $processOutput);
		}
	}
	
	public function renderTransfersByAccount($model, $return = false, $processOutput = false){
		if($return){
			return array('success' => !empty($model), 'html' => $this->render('contactsList/transfersByAccount', array('model' => $model), $return, $processOutput));
		} else {
			$this->render('contactsList/transfersByAccount', array('model' => $model), $return, $processOutput);
		}
	}
	
	public function renderSearchTransfers($return = false, $processOutput = false){
		$model = array();
		$this->_criteria->order = 'to_account_holder asc';
		$this->_criteria->compare('need_confirm', 0);
		if($qnumber = Yii::app()->request->getParam('qnumber')){
			$this->_criteria->compare('to_account_number', $qnumber, true);
		}
		if($qholder = Yii::app()->request->getParam('qholder')){
			$this->_criteria->compare('to_account_holder', $qholder, true);
		}
		$model = Transfers_Outgoing::model()->currentUser()->findAll($this->_criteria);
		if($return){
			return array('success' => !empty($model), 'html' => $this->render('contactsList/searchTransfers', array('model' => $model), $return, $processOutput));
		} else {
			$this->render('contactsList/searchTransfers', array('model' => $model), $return, $processOutput);
		}
	}
	
	public function renderSeachContactByName($return = false, $processOutput = false){
		$model = array();
		$this->_criteria->order = 'fullname asc';
		$this->_criteria->together = true;
		$this->_criteria->with = 'data';
		$model = Users_Contacts::model()->currentUser()->findAll($this->_criteria);
		$this->render('contactsList/seachContactByName', array('model' => $model), $return, $processOutput);
	}
}
