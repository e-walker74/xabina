<?php

class InvoicesController extends Controller
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

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
			array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
					'create',
					'createOption',
					'list',
				),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

	public function init() {
	}
	
	public function actionCreate() {
		Yii::app()->clientScript->registerScriptFile('/js/invoice.js', CClientScript::POS_END);

        $this->breadcrumbs[Yii::t('Front', 'Create an Invoice')] = '';

        $model = new Form_Invoice;
        // if it is ajax validation request
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax')=='invoice-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        $user = Users::model()->findByPk(Yii::app()->user->id);
        $model->currency_id = $user->settings->currency_id;
        $model->user_id = Yii::app()->user->id;
        
        $file = new Users_Files;
        if (!empty($_POST['Form_Invoice'])) {

            $model->attributes = $_POST['Form_Invoice'];
            $model->options = $_POST['Invoices_Options'];
            if ($model->validate() && $model->invoiceCreate()) {
				$aRes = array(
					'success' => true, 
					'message' => Yii::t('Front', 'New invoice saved successful')
				);
				if (isset($_GET['next'])) {
					$aRes['url'] = $this->createUrl('/invoices/list');
				}
				echo CJSON::encode($aRes);
            } else {
				echo CJSON::encode(array(
					'success' => false,
					'message' => Yii::t('Front', 'Total is incorrect')
				));
			}
			Yii::app()->end();
        }
        // Вывод ошибок
        // Редирект или нотификация при сохранении формы
        // Страница списка с инвойсами
        $this->render('create_invoice', array(
            'model' => $model,
            'user' => $user,
            'file' => $file,
        ));
    }

    public function actionCreateOption() {
        $model = new Invoices_Options;
        $this->renderPartial('invoice_options', array('model' => $model));
    }

	public function actionList(){
		$this->breadcrumbs[Yii::t('Front', 'Invoices List')] = '';

		$model = Invoices::model()->currentUser()->with(array('user', 'currency'))->findAll();

		$this->render('list', array('model' => $model));
	}
}