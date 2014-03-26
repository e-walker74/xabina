<?php

class MessageController extends Controller
{
    public $layout = 'banking';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow',
                'actions' => array(
                    'index', 'archive', 'draft', 'outbox', 'new', 'save', 'cancel', 'del',
                ),
                'roles' => array('administrator')
            ),
            array('deny',
                'users' => array('*')
            ),
        );
    }

    public function actionNew()
    {
        $model = new Messages();

        $dialog_id_obj = $model->find(array(
            'select' => 'dialog_id',
            'order' => 'dialog_id DESC',
            'limit' => 1
        ));

        $dialog_id = empty($dialog_id_obj->dialog_id) ? 1 : (int)$dialog_id_obj->dialog_id + 1;

        $model->draft = 1;
        $model->dialog_id = $dialog_id;

        $model->user_id = Yii::app()->user->id;
        $model->from_id = Yii::app()->user->id;
        $model->save();

        $model->scenario = 'Save';

        $this->render('new', array(
            'model' => $model,
        ));
    }

    public function actionIndex()
    {
        $condition = 'user_id=:user_id AND from_id=0 AND archive=0 AND subject_id > 0 AND draft=0';
        $params = array(':user_id' => (int)Yii::app()->user->id);

        $data = Messages::model()->getData($condition, $params);

        $this->render('index', array(
            'messages' => $data['messages'],
            'pages' => $data['pages'],
        ));
    }

    public function actionArchive()
    {
        $condition = 'user_id=:user_id  AND archive=1 AND subject_id > 0 AND draft=0';
        $params = array(':user_id' => (int)Yii::app()->user->id);

        $data = Messages::model()->getData($condition, $params);

        $this->render('archive', array(
            'messages' => $data['messages'],
            'pages' => $data['pages'],
        ));
    }

    public function actionDraft()
    {
        $condition = 'user_id=:user_id AND from_id=:from_id AND archive=0 AND subject_id > 0 AND draft=1';
        $params = array(
            ':user_id' => (int)Yii::app()->user->id,
            ':from_id' => (int)Yii::app()->user->id,
        );

        $data = Messages::model()->getData($condition, $params);

        $this->render('draft', array(
            'messages' => $data['messages'],
            'pages' => $data['pages'],
        ));
    }

    public function actionOutbox()
    {
        $condition = 'user_id=:user_id AND from_id=:from_id AND archive=0 AND subject_id > 0 AND draft=0';
        $params = array(
            ':user_id' => (int)Yii::app()->user->id,
            ':from_id' => (int)Yii::app()->user->id,
        );

        $data = Messages::model()->getData($condition, $params);

        $this->render('outbox', array(
            'messages' => $data['messages'],
            'pages' => $data['pages'],
        ));
    }

    public function actionSave()
    {
        $type = Yii::app()->getRequest()->getQuery('type');
        $id = Yii::app()->getRequest()->getQuery('id');

        if ($type === 'save') {
            $draft = 1;
        } elseif ($type === 'send') {
            $draft = 0;
        } else {
            throw new CHttpException(404, Yii::t('Font', 'Page not found'));
        }

        $model = $this->loadModel($id);

        if (!empty($_POST['Messages'])) {

            $model->scenario = 'Save';

            $model->attributes = $_POST['Messages'];
            $model->draft = $draft;
            $model->user_id = Yii::app()->user->id;
            $model->from_id = Yii::app()->user->id;

            if ($model->save()) {
                $this->redirect('/message');
            }

            $this->render('new', array(
                'model' => $model,
            ));

        } else {
            throw new CHttpException(404, Yii::t('Font', 'Page not found'));
        }

    }

    public function actionCancel()
    {
        $id = Yii::app()->getRequest()->getQuery('id');
        $model = $this->loadModel($id);
        if ((int)$model->draft === 1) {
            $model->delete();
            $this->redirect('/message');
        } else {
            // куда?
            $this->redirect('/message');
        }
    }

    public function actionDel()
    {

        if (Yii::app()->request->isAjaxRequest && $_GET['ajax'] == 'messages') {

            $do = empty($_GET['do']) ? 1 : (int)$_GET['do'];
            $model = Messages::model()->findByPk((int)$_GET['del_id']);
            if ($model === null) {
                echo CJSON::encode(array('success' => false));
            }
            // 1 -удалить; 2 -архив
            if ($do === 1) {
                $model->delete();
            } else if ($do === 2) {
                $model->archive = 1;
                $model->save();
            } else {
                echo CJSON::encode(array('success' => false));
            }
            echo CJSON::encode(array('success' => true));

            Yii::app()->end();
        }
    }

    public function loadModel($id)
    {
        $model = Messages::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('Font', 'Page not found'));
        return $model;
    }

}