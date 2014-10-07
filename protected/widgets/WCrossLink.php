<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 01.10.14
 * Time: 17:49
 */

class WCrossLink  extends QWidget
{

    private $_categories = false;

    public function init()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
            $cs->registerScriptFile($url . '/crossLinks.js');
        }
    }

    public function getCategories(){
        if($this->_categories !== false){
            return $this->_categories;
        }
        $categories = Users_Categories::model()->with('cross')->together()->findAll(
            '(t.user_id is NULL OR t.user_id = :uid) AND t.data_type = "cross_links" AND cross.id is NOT NULL',
            array(':uid' => Yii::user()->id)
        );
        if(!$categories){
            $this->_categories = array();
        }
        foreach($categories as $cat){
            $this->_categories[$cat->id] = $cat;
        }
        return $this->_categories;
    }

    public function changeCategory($id, $category){
        $categories = $this->getCategories();
        if(isset($categories[$category])){
            $cat = $categories[$category]->value;
        } else {
            $cat = Yii::t('Cross', 'Category');
        }

        $this->render('crossLinks/category', array('cat' => $cat, 'cat_id' => $category, 'cross_id' => $id));
    }

    public function changeComment($id, $comment = false){

        $this->render('crossLinks/comment',
            array(
                'cross_id' => $id,
                'comment' => $comment,
            )
        );
    }
}