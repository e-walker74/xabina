<?php
class Card extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        if (!AccountService::checkNumber($value, strlen($value))){
            $this->addError($object, $attribute, Yii::t('Front', 'Card id not valid'));
        }
    }
}