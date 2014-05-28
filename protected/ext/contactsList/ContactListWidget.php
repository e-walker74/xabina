<?php
class ContactListWidget extends QWidget {
	
	private $_criteria;
	
	public $withAlphabet = true;
	public $type = 'contactList';
	
    public function run()
    {
		$this->_criteria = new CDbCriteria();
		$this->_criteria->order = 'fullname asc';
		if($qname = Yii::app()->request->getParam('qname')){
			$this->_criteria->compare('fullname', $qname, true);
		}
	
		if(!Yii::app()->request->isAjaxRequest){
			$cs = Yii::app()->clientScript;
			$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
			$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
			$cs->registerScriptFile($url.'/contactList.js', CClientScript::POS_END);
		}
    }
	
	public function html(){
		if($this->withAlphabet){
			$this->render('alphabet', array());
		}
		$fname = 'render'.$this->type;
		$this->{$fname}();
	}
	
	public function renderContactList($return = false, $processOutput = false){
		
		$model = Users_Contacts::model()->currentUser()->with('data')->findAll($this->_criteria);
		return $this->render($this->type, array('model' => $model), $return, $processOutput);
	}
}
