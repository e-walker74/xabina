<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 16.10.14
 * Time: 15:53
 */

class MaccountsController extends MController {

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
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
                    'index','balance','makePrimary','create',
                ),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function init(){
        Yii::app()->clientScript->registerScriptFile('/js/accounts.js', CClientScript::POS_END);
        return parent::init();
    }

    public function actionIndex()
    {
        $this->breadcrumbs[Yii::t('Front', 'Accounts')] = array(
            'url' => array('/maccounts/index'),
//            'subMenu' => array(
//                Yii::t('Front', 'Home') => array('/banking/index'),
//            ),
        );

        $accounts = new Accounts('search');
        if (isset($_GET['Accounts'])) {
            $accounts->attributes = $_GET['Accounts'];
        }
        $accounts->user_id = Yii::app()->user->id;

        $dataProvider = $accounts->searchWithGroup();

        $currencies = array();
        $account_types = array();
        $statuses = array();
        foreach($dataProvider->getData() as $account){
            $currencies[$account->currency->code] = $account->currency->title;
            $account_types[$account->sub_type] = Yii::t('Accounts', $account->sub_type);
            $statuses[$account->status] = Yii::t('Accounts', Accounts::$status_names[$account->status]);
        }

        if (Yii::request()->isAjaxRequest) {
            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('_items', array('accounts' => $dataProvider), true)
            ));
            Yii::app()->end();
        }

        $this->render('index',
            array(
                'accounts' => $dataProvider,
                'currencies' => $currencies,
                'account_types' => $account_types,
                'statuses' => $statuses
            )
        );
    }

    public function actionMakePrimary()
    {
        if(!Yii::request()->isAjaxRequest){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $id = Yii::request()->getParam('id', '', 'integer');
        $model = Accounts::model()->ownUser()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        Accounts::model()->ownUser()->updateAll(array('is_master' => 0));

        $model->is_master = 1;
        $model->save();

        $accounts = new Accounts('search');
        $accounts->user_id = Yii::app()->user->id;

        $dataProvider = $accounts->searchWithGroup();

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Accounts', 'primary_account_was_changed'),
            'html' => $this->renderPartial('_items', array('accounts' => $dataProvider), true)
        ));
    }

    /**
     * Create new account
     */
    public function actionCreate()
    {

        $this->breadcrumbs[Yii::t('Front', 'Accounts')] = array(
            'url' => array('/maccounts/index'),
        );

        $this->breadcrumbs[Yii::t('Front', 'Open account')] = array(
            'url' => array('/maccounts/create'),
        );

        Yii::app()->clientScript->registerScriptFile('/js/XForms.js');
        $model = new Accounts('create');

        if (Yii::request()->getParam('ajax')) {
            $model->user_id = Yii::user()->id;
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Accounts'])) {
            $model->attributes = $_POST['Accounts'];
            $model->user_id = Yii::user()->id;
            $model->save();
            $this->redirect(array('/accounts/management', 'url' => $model->number));
        }

        $names = Accounts_Names::model()->findAll(
            array(
                'condition' => '(user_id is NULL AND lang = :lang) OR (user_id = :uid)',
                'params' => array(
                    ':lang' => Yii::app()->language,
                    ':uid' => Yii::user()->getCurrentId(),
                )
            )
        );

        $currencies = Currencies::model()->findAll();

        $this->render('create', array('model' => $model, 'names' => $names, 'currencies' => $currencies));
    }

    public function actionBalance(){
        d($_GET);
    }

} 