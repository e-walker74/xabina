<?php
class Payment extends CWidget
{
    public $form;
    public $model;
    public $formId;
    protected $modelName;
    protected $cs;

    /**
     * Initializes the widget.
     * This method is called by {@link CBaseController::createWidget}
     * and {@link CBaseController::beginWidget} after the widget's
     * properties have been initialized.
     */
    public function init()
    {
        $this->cs = Yii::app()->clientScript;
        $this->cs->registerCssFile('http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css');
        $this->cs->registerScriptFile('http://silviomoreto.github.io/bootstrap-select/javascripts/bootstrap-select.js', CClientScript::POS_HEAD);
        $this->cs->registerScriptFile('/js/jquery.creditCardValidator.js', CClientScript::POS_HEAD);
        $this->modelName = get_class($this->model);
    }

    public function run()
    {
        $formId = $this->form->id;
//        $this->cs->registerScript("payment_$formId", "$(document).ready(function() {
//            $('#$formId #{$this->modelName}_electronic_method').change(function() {
//                $('#$formId').find('.electronic-method-fields').css('display','none');
//                $('#$formId').find('.electronic-method-fields.method-' + $(this).val()).css('display','block');
//            })
//            $('#$formId #{$this->modelName}_creditcard_number').validateCreditCard(function(result) {
//                $('#$formId').find('.payments-list .logo').removeClass('active');
//                $('#$formId').find('.payments-list input[type=radion]').attr('checked', false);
//                if (result.card_type) {
//                    $('#$formId').find('.payments-list .logo.'+result.card_type.css_class).addClass('active');
//                    $('#$formId').find('.payments-list input.'+result.card_type.css_class).attr('checked', true);
//                }
//            }, {
//                accept: ['visa', 'mastercard', 'amex', 'maestro', 'jcb', 'discover', 'union']
//            });
//        });");

        $this->render('payment/html', Array(
            'form' => $this->form,
            'model'=> $this->model,
        ));
    }
}