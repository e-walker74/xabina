<?php

abstract class Users_Profile extends ActiveRecord
{
    public function beforeValidate()
    {
        if ($this->hasAttribute('category_id') && isset($_POST['Data_Category'])) {
            $cat = $_POST['Data_Category'];
            $category = Users_Categories::model()->findByAttributes(
                array(
                    'user_id' => Yii::user()->getCurrentId(),
                    'data_type' => $this->tableName(),
                    'value' => $_POST['Data_Category'],
                )
            );

            if (!$category) {
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

    public function afterSave()
    {
        if($this->hasAttribute('category_id')){
            $sql = 'DELETE
                    FROM users_categories
                    WHERE
                      NOT EXISTS
                        (
                          SELECT NULL FROM '.$this->tableName().' upi
                          WHERE upi.category_id = users_categories.id
                          AND upi.user_id = :user';
            if($this->hasAttribute('deleted')){
                $sql .= ' AND upi.deleted = 0 ';
            }
                $sql .= '
                        )
                      AND user_id = :user
                      AND data_type = :table;';
            Yii::app()->db->createCommand($sql)->execute(array(
                ':table' => $this->tableName(),
                ':user' => $this->user_id,
            ));
        }
        return parent::afterSave();
    }
}