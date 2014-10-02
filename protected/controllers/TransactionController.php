<?php

class TransactionController extends Controller
{

    public $layout = 'banking';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
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
                'actions' => array('link'),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
                    'info',
                ),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionInfo($id)
    {
        $this->breadcrumbs[Yii::t('Front', 'Accounts')] = array('/accounts/index');
        $this->breadcrumbs[Yii::t('Front', 'Balance')] = array('/accounts/cardbalance');
        $this->breadcrumbs[Yii::t('Front', 'Transaction details')] = '';

        $model = Transactions::model()->with('account')->findByAttributes(array('url' => $id));

        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        if ($model->account->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        Yii::app()->clientScript->registerScriptFile('/js/scripts_transaction.js');
        Yii::app()->clientScript->registerCssFile('/js/redactor/redactor.css');
        Yii::app()->clientScript->registerScriptFile('/js/redactor/redactor.js');

        $this->render('info', array('model' => $model));
    }

    public function actionLink()
    {
        $entity = Yii::request()->getParam('entity', '', 'list', array('transactions'));
        $entity_id = Yii::request()->getParam('entity_id', '', 'int');

        $listFiles = Yii::request()->getParam('transactions');

        foreach ($listFiles as $file) {
            try {
                $cross = new CrossLinks();
                $cross->entity_id = $entity_id;
                $cross->entity_name = $entity;
                $cross->link_table_id = $file;
                $cross->link_table_name = 'transactions';
                $cross->user_id = Yii::user()->getCurrentId();
                $cross->save();
            } catch (CException $e) {
//                echo CJSON::encode(
//                    array(
//                        'success' => false,
//                        'message' => Yii::t('Drive', 'this_file_was_not_added')
//                    )
//                );
//                Yii::app()->end();
            }
        }

        $html = Widget::create(
            'WLinkTransactions', 'WLinkTransactions',
            array()
        )->renderTransactionsTrans($entity_id, true);

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Category', 'category_was_added'),
            'html' => $html,
        ));
    }

    public function actionPrint(){

    }
}