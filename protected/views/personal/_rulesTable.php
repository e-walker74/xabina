<?php
/**
 * @var $this PersonalController
 * @var Users_AlertsRules[] $userAlertsRules
 * @var Users_Emails[] $emailAddresses
 * @var Users_Phones[] $phones
 * @var CActiveForm $form
 * @var Accounts $selectedAcc
 */
?>
<?php
$modelRule = new Users_AlertsRules();
$form=$this->beginWidget('CActiveForm', array(
        'action' => $this->createUrl('updatealerts', array('id'=>'new')),
        'method' => 'post'
    ));
?>
<table class="table table-alert">
    <tbody>
    <?php if($userAlertsRules): ?>
        <?php foreach($userAlertsRules as $rule): ?>
            <tr>
                <td style="width: 20%"><?= $rule->alert->name; ?></td>
                <td style="width: 23%">
                    <?= CHtml::hiddenField('account', $selectedAcc->number); ?>
                    <?= $form->hiddenField($rule, 'alert_code', array('value' => $rule->alert->code)); ?>
                    <?php if($rule->greater): ?>
                        <div class="greater not-edit-doc">
                            <b><?= Yii::t('Front','Higher than')?>:</b> <br>
                            <?= $rule->greater; ?> <?= $rule->account->currency->code;?>
                        </div>
                    <?php endif; ?>
                    <?php if($rule->less): ?>
                        <div class="lower not-edit-doc">
                            <b><?= Yii::t('Front','Lower than')?>:</b> <br>
                            <?= $rule->less; ?> <?= $rule->account->currency->code;?>
                        </div>
                    <?php endif; ?>
                    <?php if($rule->equal): ?>
                        <div class="equal not-edit-doc">
                            <b><?= Yii::t('Front','Equals to')?>:</b> <br>
                            <?= $rule->equal; ?> <?= $rule->account->currency->code;?>
                        </div>
                    <?php endif; ?>
                    <div class="edit-doc" style="display: none;">
                        <div class="field-row">
                            <div class="field-lbl">
                                <?= Yii::t('Front','Higher than')?>
                            </div>
                            <div class="field-input">
                                <?= $form->textField($rule, 'greater', array('class'=>'input-text'));?>
                                <div class="curr-lbl"><?= $selectedAcc->currency->code; ?></div>
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-lbl">
                                <?= Yii::t('Front','Lower than')?>
                            </div>
                            <div class="field-input">
                                <?= $form->textField($rule, 'less', array('class'=>'input-text'));?>
                                <div class="curr-lbl"><?= $selectedAcc->currency->code; ?></div>
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-lbl">
                                <?= Yii::t('Front','Equals to')?>
                            </div>
                            <div class="field-input">
                                <?= $form->textField($rule, 'equal', array('class'=>'input-text'));?>
                                <div class="curr-lbl"><?= $selectedAcc->currency->code; ?></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="lh" style="width: 29%">
                    <?php foreach($rule->emails as $alertEmail): ?>
                        <div class="str not-edit-doc"><?= $alertEmail->email->email; ?></div>
                    <?php endforeach; ?>
                    <div class="edit-doc" style="display: none;">
                        <div class="field-row">
                            <div class="field-lbl">
                                E-mail
                                <span class="tooltip-icon" title="tooltip text"></span>
                            </div>
                            <div class="field-input">
                                <?php foreach ($emailAddresses as $alertEmail) : ?>
                                    <label>
                                        <?= $form->checkBox($modelRule, "emails[{$alertEmail->id}]", array(
                                                'class'=>'input-checkbox',
                                                'checked' => $rule->inEmails($alertEmail)
                                            ));?>
                                        <?= $alertEmail->email; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="lh" style="width: 15%">
                    <?php foreach($rule->phones as $alertPhone): ?>
                        <div class="str not-edit-doc"><?= $alertPhone->phone->phone; ?></div>
                    <?php endforeach; ?>
                    <div class="edit-doc" style="display: none;">
                        <div class="field-row">
                            <div class="field-lbl">
                                Phone
                                <span class="tooltip-icon" title="tooltip text"></span>
                            </div>
                            <div class="field-input">
                                <?php foreach ($phones as $alertPhone) : ?>
                                    <label>
                                        <?= $form->checkBox($rule, "phones[{$alertPhone->id}]", array(
                                                'class'=>'input-checkbox',
                                                'checked' => $rule->inPhones($alertPhone)
                                            ));?>
                                        <?= $alertPhone->phone; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 13%" class="actions-td">
                    <div class="not-edit-doc">
                        <a href="#" class="button edit"></a>
                        <a data-url="<?=$this->createUrl('dropalerts', array('id' => $rule->id));?>" class="button remove"></a>
                    </div>
                    <div class="edit-doc" style="display: none;">
                        <a href="#" data-url="<?=$this->createUrl('updatealerts', array('id' => $rule->id));?>" class="button ok"></a>
                        <a href="#" class="button cancel"></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- add Rule -->
    <tr>
        <td colspan="5" class="table-form-subheader">Add rule</td>
    </tr>
    <tr class="form-row">
        <td colspan="2">
            <?= CHtml::hiddenField('account', $selectedAcc->number); ?>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Rule'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom rule-select">
                        <span class="select-custom-label">
                          Выберите
                        </span>
                        <?= $form->dropDownList($modelRule, 'alert_code', array_merge(array('' => Yii::t('Front', 'Choose')),Alerts::getAlertsChoices()), array('class' => 'select-invisible')); ?>
                        <span class="validation-icon"></span>
                    </div>
                </div>
                <div class="underline"></div>
            </div>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front','Higher than')?>
                </div>
                <div class="field-input">
                    <?= $form->textField($modelRule, 'greater', array('class'=>'input-text'));?>
                    <div class="curr-lbl"><?= $selectedAcc->currency->code; ?></div>
                </div>
            </div>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front','Lower than')?>
                </div>
                <div class="field-input">
                    <?= $form->textField($modelRule, 'less', array('class'=>'input-text'));?>
                    <div class="curr-lbl"><?= $selectedAcc->currency->code; ?></div>
                </div>
            </div>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front','Equals to')?>
                </div>
                <div class="field-input">
                    <?= $form->textField($modelRule, 'equal', array('class'=>'input-text'));?>
                    <div class="curr-lbl"><?= $selectedAcc->currency->code; ?></div>
                </div>
            </div>
            <div class="field-row">
                <a href="#" id="alert-add-btn" class="violet-button-slim-square">Add</a>
            </div>
        </td>
        <td>
            <div class="field-row">
                <div class="field-lbl">
                    E-mail
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input">
                <?php foreach ($emailAddresses as $alertEmail) : ?>
                    <label>
                        <?= $form->checkBox($modelRule, "emails[{$alertEmail->id}]", array('class'=>'input-checkbox'));?>
                        <?= $alertEmail->email; ?>
                    </label>
                <?php endforeach; ?>
                </div>
            </div>
        </td>
        <td colspan="2">
            <div class="field-row">
                <div class="field-lbl">
                    Phone
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input">
                    <?php foreach ($phones as $alertPhone) : ?>
                        <label>
                            <?= $form->checkBox($modelRule, "phones[{$alertPhone->id}]", array('class'=>'input-checkbox'));?>
                            <?= $alertPhone->phone; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>