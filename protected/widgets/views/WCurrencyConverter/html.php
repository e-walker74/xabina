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
        class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list"
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
                            $this->currency_code,
                            CHtml::listData(CurrencyService::getCurrenciesList(), 'code', 'title'),
                            array('class' => 'select-invisible')
                        );
                    ?>
                </div>
                <?php foreach($rate['rates'] as $currency => $data): ?>
                    <div class="drop_dop_text currency_conversion_rates_for_<?= $currency ?>">
                    <span class="bold_text">
                        <?= number_format($this->value, 2, '.', ' ') ?> <?= $rate['title'] ?>  =
                        <?= number_format($data['rate']*$this->value, 2, '.', ' ') ?> <?= $data['title'] ?>
                    </span>
                        по курсу 1 <?= $rate['title'] ?> : <?= number_format($data['rate'], 2, '.', ' ') ?> <?= $data['title'] ?> НБ
                        на <?= date('d.m.Y', $rate['last_update']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>