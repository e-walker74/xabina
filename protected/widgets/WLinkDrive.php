<?php

/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.09.14
 * Time: 18:21
 */
class WLinkDrive extends QWidget
{

    private $_memos = false;
    private $_files = false;

    public function init()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
            $cs->registerScriptFile($url . '/linkDrive.js');
        }
    }

    public function getMemos($entity, $entityId)
    {
        if ($this->_memos !== false) {
            return $this->_memos;
        }
        $model = Users_Files::model()->currentUser()->with('user')->findAllBySql(
            "SELECT uf.*, cl.entity_id as model_id, cl.entity_name as form, cl.id as cross_id, cl.category_id as cross_category,
                cl.comment as cross_comment FROM users_files uf
            INNER JOIN cross_links cl ON (uf.id = cl.link_table_id)
            WHERE uf.deleted = 0
            AND uf.user_id = :user_id
            AND cl.entity_id = :entity_id
            AND cl.entity_name = :entity
            AND cl.link_table_name = :link_name
            ORDER BY cl.id desc",
            array(
                ':user_id' => Yii::user()->getCurrentId(),
                ':entity_id' => $entityId,
                ':entity' => $entity,
                ':link_name' => 'users_files_memo',
            )
        );

        $this->_memos = array();
        foreach($model as $m){
            $this->_memos[$m->id] = $m;
        }

        return $this->_memos;
    }

    public function renderTransactionMemo($transactionId, $return = false)
    {

        $model = $this->getMemos('transactions', $transactionId);

        return $this->render('linkDrive/transactionsMemo', array('transaction_id' => $transactionId, 'model' => $model), $return);
    }

    public function renderAddNewMemo($entity, $entity_id, $htmlID, $return = false)
    {
        if (!$return) {
            Yii::app()->clientScript->registerCssFile('/js/redactor/redactor.css');
            Yii::app()->clientScript->registerScriptFile('/js/redactor/redactor.js');
            Yii::app()->clientScript->registerScriptFile('/js/redactor/plugins/fontcolor/fontcolor.js');
            Yii::app()->clientScript->registerScriptFile('/js/redactor/plugins/fontsize/fontsize.js');
        }

        return $this->render('linkDrive/newMemoPopup',
            array(
                'entity' => $entity,
                'entity_id' => $entity_id,
                'htmlID' => $htmlID
            ),
            $return
        );
    }

    public function getFiles($entity, $entityId)
    {
        if ($this->_files !== false) {
            return $this->_files;
        }
        $model = Users_Files::model()->currentUser()->with('user')->findAllBySql(
            "SELECT uf.*, cl.entity_id as model_id, cl.entity_name as form, cl.id as cross_id, cl.category_id as cross_category,
                cl.comment as cross_comment FROM users_files uf
            INNER JOIN cross_links cl ON (uf.id = cl.link_table_id AND cl.link_table_name = 'users_files')
            WHERE uf.deleted = 0
            AND uf.user_id = :user_id
            AND uf.document_type != 'memo'
            AND uf.name != ''
            AND cl.entity_id = :entity_id
            AND cl.entity_name = :entity
            ORDER BY cl.id desc",
            array(
                ':user_id' => Yii::user()->getCurrentId(),
                ':entity_id' => $entityId,
                ':entity' => $entity,
            )
        );

        if(!$model){
            $this->_files = $model;
        }

        foreach($model as $m){
            $this->_files[$m->id] = $m;
        }

        return $this->_files;
    }

    public function renderTransactionsFiles($transactionId, $return = false)
    {
        $model = $this->getFiles('transactions', $transactionId);

        return $this->render('linkDrive/transactionsFiles', array(
                'model' => $model,
            ),
            $return
        );
    }

    public function renderLinkMemoPopup($entity, $entity_id, $htmlID = 'linkNewMemoModal', $folder = 0, $return = false)
    {
        $this->render('linkDrive/linkMemoPopup', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
                'htmlID' => $htmlID,
                'folder' => $folder,
            ),
            $return
        );
    }

    public function renderMemoGridInPopup($folder = 0, $return = false, $entity = false, $entityId = false){

        if(Yii::request()->getParam('sorting', '')){
            $sort = Yii::request()->getParam('sort', 'asc', 'list', array('asc', 'desc'));
            $param = Yii::request()->getParam('param', 'user_file_name', 'list', array('user_file_name', 'description', 'created_at', 'file_size'));
            $order = $param . ' ' . $sort;
        } else {
            $order = 't.document_type asc, t.id desc';
        }

        $files = Users_Files::model()
            ->currentUser()
            ->with(array('memos_children'))
            ->together()
            ->findAll(
                array(
                    'condition' => 't.deleted = 0 AND t.parent_id = :folder AND (t.document_type = "memo" OR t.document_type = "folder")',
                    'order' => $order,
                    'params' => array(':folder' => $folder),
                )
            );

        return $this->render('linkDrive/_memosGrid', array(
                'files' => $files,
                'folder' => $folder,
                'entity' => $entity,
                'entityId' => $entityId,
            ),
            $return
        );
    }

    public function renderLinkFilesPopup($entity, $entity_id, $htmlID = 'addNewFileModal', $folder = 0, $return = false)
    {
        $this->render('linkDrive/linkFilesPopup', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
                'htmlID' => $htmlID,
                'folder' => $folder,
            ),
            $return
        );
    }

    public function renderFilesGridInPopup($folder = 0, $return = false, $entity = false, $entityId = false){

        if(Yii::request()->getParam('sorting', '')){
            $sort = Yii::request()->getParam('sort', 'asc', 'list', array('asc', 'desc'));
            $param = Yii::request()->getParam('param', 'user_file_name', 'list', array('user_file_name', 'description', 'created_at', 'file_size'));
            $order = $param . ' ' . $sort;
        } else {
            $order = 't.document_type desc, t.id desc';
        }

        $files = Users_Files::model()
            ->currentUser()
            ->with(array('files_children'))
            ->together()
            ->findAll(
                array(
                    'condition' => 't.deleted = 0 AND t.name != "" AND t.document_type != "memo" AND t.parent_id = :folder',
                    'params' => array(':folder' => $folder),
                    'order' => $order
                )
            );

        return $this->render('linkDrive/_filesGrid', array(
                'files' => $files,
                'folder' => $folder,
                'entity' => $entity,
                'entityId' => $entityId,
            ),
            $return
        );
    }

}