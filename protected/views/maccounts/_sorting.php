<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 18.10.14
 * Time: 14:31
 */ ?>

<div class="header">
    <div class="header-cell account">
        <div class="checkbox-custom narrow-17">
            <label class="">
                <input class="summary-checkbox" onclick="Accounts.checkAll(this)" type="checkbox">
            </label>
        </div>
        <span class="sort asc" data-sort-field="number" onclick="Accounts.sort(this)"><?= Yii::t('Accounts', 'Account') ?></span>
    </div>
    <div class="header-cell name">
        <span class="sort" data-sort-field="name" onclick="Accounts.sort(this)"><?= Yii::t('Accounts', 'Name/Type') ?></span>
    </div>
    <div class="header-cell balance">
        <span class="sort" data-sort-field="multi_balance" onclick="Accounts.sort(this, '', 'desc')"><?= Yii::t('Accounts', 'Balance') ?></span>
    </div>
    <div class="header-cell currency">
        <span class="sort"><?= Yii::t('Accounts', 'Currency') ?></span>
    </div>
    <div class="header-cell status">
        <span class="sort" data-sort-field="status" onclick="Accounts.sort(this, 'asc')"><?= Yii::t('Accounts', 'Status') ?></span>
    </div>
    <div class="header-cell sort-f relative">
        <div class="sort-drdn-cont" data-default="<?= Yii::t('Accounts', 'Sort') ?>" data-toggle="dropdown"><?= Yii::t('Accounts', 'Sort') ?></div>
        <ul class="dropdown-menu sort-drdn" role="menu">
            <li>
                <a href="javaScript:void(0)" class="" data-sort-field="name" onclick="Accounts.sort(this, 'asc')"><?= Yii::t('Accounts', 'Alphabet (from A to Z)') ?></a>
            </li>
            <li>
                <a href="javaScript:void(0)" class="" data-sort-field="name" onclick="Accounts.sort(this, 'desc')"><?= Yii::t('Accounts', 'Alphabet (from Z to A)') ?></a>
            </li>
            <li>
                <a href="javaScript:void(0)" class="" data-sort-field="number" onclick="Accounts.sort(this, 'asc')"><?= Yii::t('Accounts', 'Numerical (from 0 to 9)') ?></a>
            </li>
            <li>
                <a href="javaScript:void(0)" class="" data-sort-field="number" onclick="Accounts.sort(this, 'desc')"><?= Yii::t('Accounts', 'Numerical (from 9 to 0)') ?></a>
            </li>
            <li>
                <a href="javaScript:void(0)" class="" data-sort-field="multi_balance" onclick="Accounts.sort(this, 'desc')"><?= Yii::t('Accounts', 'Balance (from high to low)') ?></a>
            </li>
            <li>
                <a href="javaScript:void(0)" class="" data-sort-field="multi_balance" onclick="Accounts.sort(this, 'asc')"><?= Yii::t('Accounts', 'Balance (from low to high)') ?></a>
            </li>
            <li>
                <a href="javaScript:void(0)" class=""  data-sort-field="status" onclick="Accounts.sort(this, 'asc')"><?= Yii::t('Accounts', 'Status') ?></a>
            </li>
        </ul>
    </div>
    <div class="header-cell clearfix"></div>
</div>