<?php
class XabinaUserIdValidator extends CValidator{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		if($object->{$attribute}){
            if(!Users::model()->find('login = :n', array(':n' => $object->{$attribute}))) {
                $this->addError($object, $attribute, Yii::t('Front', 'User ID is incorrect'));
            }
        }
	}
	
	/**
	 * Returns the JavaScript needed for performing client-side validation.
	 * @param CModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 * @return string the client-side validation script.
	 * @see CActiveForm::enableClientValidation
	 
	public function clientValidateAttribute($object,$attribute)
	{
	 
		// check the strength parameter used in the validation rule of our model
		if ($this->strength == 'weak')
		  $pattern = $this->weak_pattern;
		elseif ($this->strength == 'strong')
		  $pattern = $this->strong_pattern;     
	 
		$condition="!value.match({$pattern})";
		 
			return "
		if(".$condition.") {
			messages.push(".CJSON::encode('your password is too weak, you fool!').");
		}
		";
	}
	*/
}