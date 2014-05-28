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
		$q = Yii::app()->request->getParam('query');
		$html = Widget::create('ContactListWidget', 'ContactListWidget')->renderContactList(true);
		echo CJSON::encode(array('success' => true, 'html' => $html));
		Yii::app()->end();
	}
}