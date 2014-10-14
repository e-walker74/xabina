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
                var currency_conv_block = $(".currency-converter-widget")
                currency_conv_block.find(".currencies-values").hide()
                currency_conv_block.find(".currencies-values:first").show()
                currency_conv_block.on("change", "select", function(){
                    currency_conv_block.find(".currencies-values").hide()
                    currency_conv_block.find(".currency_conversion_rates_for_" + $(this).val()).show()
                })

                currency_conv_block.find("select").change(function(){
                    $(this).closest(".drdn-cont").addClass("open");
                });
            })
        ', CClientScript::POS_END);
    }
}