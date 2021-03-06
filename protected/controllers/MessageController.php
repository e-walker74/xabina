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
                    'index', 'view', 'archive', 'draft', 'outbox', 'new', 'save', 'cancel', 'del',
                ),
                'roles' => array('client')
            ),
            array('deny',
                'users' => array('*')
            ),
        );
    }
	
	public function init(){
		Yii::app()->clientScript->registerScriptFile('/js/messages.js');
		return parent::init();
	}

    public function actionNew()
    {
        $mess_id = Yii::app()->getRequest()->getQuery('id', '0', 'int');

        $model = new Messages();

        if(!$mess_id){
			$dialog_id_obj = $model->find(array(
				'select' => 'dialog_id',
				'order' => 'dialog_id DESC',
				'limit' => 1
			));

			$model->dialog_id = empty($dialog_id_obj->dialog_id) ? 1 : (int)$dialog_id_obj->dialog_id + 1;
        } else {
			$last = Messages::model()->findByPk($mess_id);
			if($last->user_id != Yii::app()->user->id){
				throw new CHttpException(404, Yii::t('Front', 'Page not found'));
			}
			$model->dialog_id = $last->dialog_id;

			$model->to = $last->from;
			$model->subject = $last->subject;
		}

        $model->draft = 1;
//        $model->dialog_id = $dialog_id;

        $model->user_id = Yii::app()->user->id;
        $model->from_id = Yii::app()->user->id;
        $model->save();
		
		$this->redirect(array('/message/save', 'type' => 'edit', 'id' => $model->id));
    }

    public function actionIndex()
    {
        $sql = "SELECT t1.* FROM messages t1
                  INNER JOIN (SELECT dialog_id, MAX(updated_at) updated_at FROM messages WHERE user_id=:user_id AND draft=0 AND sended=1 AND from_id != :user_id GROUP BY dialog_id) t2
                    ON t1.dialog_id = t2.dialog_id AND t1.updated_at = t2.updated_at
                WHERE
                archive=0 AND
				user_id != from_id AND
				user_id = :user_id AND
                sended=1
                ORDER BY sent_at DESC";

        $messages = Messages::model()->findAllBySql($sql, array(
                ':user_id' => (int)Yii::app()->user->id)
        );

        $this->render('index', array(
            'messages' => $messages,
            'pages' => NULL,
        ));

    }

    public function actionView()
    {
        $id = (int)Yii::app()->getRequest()->getQuery('id');
        $archive = 0;
		$type = false;
        $model = $this->loadModel($id);
		
		if($model->from_id != Yii::app()->user->id){
			$type = 'inbox';
		}
		if($model->archive){
			$type = 'archive';
			$archive = 1;
		}
		
		if($model->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Page not found'));
		}
		
        //прочитано
		if($model->opened == 0){
			$model->opened = 1;
			$model->save();
		}
        
        $this->render('view', array(
            'model' => $model,
            'type' => $type,
            'dialogs' => Messages::model()->getDialog($model->dialog_id, $model->id, $archive),
        ));
    }

    /**
     * Все удаленные сообщения
     */
    public function actionArchive()
    {
        $sql = "SELECT t1.* FROM messages t1
          INNER JOIN (SELECT dialog_id, MAX(updated_at) updated_at FROM messages WHERE user_id =:user_id AND draft=0 GROUP BY dialog_id) t2
            ON t1.dialog_id = t2.dialog_id AND t1.updated_at = t2.updated_at
        WHERE
        archive=1 AND
        draft=0 AND 
		user_id = :user_id
        ORDER BY updated_at DESC";

        $messages = Messages::model()->findAllBySql($sql, array(
                ':user_id' => (int)Yii::app()->user->id)
        );

        $this->render('archive', array(
            'messages' => $messages,
            'pages' => NULL,
        ));
    }

    /**
     * Все черновики
     */
    public function actionDraft()
    {
        $condition = 'user_id=:user_id AND from_id=:from_id AND archive=0 AND draft=1';
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

    /**
     * Последние отправленные из диалога
     */
    public function actionOutbox()
    {

        $sql ="SELECT t1.* FROM messages t1
          INNER JOIN (SELECT dialog_id, MAX(updated_at) updated_at FROM messages where user_id=:user_id AND from_id = user_id AND draft=0 AND sended = 1 GROUP BY dialog_id) t2
            ON t1.dialog_id = t2.dialog_id AND t1.updated_at = t2.updated_at
        WHERE
        archive=0 AND
        from_id=:user_id AND
        draft=0 AND
		user_id = from_id AND
		sended=1
        ORDER BY sent_at DESC";

        $messages = Messages::model()->findAllBySql($sql, array(
                ':user_id' => (int)Yii::app()->user->id,
            )
        );

        $this->render('outbox', array(
            'messages' => $messages,
            'pages' => null,
        ));
    }

    public function actionSave()
    {
        $type = Yii::app()->getRequest()->getQuery('type');
        $id = Yii::app()->getRequest()->getQuery('id');

        $model = $this->loadModel($id);
		
		$prevMessage = Messages::model()->find(array(
			'condition' => 'dialog_id = :did AND id != :tid',
			'params' => array(':did' => $model->dialog_id, ':tid' => $model->id),
			'order' => 'created_at desc',
		));
		
		if($prevMessage){
			$model->subject = $prevMessage->subject;
			$model->to = $prevMessage->to;
		}
		
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'messages') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Messages'])) 
		{
		
            $model->attributes = $_POST['Messages'];
            $model->draft = $type === 'save' ? 1 : 0;
			$model->sended = $type === 'send' ? 1 : 0;
            $model->user_id = Yii::app()->user->id;
            $model->from_id = Yii::app()->user->id;
			
			$models = array();
			
			$toArray = explode(',', trim($model->to));
			$transaction=$model->dbConnection->beginTransaction();
			$save = true;
			foreach($toArray as &$to){
				$to = trim($to);
				$newModel = new Messages;
				$newModel->attributes = $model->attributes;
				$newModel->from = Users::model()->findByPk(Yii::app()->user->id)->login;
				$newModel->from_id = Yii::app()->user->id;
				$newModel->to = $to;
				$newModel->sended = 1;
				$newModel->draft = 0;
				$newModel->sent_at = time();
				if(is_numeric($to)){
					$newModel->user_id = Users::model()->find('login = :login', array(':login' => $to))->id;
				} else {
					$newModel->user_id = 0;
				}
				if(!$newModel->save()){
					$save = false;
				}
			}
			$model->sent_at = time();
			if($model->save() && $save)
				$transaction->commit();
			else
				$transaction->rollback();
			
            if ($model->save()) {
                if ($type === 'save') {
                    $this->redirect('/message/draft/');
                } else if ($type === 'send') {
                    $this->redirect('/message/outbox/');
                } else {
                    $this->redirect('/message/');
                }
            }
        }

        $this->render('new', array(
            'model' => $model,
            'dialogs' => Messages::model()->getDialog($model->dialog_id, $model->id),
            'id' => $id
        ));

    }

    /**
     * Удаляем навсегда только черонвики.
     * @throws CHttpException
     */
    public function actionCancel()
    {
        $id = Yii::app()->getRequest()->getQuery('id');
        //die;
        $model = $this->loadModel($id);
        if ((int)$model->draft === 1) {
            $model->delete();
            $this->redirect('/message/');
        } else {
            $this->redirect('/message/');
        }
    }

    /**
     * Править
     * @throws CHttpException
     */
    public function actionDel()
    {
        if (!empty($_GET['do']) && !empty($_GET['del_id'])) {

            $do = (int)$_GET['do'];
            $del_id = $_GET['del_id'];

            $model = Messages::model()->findByPk($del_id);

            if(empty($model) || $model->user_id != (int)Yii::app()->user->id) die;

            // 1 -удалить сообщение ; 2 -положить сообщение архив; 3 - положить в архив сообщение и его диалоги
            if ($do === 1) {
                $model->delete();
            }
            else if ($do === 2) {
                $model->archive = 1;
                $model->save();
            }
            else if ($do === 3) {
                $model = Messages::model()->updateAll(array('archive' => 1), 'dialog_id=:dialog_id', array(':dialog_id' => $model->dialog_id));
            }

            if (Yii::app()->request->isAjaxRequest && $_GET['ajax'] == 'messages') {
                echo empty($model) ? CJSON::encode(array('success' => false)) : CJSON::encode(array('success' => true));
            }
            else {
                if (empty($model)) {
                    throw new CHttpException(404, Yii::t('Font', 'Page not found'));
                } else {
                    if($do === 1){
                        $this->redirect('/message/');
                    }
                    else{
                        $this->redirect('/message/archive/');
                    }
                }
            }

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