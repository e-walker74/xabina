<?php

class ContactController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function filters()
    {
        return array(
            'accessControl',
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
					'create',
					'delete',
					'DeleteData',
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
	
	public function actionView($url){
		Yii::app()->clientScript->registerScriptFile('/js/contacts.js');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
		
		$model = Users_Contacts::model()->currentUser()->with('data')->findByAttributes(array('url' => $url));
		
		if(!$model){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		
		$id = $model->id;
		
		$this->breadcrumbs[$model->fullname] = '';
		
		$search = new Form_Contact_Analytics;

		$search->from_date = time()-3600*24*30;
		$search->to_date = time();
		$search->contact_id = $id;

		$this->render('view', array('model' => $model, 'search' => $search));
	}
	
	public function actionCreate(){
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new contact'))] = '';
		
		Yii::app()->clientScript->registerScriptFile('/js/contacts.js');
		
		$model = new Users_Contacts;
		
		if (isset($_POST['Users_Contacts']) && Yii::app()->request->getParam('ajax') === 'contact-form') {
			echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['Users_Contacts']))
        {
            $this->saveContact($model);
        }
		
		$this->render('create', array('model' => $model));
	}
		
	public function actionUpdate($url){
		Yii::app()->clientScript->registerScriptFile('/js/contacts.js');
		
		$model = Users_Contacts::model()->currentUser()->with('data')->findByAttributes(array('url' => $url));
		
		if(!$model){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', $model->fullname))] = array('/contact/view', 'url' => $model->url);
		$this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Edit'))] = '';
		
		$id = $model->id;
		if(Yii::app()->request->getParam('ajax') == 'contact-form' && isset($_POST['Users_Contacts'])){
			echo CActiveForm::validate($model);
            Yii::app()->end();
		}
		
		if(isset($_POST['Users_Contacts']))
        {
            $this->saveContact($model);
        }
		
		if(count($_POST) && Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('ajax')){
			echo Users_Contacts_Data::validateData();
			Yii::app()->end();
		}
		
		if(count($_POST) && Yii::app()->request->isAjaxRequest){
			$this->cleanResponseJs();
			echo Users_Contacts_Data::saveData($id);
			Yii::app()->end();
		}
	
		$this->render('update', array('model' => $model));
	}
	
	protected function saveContact($model){
		$model->attributes=$_POST['Users_Contacts'];
		$model->user_id = Yii::app()->user->getCurrentId();
		if($model->save())
		{
			if(isset($_FILES['Users_Contacts']) && $_FILES['Users_Contacts']['tmp_name']['photo']){
				$image = Yii::app()->image->load($_FILES['Users_Contacts']['tmp_name']['photo']);
				$image->resize(80, 80, Image::MAX)->crop(80, 80)->quality(75);
				$folder = Yii::app()->getBasePath(true) . '/../images/contacts/'.$model->user_id.'/'.$model->id.'/';
				$name = md5(time()).'.'.$image->getImageExt();
				@mkdir($folder, 0775, 1);
				$image->save($folder.$name);
				$model->photo = $name;
				$model->save();
			}
			if($model->delete == 1){
				$model->photo = '';
				$model->save();
			}

			Yii::app()->session['flash_notify'] = array(
				'title' => Yii::t('Front', 'Edit Contact'),
				'message' => Yii::t('Front', 'Contact successfully saved'),
			);
			$this->redirect(array('/contact/update', 'url' => $model->url));
		}
	}
	
	public function actionDelete($id){
		Users_Contacts::model()->currentUser()->deleteByPk($id);
		$this->redirect(array('/contact/index'));
	}
	
	public function actionDeleteData($id){
		$type = Yii::app()->request->getParam('type', '', 'list', array(
			'instmessaging',
			'contact',
			'account',
			'email',
			'phone',
			'address',
			'default',
			'social',
			'urls',
			'dates',
		));
		$model = Users_Contacts_Data::model()->with('contact')->findByAttributes(
			array(
				'id' => $id,
				'data_type' => $type,
			)
		);
		if(!$type || !$id || !$model || $model->contact->user_id != Yii::app()->user->getCurrentId()){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		echo CJSON::encode(array('success' => $model->delete(), 'mesTitle' => Yii::t('Front', 'Contact'), 'message' => Yii::t('Front', 'Entity was deleted')));
	}
}