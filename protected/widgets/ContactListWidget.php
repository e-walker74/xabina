<?php

class ContactListWidget extends QWidget
{

    public $withAlphabet = true;
    public $type = '';
    public $withOut = array();
    private $_criteria;

    public function run()
    {
        $this->_criteria = new CDbCriteria();
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
            $cs->registerScriptFile($url . '/contactList.js', CClientScript::POS_END);
            $cs->registerScriptFile('/js/jquery.scrollTo.min.js', CClientScript::POS_END);
            $cs->registerScriptFile('/js/bootstrap-tokenfield.min.js', CClientScript::POS_END);
            $cs->registerCssFile('/css/bootstrap-tokenfield.css');
        }
    }

    public function html()
    {

        $fname = 'render' . $this->type;
        $this->{$fname}();
    }

    public function renderContactList($return = false, $processOutput = false)
    {
        if ($this->withAlphabet) {
            $this->render('contactsList/alphabet', array());
        }
        $this->_criteria->order = 'fullname asc';
        if (substr_count($_SERVER['REQUEST_URI'], '/dialogs'))
            $this->_criteria->condition='xabina_id>0';        
        if ($qname = Yii::app()->request->getParam('qname')) {
            $this->_criteria->compare('fullname', $qname, true);
        }
        $model = Users_Contacts::model()->currentUser()->with('data')->findAll($this->_criteria);
        return $this->render('contactsList/contactList', array('model' => $model), $return, $processOutput);
    }

    public function renderContactListForSend($return = false, $processOutput = false)
    {
        if ($this->withAlphabet) {
            $this->render('contactsList/alphabet', array());
        }
        $this->_criteria->order = 'fullname asc';
        //if (substr_count($_SERVER['REQUEST_URI'], '/dialogs'))
        //    $this->_criteria->condition='xabina_id>0';
        if ($qname = Yii::app()->request->getParam('qname')) {
            $this->_criteria->compare('fullname', $qname, true);
        }
        $model = Users_Contacts::model()->currentUser()->with('data')->findAll($this->_criteria);
        return $this->render('contactsList/contactListForSend', array('model' => $model), $return, $processOutput);
    }

    public function renderSearchHolders($return = false, $processOutput = false)
    {

        $this->_criteria->order = 'fullname asc';
        $this->_criteria->compare('data.data_type', 'account');
        $this->_criteria->together = true;
        $this->_criteria->with = 'data';
        if ($qname = Yii::app()->request->getParam('qname')) {
            $this->_criteria->compare('fullname', $qname, true);
        }

        $model = Users_Contacts::model()->currentUser()->with('data')->findAll($this->_criteria);
        if ($return) {
            return array('success' => !empty($model), 'html' => $this->render('contactsList/searchHolders', array('model' => $model), $return, $processOutput));
        } else {
            $this->render('contactsList/searchHolders', array('model' => $model), $return, $processOutput);
        }
    }

    public function renderTransfersByAccount($model, $return = false, $processOutput = false)
    {
        if ($return) {
            return array('success' => !empty($model), 'html' => $this->render('contactsList/transfersByAccount', array('model' => $model), $return, $processOutput));
        } else {
            $this->render('contactsList/transfersByAccount', array('model' => $model), $return, $processOutput);
        }
    }

    public function renderSearchTransfers($return = false, $processOutput = false)
    {
        $model = array();
        $this->_criteria->order = 'to_account_holder asc';
        $this->_criteria->compare('need_confirm', 0);
        if ($qnumber = Yii::app()->request->getParam('qnumber')) {
            $this->_criteria->compare('to_account_number', $qnumber, true);
        }
        if ($qholder = Yii::app()->request->getParam('qholder')) {
            $this->_criteria->compare('to_account_holder', $qholder, true);
        }
        $model = Transfers_Outgoing::model()->currentUser()->findAll($this->_criteria);
        if ($return) {
            return array('success' => !empty($model), 'html' => $this->render('contactsList/searchTransfers', array('model' => $model), $return, $processOutput));
        } else {
            $this->render('contactsList/searchTransfers', array('model' => $model), $return, $processOutput);
        }
    }

    public function renderSeachContactByName($return = false)
    {
        $this->_criteria->order = 'fullname asc';
        $this->_criteria->together = true;
        $this->_criteria->with = 'data';
        $model = Users_Contacts::model()->currentUser()->findAll($this->_criteria);
        $this->render('contactsList/seachContactByName', array('model' => $model), $return);
    }

    public function renderLinkContacts($return = false, $entity = false, $entity_id = false)
    {
        $this->_criteria->order = 'fullname asc';
        $this->_criteria->together = true;
        $this->_criteria->with = 'data';
        $model = Users_Contacts::model()->currentUser()->findAll($this->_criteria);
        return $this->render('contactsList/linkContacts', array('model' => $model, 'entity' => $entity, 'entity_id' => $entity_id), $return);
    }

    public function renderPupUpSearch($return = false)
    {
        $this->_criteria->order = 'fullname asc';
        $this->_criteria->together = true;
        $this->_criteria->with = 'data';
        foreach ($this->withOut as $id) {
            $this->_criteria->compare('contact_id', '<>' . $id);
        }
        $model = Users_Contacts::model()->currentUser()->findAll($this->_criteria);
        $this->render('contactsList/pop_up', array('model' => $model), $return);
    }
}
