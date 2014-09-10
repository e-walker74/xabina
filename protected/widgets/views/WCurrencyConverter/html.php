<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 09.09.14
 * Time: 16:14
 * @var WCurrencyConverter $this
 */ ?>

<div class="comment currency-converter-widget">
    <a class="exchange-ico dropdown-hover" data-toggle="dropdown" href="#"></a>

    <div
        class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list exchange-popup"
        role="menu">
        <div class="arr"></div>
        <div class="content-dropdown">
            <div class="drop_title">
                <?= Yii::t('CurrencyWidget', 'Currency') ?>
                <a class="close-dropdown"></a>
            </div>
            <div class="drop_bg_block">
                <?= Yii::t('CurrencyWidget', 'select_currency') ?>
            </div>
            <div class="drop_main_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label"></span>
                    <?=
                        CHtml::dropDownList(
                            'currency',
                            '',
                            CHtml::listData(CurrencyService::getCurrenciesList(), 'code', 'title'),
                            array(
                                'class' => 'select-invisible',
                                'options' => array(
                                    $this->currency_code => array('style' => 'display:none;', 'disabled' => true)
                                )
                            )
                        );
                    ?>
                </div>
                <?php foreach($rate['rates'] as $currency => $data): ?>
                    <?php if($this->currency_code == $currency) { continue; } ?>
                    <div class="drop_dop_text currency_conversion_rates_for_<?= $currency ?>">
                    <span class="bold_text">
                        <?= number_format($this->value, 2, '.', ' ') ?> <?= $rate['title'] ?>  =
                        <?= number_format($data['rate']*$this->value, 2, '.', ' ') ?> <?= $data['title'] ?>
                    </span>
                        <?= Yii::t('CurrencyWidget', 'Rate from {date}. 1 {fromCurrency} : {rate} {toCurrency}',
                        array(
                            '{date}' => date('d.m.Y', $rate['last_update']),
                            '{fromCurrency}' => $rate['title'],
                            '{rate}' => number_format($data['rate'], 2, '.', ' '),
                            '{toCurrency}' => $data['title'],
                        )) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>