<?php

/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 23:11
 */
class WLinkContact extends QWidget
{

    private $_contacts = false;

    public function init()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
            $cs->registerScriptFile($url . '/linkContact.js');
        }
    }

    public function renderPopup($entity, $entity_id, $htmlID = 'addLinkModal', $return = false)
    {

        $this->render('linkContact/popup', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
                'htmlID' => $htmlID,
            ),
            $return
        );
    }

    public function getContacts($entityId, $entity){
        if ($this->_contacts !== false) {
            return $this->_contacts;
        }
        $model = Users_Contacts::model()->currentUser()->with('user')->findAllBySql(
            "SELECT uf.*, cl.entity_id as model_id, cl.entity_name as form, cl.id as cross_id, cl.category_id as cross_category,
                cl.comment as cross_comment FROM users_contacts uf
            INNER JOIN cross_links cl ON (uf.id = cl.link_table_id AND cl.link_table_name = 'users_contacts')
            WHERE uf.user_id = :user_id
            AND cl.entity_id = :entity_id
            AND cl.entity_name = :entity",
            array(
                ':user_id' => Yii::user()->getCurrentId(),
                ':entity_id' => $entityId,
                ':entity' => $entity,
            )
        );

        if(!$model){
            $this->_contacts = $model;
        }

        foreach($model as $m){
            $this->_contacts[$m->id] = $m;
        }

        return $this->_contacts;
    }

    public function renderTransactionsContacts($transaction_id, $return = false)
    {
        $model = $this->getContacts($transaction_id, 'transactions');

        return $this->render('linkContact/transactionsContacts', array('transaction_id' => $transaction_id, 'model' => $model), $return);
    }

    public function renderNewContactPopup(){
        return $this->render('linkContact/newContactPopup');
    }

} 