<?php

/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 15:42
 */
class WLinkCategory extends QWidget
{

    private $_categories = false;

    public function init()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
            $cs->registerScriptFile($url . '/linkCategory.js');
        }
    }

    public function getCategories($entityId, $entity)
    {
        if ($this->_categories !== false) {
            return $this->_categories;
        }
        $model = Categories::model()->currentUser()->with('user')->findAllBySql(
            "SELECT
                uf.*, cl.entity_id as model_id,
                cl.entity_name as form,
                cl.id as cross_id,
                cl.category_id as cross_category,
                cl.comment as cross_comment
            FROM categories uf
            INNER JOIN cross_links cl ON (uf.id = cl.link_table_id AND cl.link_table_name = 'categories')
            WHERE uf.user_id = :user_id
            AND cl.entity_id = :entity_id
            AND cl.entity_name = :entity",
            array(
                ':user_id' => Yii::user()->getCurrentId(),
                ':entity_id' => $entityId,
                ':entity' => $entity,
            )
        );

        if (!$model) {
            $this->_categories = $model;
        }

        foreach ($model as $m) {
            $this->_categories[$m->id] = $m;
        }

        return $this->_categories;
    }

    public function renderTransactionsCategories($transaction_id, $return = false)
    {
        $data = $this->getCategories($transaction_id, 'transactions');

        return $this->render(
            'linkCategory/transactionsCategory',
            array(
                'data' => $data,
                'transaction_id' => $transaction_id,
            ),
            $return
        );
    }

    public function renderPopup($entity, $entity_id, $htmlID = 'addTwoBuhModal', $return = false)
    {

        $this->render(
            'linkCategory/popup',
            array(
                'entity' => $entity,
                'entity_id' => $entity_id,
                'htmlID' => $htmlID,
            ),
            $return
        );
    }

    public function renderCategoriesGridInPopup($return = false, $params = array())
    {
        $categories = Categories::model()->currentUser()->findAll();
        return $this->render('linkCategory/_categoriesGrid', $params + array('model' => $categories), $return);
    }

} 