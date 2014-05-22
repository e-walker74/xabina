<?php

/**
 * InvoiceForm class.
 * InvoiceForm is the data structure for keeping
  */
class Form_Invoice extends CFormModel
{
	public $number;
	public $date;
    public $due_date;
    public $reference;
    public $email;
    public $currency_id;
    public $discount;
    public $terms;
    public $note;
    public $options;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(

		);
	}

}
