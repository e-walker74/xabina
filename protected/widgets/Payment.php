<?php
class Payment extends CWidget
{
    public $form;
    public $model;
    private $modelName;

    /**
     * Initializes the widget.
     * This method is called by {@link CBaseController::createWidget}
     * and {@link CBaseController::beginWidget} after the widget's
     * properties have been initialized.
     */
    public function init()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('/js/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js', CClientScript::POS_HEAD);

        $cs->registerCssFile('http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css');
        $cs->registerScriptFile('http://silviomoreto.github.io/bootstrap-select/javascripts/bootstrap-select.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile('/js/jquery.creditCardValidator.js', CClientScript::POS_HEAD);

        $this->modelName = get_class($this->model);
        $cs->registerScript('payment', "$(document).ready(function(){
            $('#{$this->modelName}_electronic_method').change(function() {
                $('.electronic-method-fields').hide();
                $('.electronic-method-fields.method-'+$(this).val()).slideDown();
            })
            $('#{$this->modelName}_creditcard_number').validateCreditCard(function(result) {
                $('.payments-list .logo').removeClass('active');
                $('.payments-list input[type=radion]').attr('checked', false);
                if (result.card_type) {
                    $('.payments-list .logo.'+result.card_type.css_class).addClass('active');
                    $('.payments-list input.'+result.card_type.css_class).attr('checked', true);
                }
            }, {
                accept: ['visa', 'mastercard', 'amex', 'maestro', 'jcb', 'discover', 'union']
            });
            $('.selectpicker').selectpicker();
        });");
    }

    public function run()
    {
        $this->render('payment/html', Array(
            'form'=>$this->form,
            'model'=>$this->model,
            'modelName'=>$this->modelName,
        ));
    }
}