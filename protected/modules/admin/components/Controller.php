<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
    public $layout='avant';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function init(){
		if(Yii::app()->user->id == 3){
			$this->layout = 'avant';
		}
	}
	
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'roles'=>array('administrator'),
			),
            /*array('deny',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('delete'),
				'roles'=>array('moderator','copywriter'),
			),*/
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'roles'=>array('moderator','copywriter'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
}