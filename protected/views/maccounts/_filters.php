<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 18.10.14
 * Time: 14:29
 */ ?>

<div class="filter-block">
    <div class="filter-header">
        <div class="filter-button pull-left"></div>
        <div class="lbl"><?= Yii::t('Accounts', 'Filters') ?></div>
    </div>
    <div class="filter-content">
        <div class="form-cell">
            <div class="form-label"><?= Yii::t('Accounts', 'Currency') ?></div>
            <div class="form-input">
                <div class="select-custom select-narrow ">
                    <span class="select-custom-label"></span>
                    <?= CHtml::dropDownList('currency_filter', '', array('' => '') + $currencies, array('class' => 'select-invisible country-select filter-value')) ?>
                </div>
            </div>
        </div>
        <div class="form-cell">
            <div class="form-label"><?= Yii::t('Accounts', 'Status') ?></div>
            <div class="form-input">
                <div class="select-custom select-narrow ">
                    <span class="select-custom-label"></span>
                    <?= CHtml::dropDownList('status_filter', '', array('' => '') + $statuses, array('class' => 'select-invisible country-select filter-value')) ?>
                </div>
            </div>
        </div>
        <div class="form-cell">
            <div class="form-label"><?= Yii::t('Accounts', 'Account Type') ?></div>
            <div class="form-input">
                <div class="select-custom select-narrow ">
                    <span class="select-custom-label"></span>
                    <?= CHtml::dropDownList('subtype_filter', '', array('' => '') + $account_types, array('class' => 'select-invisible country-select filter-value')) ?>
                </div>
            </div>
        </div>
    </div>
</div>