<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 16.06.14
 * Time: 13:11
 */

class Html extends CHtml {
    public static function link($text, $url=array(), $htmlOptions=array()){
        /*if(!YII_DEBUG && !Yii::user()->checkAccessByUrl($url[0])){
            return '';
        }*/
        return parent::link($text, $url, $htmlOptions);
    }

    public static function listDataWithFilter($models,$valueField,$textField,$filterAttr,$filterValue){
        $arr = array();
        foreach($models as $model){
            if($model->$filterAttr == $filterValue){
                $arr[] = $model;
            }
        }
        return parent::listData($arr,$valueField,$textField);
    }
}