<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 09.07.14
 * Time: 22:38
 */
?>

<div class="transfer-accordion" id="search_accordion">
    <div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Advanced search'); ?> </a><span class="arr"></span></div>
    <div class="accordion-content transaction-table-overflow">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>array('/contact/searchLink', 'id' => $model->id),
            'method'=>'get',
            'id' => 'searchFormLink',
            'htmlOptions' => array(
                'class' => 'advanced-search-form',
            ),
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>true,
                'errorCssClass'=>'input-error',
                'successCssClass'=>'valid',
                'afterValidate' => 'js:afterValidate',
                'afterValidateAttribute' => 'js:afterValidateAttribute'
            ),
        )); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="field-lbl"><?= $searchLink->getAttributeLabel('keyword') ?> </div>
                <div class="field-input">
                    <?= $form->textField($searchLink, 'keyword', array('autocomplete' => 'off', 'class' => 'input-text', 'placeholder' => Yii::t('Front', 'You can filer transactions by Sender, Account number or any Keyword'))); ?>
                    <?= $form->hiddenField($searchLink, 'account_number', array('id'=>'searchForm_account_number')); ?>
                </div>
            </div>
        </div>
        <div class="row second-row" >
            <div class="col-nested-3">
                <div class="field-lbl"><?= Yii::t('Front', 'Date'); ?></div>
                <div class="field-input ">
                    <?= $form->textField($searchLink, 'from_date', array('autocomplete' => 'off', 'class' => 'input-text two-row-input calendar-input')); ?>
                    <span class="calendar-ico"></span>
                </div>
                <div class="field-input two-line">
                    <?= $form->textField($searchLink, 'to_date', array('autocomplete' => 'off', 'class' => 'input-text two-row-input calendar-input')); ?>
                    <span class="calendar-ico"></span>
                </div>
            </div>
            <div class="col-nested-3 transaction-sum">
                <div class="field-lbl "><?= Yii::t('Front', 'Sum') ?></div>
                <div class="field-input ">
                    <span class="from-lbl"><?= Yii::t('Front', 'from') ?></span>
                    <?= $form->textField($searchLink, 'from_sum', array('autocomplete' => 'off', 'class' => 'input-text two-row-input numeric')); ?>
                </div>
                <div class="field-input two-line">
                    <span class="from-lbl "><?= Yii::t('Front', 'to') ?></span>
                    <?= $form->textField($searchLink, 'to_sum', array('autocomplete' => 'off', 'class' => 'input-text two-row-input numeric')); ?>

                </div>
            </div>
            <div class="col-nested-3">
                <div class="field-lbl empty">d</div>
                <div class="field-input ">
                    <div class="select-custom">
                        <span class="select-custom-label"><?= Yii::t('Front', 'All transactions') ?></span>
                        <?=  $form->dropDownList($searchLink, 'type', array(
                            '' => Yii::t('Front', 'All transactions'),
                            'incoming' => Yii::t('Front', 'Incoming'),
                            'outgoing' => Yii::t('Front', 'Outgoing'),
                        ), array('class' => 'select-invisible')); ?>
                    </div>
                </div>
                <div class="field-input  search-cont two-line">
                    <input type="submit" class="search-button button-find" onclick="js:searchTransactionsLinks(this); return false;" value="<?= Yii::t('Front', 'Search'); ?>" />
                </div>

            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>