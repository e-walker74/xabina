<?php

/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 09.09.14
 * Time: 16:12
 */
class WCurrencyConverter extends QWidget
{

    public $value;
    public $currency_code;

    public function run()
    {
        if (!$this->value) {
            return false;
        }
        $this->registerJS();
        $this->render('WCurrencyConverter/html', array('rate' => $this->getRatesForCurrency($this->currency_code)));
    }

    public function getRatesForCurrency($currency_code)
    {
        $data = CurrencyService::getConversionData();
        return $data[$currency_code];
    }

    public function registerJS()
    {
        Yii::app()->clientScript->registerScript('currencyConverterWidget', '
            $("document").ready(function(){
                var block = $(".currency-converter-widget")
                block.find(".drop_dop_text").hide()
                block.find(".drop_dop_text:first").show()
                block.on("change", "select", function(){
                    block.find(".drop_dop_text").hide()
                    block.find(".currency_conversion_rates_for_" + $(this).val()).show()
                })
            })
        ', CClientScript::POS_END);
    }
}