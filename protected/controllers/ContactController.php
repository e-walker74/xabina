<?php

class ContactController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function filters()
    {
        return array(
            'accessControl',
            /*array(
            	'application.components.RbacFilter'
        	),*/
        );
    }
	
	public function init(){
		Yii::import("application.ext.contactsList.*");
		return parent::init();
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
			array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
					'index',
					'search',
					'searchholders',
					'searchtransfers',
					'update',
					'view',
					'analytics',
				),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

	public function actionIndex(){
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = '';
		$this->render('index');
	}

	public function actionSearch(){
		$html = Widget::create('ContactListWidget', 'ContactListWidget')->renderContactList(true);
		echo CJSON::encode(array('success' => true, 'html' => $html));
		Yii::app()->end();
	}
	
	public function actionSearchHolders(){
		if(Yii::app()->request->getParam('qAccountNumber') 
			&& Yii::app()->request->getParam('qAccountEType')){
			$transfers = Transfers_Outgoing::model()->with('currency')->currentUser()->findAll(
				array(
					'condition' => 'to_account_number = :account AND status = 1 AND ewallet_type = :ewallet_type',
					'params' => array(
						':account' => Yii::app()->request->getParam('qAccountNumber'),
						':ewallet_type' => Yii::app()->request->getParam('qAccountEType'),
					),
					'order' => 'execution_date desc',
				)
			);
			echo CJSON::encode(Widget::create('ContactListWidget', 'ContactListWidget', array())->renderTransfersByAccount($transfers, true));
			Yii::app()->end();
		}
		echo CJSON::encode(Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'searchHolders'))->renderSearchHolders(true));
		Yii::app()->end();
	}
	
	public function actionSearchTransfers(){
		echo CJSON::encode(Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'searchtransfers'))->renderSearchTransfers(true));
		Yii::app()->end();
	}
	
	public function actionAnalytics($id){
		$search = new Form_Contact_Analytics;

		$search->from_date = time()-3600*24*30;
		$search->to_date = time();
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'analytics-form') {
            $search->attributes = $_POST['Form_Contact_Analytics'];
			$search->contact_id = $id;
			echo CActiveForm::validate($search, NULL, false);
            Yii::app()->end();
        }
		if (isset($_POST['Form_Contact_Analytics'])) {
			$search->attributes = $_POST['Form_Contact_Analytics'];
			$search->contact_id = $id;
			echo CJSON::encode(array('success' => true, 'html' => $this->renderPartial('_analytics/table', array('search' => $search), true, true)));
		}
		Yii::app()->end();
		
	}
	
	public function actionView($id){
		Yii::app()->clientScript->registerScriptFile('/js/contacts.js');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
		
		$model = Users_Contacts::model()->currentUser()->with('data')->findByPk($id);
		
		$this->breadcrumbs[$model->fullname] = '';
		
		$search = new Form_Contact_Analytics;

		$search->from_date = time()-3600*24*30;
		$search->to_date = time();
		$search->contact_id = $id;

		$this->render('view', array('model' => $model, 'search' => $search));
	}
	
	public function actionUpdate($id){
	
		Yii::app()->clientScript->registerScriptFile('/js/contacts.js');
		
		$model = Users_Contacts::model()->currentUser()->findByPk($id);
	
		$this->render('update', array('model' => $model));
	}
}