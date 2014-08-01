<?php

abstract class Users_Profile extends ActiveRecord
{
    public function beforeValidate(){
        if($this->hasAttribute('category_id') && isset($_POST['Data_Category'])){
            $cat = $_POST['Data_Category'];
            $category = Users_Categories::model()->findByAttributes(
                array(
                    'user_id' => Yii::user()->getCurrentId(),
                    'data_type' => $this->tableName(),
                    'value' => $_POST['Data_Category'],
                )
            );

            if(!$category){
                $category = new Users_Categories();
                $category->user_id = Yii::user()->getCurrentId();
                $category->data_type = $this->tableName();
                $category->value = $_POST['Data_Category'];
                $category->save();
            }

            $this->category_id = $category->id;
        }
        return parent::beforeValidate();
    }
}