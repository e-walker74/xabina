<?php

class PagesController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function filters()
    {
        return array(
            //'accessControl',
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
                'actions' => array('index'),
                'users' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($url)
    {
		$this->breadcrumbs[Yii::t('Front', $url)] = '';
		$this->render('index', array('url' => $url));
    }
}
