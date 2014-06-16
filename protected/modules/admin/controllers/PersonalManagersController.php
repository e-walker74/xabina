<?php
    class PersonalManagersController  extends Controller
{
    public function actionCreate(){
        $model=new PersonalManagers;
        //$model->scenario = 'personalManagerCreate';

        // if it is ajax validation request
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'personal-managers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(!empty($_POST['PersonalManagers'])) {
            $model->attributes=$_POST['PersonalManagers'];

            if(!count($model->getErrors()) && $model->validate() && $model->save()){
                $this->redirect(array('/admin/PersonalManagers/update', 'id' => $model->id));
            }

        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

        public function actionUpdate($id)
        {
            $model=new PersonalManagers;
            $model = $model->findByPk($id);

            if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'personal-managers-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if(isset($_POST['PersonalManagers']))
            {
                if ($_POST['PersonalManagers']['is_default']) {
                    $model->updateAll(array('is_default' => 0, 'is_default = 1'));
                }
                $model->attributes=$_POST['PersonalManagers'];
                if($model->save()){
                    $this->redirect(array('/admin/personalManagers/manage/'));
                }
            }

            $this->render('update',array(
                'model'=>$model
            ));
        }

        public function actionManage(){
            $model = new PersonalManagers('search');

            $model->unsetAttributes();
            if(isset($_GET['PersonalManagers'])){
                $model->attributes=$_GET['PersonalManagers'];
            }

            $this->render('manage', array('model' => $model));
        }

} 