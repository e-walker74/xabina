<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    public $title;
    public $keywords;
    public $description;

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init()
    {
        if (!Yii::app()->user->isGuest && Yii::app()->user->getThisIp() != ip2long(Yii::app()->request->getUserHostAddress())) {
            //Yii::app()->user->logout();
        }
        $this->registerGlobalStyles();
        if(Yii::request()->isAjaxRequest){
            $this->cleanResponseJs();
        }

        if(!Yii::app()->user->isGuest){
            Zone::setUserTimeZone(Yii::user()->getTimeZone());
        }

        return parent::init();
    }

    protected function registerGlobalStyles()
    {

        if (!Yii::app()->request->isAjaxRequest && !Yii::app()->request->getParam('file-upload')) {
            Yii::app()->clientScript->registerCssFile("/css/jquery.pnotify.default.css");
            Yii::app()->clientScript->registerCssFile("/default/css/bootstrap.min.css");
            Yii::app()->clientScript->registerCssFile("/css/fonts.css");
            Yii::app()->clientScript->registerCssFile("/css/media.css");
            if ($this->id !== 'rbac') {
                Yii::app()->clientScript->registerCssFile("/js/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css");
            }
            Yii::app()->clientScript->registerCssFile("/css/bg.css");
        }
    }

    protected function cleanResponseJs()
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
    }

}