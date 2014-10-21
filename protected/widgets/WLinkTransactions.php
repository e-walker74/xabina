<?php

/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 01.10.14
 * Time: 13:17
 */
class WLinkTransactions extends QWidget
{

    private $_transactions = false;

    public function init()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
            $cs->registerScriptFile($url . '/linkTransactions.js');
        }
    }

    public function renderPopup($entity, $entity_id, $htmlID = 'addTranModal', $return = false)
    {
        $this->render('linkTransactions/popup', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
                'htmlID' => $htmlID,
            ),
            $return
        );
    }

    public function getTransactions($entityId, $entity)
    {
        if ($this->_transactions !== false) {
            return $this->_transactions;
        }
        $model = Transactions::model()->currentUser()->findAllBySql(
            "SELECT tr.*, cl.entity_id as model_id, cl.entity_name as form, cl.id as cross_id, cl.category_id as cross_category,
                cl.comment as cross_comment FROM transactions tr
            INNER JOIN cross_links cl ON (tr.id = cl.link_table_id AND cl.link_table_name = 'transactions')
            INNER JOIN accounts ac ON(tr.account_id = ac.id)
            WHERE ac.user_id = :user_id
            AND cl.entity_id = :entity_id
            AND cl.entity_name = :entity
            ORDER BY cl.id desc",
            array(
                ':user_id' => Yii::user()->getCurrentId(),
                ':entity_id' => $entityId,
                ':entity' => $entity,
            )
        );

        if (!$model) {
            $this->_transactions = $model;
        }

        foreach ($model as $m) {
            $this->_transactions[$m->id] = $m;
        }

        return $this->_transactions;
    }

    public function renderTransactionsTrans($transaction_id, $return = false)
    {
        $model = $this->getTransactions($transaction_id, 'transactions');

        return $this->render('linkTransactions/transactionsTrans', array('transaction_id' => $transaction_id, 'model' => $model), $return);
    }

    public function renderTransactionsRows($entity, $entity_id, $return = false){
        $transactions = Transactions::model()->with(array('account', 'info', 'account.currency'))->together()->findAll(
            array(
                'condition' => 'account.user_id = :uid',
                'order' => 't.id desc',
                'limit' => 50,
                'params' => array(
                    ':uid' => Yii::user()->getCurrentId()
                ),
            )
        );

        return $this->render('linkTransactions/_rows', array('entity' => $entity, 'entity_id' => $entity_id, 'transactions' => $transactions), $return);
    }
} 