<?php

/**
 * InvoiceForm class.
 * InvoiceForm is the data structure for keeping
  */
class Form_Invoice extends CFormModel
{
    public $email;
    public $number;
    public $user_id;
	public $invoice_date;
    public $due_date;
    public $reference;
    public $currency_id;
    public $options = array();
    public $terms;
    public $note;
    public $discount;
    public $discount_type;
	public $subtotal;
	public $total;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
            array('email', 'required', 'message' => Yii::t('Front', 'E-Mail is incorrect')),
            array('email', 'email', 'message' => Yii::t('Front', 'E-Mail is incorrect')),
            array('currency_id', 'required', 'message' => Yii::t('Front', 'Currenciy required')),
            array('number', 'required', 'message' => Yii::t('Front', 'Number is require')),
			array('subtotal, total', 'required'),
            array('invoice_date', 'date', 'format' => 'mm/dd/yyyy', 'message' => Yii::t('Front', 'Date is incorrect')),
            array('due_date', 'date', 'format' => 'mm/dd/yyyy', 'message' => Yii::t('Front', 'Due date is incorrect')),
            array('discount, discount_type', 'numerical', 'message' => Yii::t('Front', 'Discount not numerical')),

            array('reference, terms, note', 'safe'),

        );
	}

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('Front', 'Recipient’s email address'),
            'number' => Yii::t('Front', 'Invoice number '),
            'date' => Yii::t('Front', 'Invoice date'),
            'due_date' => Yii::t('Front', 'Due date'),
            'reference' => Yii::t('Front', 'Reference'),
            'currency_id' => Yii::t('Front', 'Currency'),
            'terms' => Yii::t('Front', 'Terms and conditions'),
            'note' => Yii::t('Front', 'Note to recipient '),
            'discount' => Yii::t('Front', 'Discount'),
        );
    }

    public function invoiceCreate() {
        $invoice = new Invoices();
        $invoice->attributes = $this->attributes;

        if (!$invoice->save()) {
			d($invoice->getErrors());
            Yii::log('invoice fail '.print_r($invoice->getErrors(), 1), CLogger::LEVEL_ERROR, 'error');
        } else {
            $invoiceId = Yii::app()->db->getLastInsertID();
            foreach($this->options as $item){
                $invoicesOptions = new Invoices_Options();
                $invoicesOptions->attributes = $item;
                $invoicesOptions->invoice_id = $invoiceId;
                $invoicesOptions->save();
            }

            return true;
        }
    }

}
