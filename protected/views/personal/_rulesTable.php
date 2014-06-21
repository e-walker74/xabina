<?php
/**
 * @var                     $this PersonalController
 * @var Users_AlertsRules[] $userAlertsRules
 * @var Users_Emails[]      $emailAddresses
 * @var Users_Phones[]      $phones
 * @var                     $form CActiveForm
 * @var Accounts            $selectedAcc
 */
?>
<?php
$modelRule = new Users_AlertsRules();
$defaultFormParams = array(
    'method' => 'post',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid',
    )
);
?>
<div class="table table-alert">
<?php if ($userAlertsRules): ?>
    <?php foreach ($userAlertsRules as $rule): ?>
        <?php $form = $this->beginWidget('CActiveForm', array_merge($defaultFormParams, array(
            'id' => 'alert-form-' . $rule->id,
            'action' => $this->createUrl('updatealerts', array('id' => $rule->id)),
            'htmlOptions' => array(
                'class' => 'alert-row'
            )
        )));
        ?>
        <div class="cell" style="width: 18%"><?= $rule->alert->name; ?></div>
        <div class="cell" style="width: 24%">
            <?= CHtml::hiddenField('account', $selectedAcc->number, array('id' => 'account' . $rule->id)); ?>
            <?= $form->hiddenField($rule, 'alert_code', array('value' => $rule->alert->code)); ?>
            <?php if ($rule->greater): ?>
                <div class="greater not-edit-doc">
                    <b><?= Yii::t('Front', 'Higher than') ?>:</b> <br>
                    <?= number_format($rule->greater, 2, '.', ' '); ?> <?= $rule->account->currency->code; ?>
                </div>
            <?php endif; ?>
            <?php if ($rule->less): ?>
                <div class="lower not-edit-doc">
                    <b><?= Yii::t('Front', 'Lower than') ?>:</b> <br>
                    <?= number_format($rule->less, 2, '.', ' '); ?> <?= $rule->account->currency->code; ?>
                </div>
            <?php endif; ?>
            <?php if ($rule->equal): ?>
                <div class="equal not-edit-doc">
                    <b><?= Yii::t('Front', 'Equals to') ?>:</b> <br>
                    <?= number_format($rule->equal, 2, '.', ' '); ?> <?= $rule->account->currency->code; ?>
                </div>
            <?php endif; ?>
            <?php if ($rule->alert->use_rules == 1): ?>
                <div class="edit-doc" style="display: none;">
                    <div class="field-row">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Rule'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <div class="field-input block-box">
                            <div class="select-custom">
                                    <span class="select-custom-label">
                                      <?= !empty($rule->greater) ? Yii::t('Front', 'Higher than') : ''; ?>
                                      <?= !empty($rule->less) ? Yii::t('Front', 'Lower than') : ''; ?>
                                      <?= !empty($rule->equal) ? Yii::t('Front', 'Equals to') : ''; ?>
                                    </span>
                                <select class="select-invisible rule-select">
                                    <option
                                        value="greater" <?= empty($rule->greater) ? '' : 'selected'; ?>><?= Yii::t('Front', 'Higher than') ?></option>
                                    <option
                                        value="less" <?= empty($rule->less) ? '' : 'selected'; ?>><?= Yii::t('Front', 'Lower than') ?></option>
                                    <option
                                        value="equal" <?= empty($rule->equal) ? '' : 'selected'; ?>><?= Yii::t('Front', 'Equals to') ?></option>
                                </select>
                                <span class="validation-icon"></span>
                            </div>
                        </div>
                    </div>
                    <div class="field-row rule-input greater <?= $rule->greater ? '' : 'hide'; ?>">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Value'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <div class="field-input block-box">
                            <?=
                            $form->textField($rule, 'greater', array(
                                'class' => 'input-text amount',
                                'maxlength' => 9,
                                'value' => intval($rule->greater)
                            ));?>.
                            <?=
                            $form->textField($rule, 'greater_cent', array('class' => 'input-text cent',
                                'value' => ($rule->greater * 100) % 100 ? : ''
                            ));?>
                            <span class="curr-lbl"><?= $selectedAcc->currency->code; ?></span>
                            <?= $form->error($rule, 'greater'); ?>
                            <?= $form->error($rule, 'greater_cent'); ?>
                        </div>
                    </div>
                    <div class="field-row rule-input less <?= $rule->less ? '' : 'hide'; ?>">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Value'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <div class="field-input block-box">
                            <?=
                            $form->textField($rule, 'less', array(
                                'class' => 'input-text amount',
                                'maxlength' => 9,
                                'value' => intval($rule->less)
                            ));?>.
                            <?=
                            $form->textField($rule, 'less_cent', array(
                                'class' => 'input-text cent',
                                'value' => ($rule->less * 100) % 100 ? : ''
                            ));?>
                            <span class="curr-lbl"><?= $selectedAcc->currency->code; ?></span>
                            <?= $form->error($rule, 'less'); ?>
                            <?= $form->error($rule, 'less_cent'); ?>
                        </div>
                    </div>
                    <div class="field-row rule-input equal <?= $rule->equal ? '' : 'hide'; ?>">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Value'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <div class="field-input block-box">
                            <?=
                            $form->textField($rule, 'equal', array(
                                'class' => 'input-text amount',
                                'maxlength' => 9,
                                'value' => intval($rule->equal)
                            ));?>.
                            <?=
                            $form->textField($rule, 'equal_cent', array(
                                'class' => 'input-text cent',
                                'value' => ($rule->equal * 100) % 100 ? : ''
                            ));?>
                            <span class="curr-lbl"><?= $selectedAcc->currency->code; ?></span>
                            <?= $form->error($rule, 'equal'); ?>
                            <?= $form->error($rule, 'equal_cent'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="block-box">
            <div class="cell lh" style="width: 27%">
                <?php foreach ($rule->alertEmails as $alertEmail): ?>
                    <div class="str not-edit-doc"><?= $alertEmail->email->email; ?></div>
                <?php endforeach; ?>
                <div class="edit-doc" style="display: none;">
                    <div class="field-row">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'E-mail'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <?php foreach ($emailAddresses as $alertEmail) : ?>
                            <div class="field-input">
                                <label>
                                    <?=
                                    $form->checkBox($modelRule, "emails[{$alertEmail->id}]", array(
                                        'class' => 'input-checkbox',
                                        'checked' => $rule->inEmails($alertEmail)
                                    ));?>
                                    <?= $alertEmail->email; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" id="<?= Chtml::activeId($rule, 'emails'); ?>"/>
                    <?= $form->error($rule, 'emails'); ?>
                </div>
            </div>
            <div class="cell lh" style="width: 19%">
                <?php foreach ($rule->alertPhones as $alertPhone): ?>
                    <div class="str not-edit-doc">+<?= $alertPhone->phone->phone; ?></div>
                <?php endforeach; ?>
                <div class="edit-doc" style="display: none;">
                    <div class="field-row">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Phone'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <div class="field-input">
                            <?php foreach ($phones as $alertPhone) : ?>
                                <label>
                                    <?=
                                    $form->checkBox($rule, "phones[{$alertPhone->id}]", array(
                                        'class' => 'input-checkbox',
                                        'checked' => $rule->inPhones($alertPhone)
                                    ));?>
                                    +<?= $alertPhone->phone; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cell actions-td" style="width: 12%">
            <div class="not-edit-doc">
                <a href="#" class="button edit"></a>
                <a data-url="<?= $this->createUrl('dropalerts', array('id' => $rule->id)); ?>"
                   class="button delete"></a>
            </div>
            <div class="edit-doc" style="display: none;">
                <a href="#" data-url="<?= $this->createUrl('updatealerts', array('id' => $rule->id)); ?>"
                   class="button ok"></a>
                <a href="#" class="button cancel"></a>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php $this->endWidget(); ?>
    <?php endforeach; ?>
<?php endif; ?>

<!-- add Rule -->
<div class="alert-row">
    <div class="cell table-form-subheader" style="width: 100%;"><a href="#add-rule-form" class="add-btn table-btn"
                                                                   data-toggle="collapse"><?= Yii::t('Front', 'Add rule'); ?></a>
    </div>
    <div class="clearfix"></div>
</div>

<?php $form = $this->beginWidget('CActiveForm', array_merge($defaultFormParams, array(
    'action' => $this->createUrl('updatealerts', array('id' => 'new')),
    'htmlOptions' => array(
        'class' => 'alert-row form-row collapse',
        'id' => 'add-rule-form'
    )
)));
?>
<div class="cell" style="width: 39%">
    <?= CHtml::hiddenField('account', $selectedAcc->number, array('id' => 'accountnew')); ?>
    <div class="field-row">
        <div class="field-lbl">
            <?= Yii::t('Front', 'Alert'); ?>
            <span class="tooltip-icon" title="tooltip text"></span>
        </div>
        <div class="field-input block-box">
            <div class="select-custom alert-select">
                        <span class="select-custom-label">
                          <?= Yii::t('Front', 'Choose'); ?>
                        </span>
                <?=
                $form->dropDownList($modelRule, 'alert_code',
                    array_merge(array('' => Yii::t('Front', 'Choose')), AlertsHTMLHelper::getAlertsChoices()),
                    array(
                        'class' => 'select-invisible',
                        'options' => AlertsHTMLHelper::getAlertsOptions()
                    )
                ); ?>
                <span class="validation-icon"></span>
                <?= $form->error($modelRule, 'alert_code'); ?>
            </div>
        </div>
        <div class="underline"></div>
    </div>
    <div class="rules-row hide">
        <div class="field-row block-box">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Rule'); ?>
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <div class="field-input">
                <div class="select-custom">
                            <span class="select-custom-label">
                              <?= Yii::t('Front', 'Higher than'); ?>
                            </span>
                    <select class="select-invisible rule-select">
                        <option value="greater"><?= Yii::t('Front', 'Higher than') ?></option>
                        <option value="less"><?= Yii::t('Front', 'Lower than') ?></option>
                        <option value="equal"><?= Yii::t('Front', 'Equals to') ?></option>
                    </select>
                    <span class="validation-icon"></span>
                </div>
            </div>
        </div>
        <div class="field-row rule-input greater block-box">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Value'); ?>
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <div class="field-input">
                <?= $form->textField($modelRule, 'greater', array('class' => 'input-text amount', 'maxlength' => 9)); ?>.
                <?= $form->textField($modelRule, 'greater_cent', array('class' => 'input-text cent')); ?>
                <span class="curr-lbl"><?= $selectedAcc->currency->code; ?></span>
                <?= $form->error($modelRule, 'greater'); ?>
                <?= $form->error($modelRule, 'greater_cent'); ?>
            </div>
        </div>
        <div class="field-row rule-input less hide block-box">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Value'); ?>
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <div class="field-input">
                <?= $form->textField($modelRule, 'less', array('class' => 'input-text amount', 'maxlength' => 9)); ?>.
                <?= $form->textField($modelRule, 'less_cent', array('class' => 'input-text cent')); ?>
                <span class="curr-lbl"><?= $selectedAcc->currency->code; ?></span>
                <?= $form->error($modelRule, 'less'); ?>
                <?= $form->error($modelRule, 'less_cent'); ?>
            </div>
        </div>
        <div class="field-row rule-input equal hide block-box">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Value'); ?>
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <div class="field-input">
                <?= $form->textField($modelRule, 'equal', array('class' => 'input-text amount', 'maxlength' => 9)); ?>.
                <?= $form->textField($modelRule, 'equal_cent', array('class' => 'input-text cent')); ?>
                <span class="curr-lbl"><?= $selectedAcc->currency->code; ?></span>
                <?= $form->error($modelRule, 'equal'); ?>
                <?= $form->error($modelRule, 'equal_cent'); ?>
            </div>
        </div>
    </div>
</div>
<div class="block-box">
    <div class="cell" style="width: 29%">
        <div class="field-row">
            <div class="field-lbl">
                <?= Yii::t('Front', 'E-mail'); ?>
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <?php foreach ($emailAddresses as $alertEmail) : ?>
                <div class="field-input">
                    <label>
                        <?= $form->checkBox($modelRule, "emails[{$alertEmail->id}]", array('class' => 'input-checkbox')); ?>
                        <?= $alertEmail->email; ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <input type="hidden" id="<?= Chtml::activeId($modelRule, 'emails'); ?>"/>
            <?= $form->error($modelRule, 'emails'); ?>
        </div>
    </div>
    <div class="cell" style="width: 20%">
        <div class="field-row">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Phone'); ?>
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <div class="field-input">
                <?php foreach ($phones as $alertPhone) : ?>
                    <label>
                        <?= $form->checkBox($modelRule, "phones[{$alertPhone->id}]", array('class' => 'input-checkbox')); ?>
                        +<?= $alertPhone->phone; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div class="cell" style="width: 12%">
    <div class="field-row">
        <a href="#" id="alert-add-btn" class="button ok"></a>
        <a href="#" class="button cancel"></a>
    </div>
</div>
<div class="clearfix"></div>
<?php $this->endWidget(); ?>
</div>