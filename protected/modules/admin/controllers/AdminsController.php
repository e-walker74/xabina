<?php

class AdminsController extends Controller
{

    public function actionCreate(){
        $model = new Admins;

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'admins-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Admins'])){
            $model->attributes = $_POST['Admins'];
            if($model->save())
                $this->redirect('/admin/admins/manage');
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id){
        $model = Admins::model()->findByPk($id);
        if(!$model){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'admins-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Admins'])){
            $model->attributes = $_POST['Admins'];
            if($model->save())
                $this->redirect('/admin/admins/manage');
        }

        $this->render('update', array('model' => $model));
    }

    public function actionManage(){
        $model = new Admins('search');

        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['Admins'])){
			$model->attributes=$_GET['Admins'];
		}

        $this->render('manage', array('model' => $model));
    }

}