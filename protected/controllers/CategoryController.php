<?php

class CategoryController extends Controller
{

    public $layout = '';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
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
            array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionCreate()
    {
        $entity = Yii::request()->getParam('entity', '');
        $entityId = Yii::request()->getParam('entity_id', '', 'int');
        $title = Yii::request()->getParam('title', '', 'string');
        $description = Yii::request()->getParam('description', '', 'string');

        $model = new Categories();
        $model->title = $title;
        $model->description = $description;
        $model->user_id = Yii::user()->getCurrentId();
        if ($model->save()) {

            $crossLink = new CrossLinks();
            $crossLink->user_id = Yii::user()->getCurrentId();
            $crossLink->entity_name = $entity;
            $crossLink->entity_id = $entityId;
            $crossLink->link_table_name = $model->tableName();
            $crossLink->link_table_id = $model->id;
            $crossLink->save();

            echo CJSON::encode(array(
                'success' => true,
                'message' => Yii::t('Category', 'category_was_successfully_save'),
                'html' => Widget::get('WLinkCategory')->renderCategoriesGridInPopup(true),
            ));
        } else {
            echo CJSON::encode(array(
                'success' => false,
                'message' => Yii::t('Drive', 'memo_not_added'),
            ));
        }
    }

    public function actionLink()
    {
        $entity = Yii::request()->getParam('entity', '', 'list', array('transactions'));
        $entity_id = Yii::request()->getParam('entity_id', '', 'int');

        $listFiles = Yii::request()->getParam('categories');

        foreach ($listFiles as $file) {
            try {
                $cross = new CrossLinks();
                $cross->entity_id = $entity_id;
                $cross->entity_name = $entity;
                $cross->link_table_id = $file;
                $cross->link_table_name = 'categories';
                $cross->user_id = Yii::user()->getCurrentId();
                $cross->save();
            } catch (CException $e) {
//                echo CJSON::encode(
//                    array(
//                        'success' => false,
//                        'message' => Yii::t('Drive', 'this_file_was_not_added')
//                    )
//                );
//                Yii::app()->end();
            }
        }

        $html = Widget::create(
            'WLinkCategory', 'WLinkCategory',
            array()
        )->renderTransactionsCategories($entity_id, true);

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Category', 'category_was_added'),
            'html' => $html,
        ));
    }
}