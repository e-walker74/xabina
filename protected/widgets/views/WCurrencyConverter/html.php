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
<span class="comment drdn-cont valute-drdn currency-converter-widget">
    <a href="#" class="transaction_valute margin-left" data-toggle="dropdown"></a>
    <div class="dropdown-menu no-close contact-select-dropdown2 valute-dr list-actions-dropdown list-unstyled act-list" role="menu">
        <div class="arr my_arr"></div>
        <div class="content-dropdown">
            <div class="drop_title">
                <?= Yii::t('CurrencyWidget', 'Currency') ?>
                <a class="close-dropdown"></a>
            </div>
            <div class="drop_main_block valute-main">
                <div class="old_sum"><?= number_format($this->value, 2, '.', ' ') ?> <?= $rate['title'] ?></div>
                <div class="trans">=</div>
                <div class="col-lg-7 col-md-7 col-sm-7 no-pad">
                    <div class="new_sum">
                        <?php foreach($rate['rates'] as $currency => $data): ?>
                            <?php if($this->currency_code == $currency) { continue; } ?>
                            <div class="currencies-values currency_conversion_rates_for_<?= $currency ?>">
                                <span <?php if($this->value < 0): ?>class="rejected"<?php endif; ?>>
                                <?= number_format($data['rate']*$this->value, 2, '.', ' ') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 no-pad">
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
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="drop_footer">
                <?= Yii::t('CurrencyWidget', 'Rate from {date}. 1 {fromCurrency} : {rate} {toCurrency}',
                    array(
                        '{date}' => date('d.m.Y', $rate['last_update']),
                        '{fromCurrency}' => $rate['title'],
                        '{rate}' => number_format($data['rate'], 2, '.', ' '),
                        '{toCurrency}' => $data['title'],
                    )) ?>
            </div>
        </div>
    </div>
</span>