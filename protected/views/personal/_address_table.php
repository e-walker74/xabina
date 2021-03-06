<table class="table xabina-table-personal">
<tbody>
<tr class="table-header">
    <th style="width: 38%"><?= Yii::t('Front', 'Address'); ?></th>
    <th style="width: 24%"><?= Yii::t('Front', 'Type'); ?></th>
    <th style="width: 22%"><?= Yii::t('Front', 'Status'); ?></th>
    <th style="width: 16%"></th>
</tr>
<?php foreach($user->addresses as $addr):?>
    <tr class="address-tr">
        <td class="address">
            <?= $addr->address ?><br>
            <?php if($addr->address_optional):?>
                <?= $addr->address_optional ?><br>
            <?php endif; ?>
            <?= $addr->indx?>
            <?= $addr->city?><?php if($addr->country): ?> (<?= $addr->country->code?>)<?php endif; ?>
        </td>
        <td>
            <div class="relative">
                <?= $addr->emailType->type_name ?>
            </div>
        </td>
        <td>
            <a <?php if($addr->is_master == 1):?>style="display:none;"<?php endif; ?> class="make-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'address', 'id' => $addr->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
            <span <?php if($addr->is_master == 0):?>style="display:none;"<?php endif; ?> class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
        </td>
        <td class="actions-td">
            <div class="transaction-buttons-cont">
                <a class="button edit" href="javaScript:void(0)" onclick="resetPage(); $(this).parents('tr').next('tr').toggle('slow'); $(this).parents('tr').hide()" ></a>
                <?php if(!$addr->is_master): ?>
                    <a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'address', 'id' => $addr->id)) ?>"></a>
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <tr class="edit-address-tr" style="display:none;">
        <td colspan="4">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'adress_form_'.$addr->id,
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'action' => $this->createUrl('personal/editaddress'),
                'errorMessageCssClass' => 'error-message',
                'htmlOptions' => array(
                    'class' => 'form-validable',
                    'style' => 'position: relative;',
                ),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                    'errorCssClass' => 'input-error',
                    'successCssClass' => 'valid',
                    'afterValidate' => 'js:Personal.afterValidate',
                    'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                ),
            )); ?>
            <?= $form->hiddenField($addr, 'id'); ?>
            <div class="transaction-buttons-cont to-row">
                <input type="submit" value="" class="button ok">
                <a class="button cancel" href="javaScript:void(0)"></a>
            </div>
            <div class="field-row">
                <div class="field-row left-coll">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'Address Line 1'); ?>
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="field-input">
                        <?= $form->textField($addr, 'address', array('class' => 'input-text')); ?>
                        <?= $form->error($addr, 'address'); ?>
                    </div>
                </div>
                <div class="field-row right-coll">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'Address Line 2 (optional)'); ?>
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="field-input">
                        <?= $form->textField($addr, 'address_optional', array('class' => 'input-text')); ?>
                        <?= $form->error($addr, 'address_optional'); ?>
                    </div>
                </div>
            </div>
            <div class="field-row">
                <div class="field-row left-coll">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'Index'); ?>
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="field-input">
                        <?= $form->textField($addr, 'indx', array('class' => 'input-text')); ?>
                        <?= $form->error($addr, 'indx'); ?>
                    </div>
                </div>
                <div class="field-row right-coll">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'City'); ?>
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="field-input">
                        <?= $form->textField($addr, 'city', array('class' => 'input-text')); ?>
                        <?= $form->error($addr, 'city'); ?>
                    </div>
                </div>
            </div>

            <div class="field-row">
                <div class="field-row left-coll">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'Сountry'); ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'Choose country'); ?>"></span>
                    </div>
                    <div class="field-input ">
                        <div class="select-custom">
                            <span class="select-custom-label"><?= $addr->country->name; ?> </span>
                            <?=
                            $form->dropDownList($addr, 'country_id', Countries::all(), array(
                                'class' => 'country-select select-invisible',
                                'options' => array('' => array('disabled' => true)),
                            )); ?>
                        </div>
                        <?= $form->error($addr, 'country_id'); ?>
                    </div>
                </div>
                <div class="field-row right-coll">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'Address Type'); ?>
                        <span class="tooltip-icon"
                              title="<?= Yii::t('Front', 'Address type tooltip'); ?>"></span>
                    </div>
                    <div class="field-input ">
                        <div class="select-custom">
									<span class="select-custom-label">
										<?= $addr->emailType->type_name; ?>
									</span>
                            <?=
                            $form->dropDownList($addr, 'email_type_id', Users_EmailTypes::all(), array(
                                'class' => 'country-select select-invisible item1',
                                'options' => array('' => array('disabled' => true)),
                            )); ?>
                        </div>
                        <?= $form->error($addr, 'email_type_id'); ?>
                    </div>
                </div>
            </div>

            <?php $this->endWidget(); ?>
        </td>
    </tr>
<?php endforeach; ?>
<?php if(!$user->addresses): ?>
    <tr class="comment-tr">
        <td colspan="4" style="line-height: 1.43!important">
					<span class="rejected">
						<?= Yii::t('Front', 'You have not added any address yet. You can add new address by clicking "Add new" button.') ?>
					</span>
        </td>
    </tr>
<?php endif; ?>

<tr>
    <td class="add-new-td" colspan="4">
        <a class="table-btn" onclick="resetPage(); $(this).parents('tr').hide()" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
    </td>
</tr>
<tr class="prof-form">
    <td colspan="4" class="table-form-subheader">
        <div class="table-subheader"><?= Yii::t('Front', 'Add address'); ?></div>
    </td>
</tr>
<tr class="new-address-tr prof-form">
    <td colspan="4" style="border-right: 1px solid #ddd" >
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'adress_form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'action' => $this->createUrl('personal/editaddress'),
            'errorMessageCssClass' => 'error-message',
            'htmlOptions' => array(
                'class' => 'form-validable',
                'style' => 'position: relative;',
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'errorCssClass' => 'input-error',
                'successCssClass' => 'valid',
                'afterValidate' => 'js:Personal.afterValidate',
                'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
            ),
        )); ?>
        <?= $form->hiddenField($model, 'id'); ?>
        <div class="transaction-buttons-cont to-row">
            <input type="submit" value="" class="button ok">
            <a class="button cancel" href="javaScript:void(0)"></a>
        </div>
        <div class="filed-row">
            <div class="field-row left-coll">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Address Line 1'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input">
                    <?= $form->textField($model, 'address', array('class' => 'input-text')); ?>
                    <?= $form->error($model, 'address'); ?>
                </div>

            </div>

            <div class="field-row right-coll edit-select">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Address Line 2 (optional)'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input">
                    <?= $form->textField($model, 'address_optional', array('class' => 'input-text')); ?>
                    <?= $form->error($model, 'address_optional'); ?>
                </div>
            </div>
        </div>
        <div class="filed-row">
            <div class="field-row left-coll">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Index'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input">
                    <?= $form->textField($model, 'indx', array('class' => 'input-text')); ?>
                    <?= $form->error($model, 'indx'); ?>
                </div>
            </div>

            <div class="field-row right-coll edit-select">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'City'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="field-input">
                    <?= $form->textField($model, 'city', array('class' => 'input-text')); ?>
                    <?= $form->error($model, 'city'); ?>
                </div>
            </div>
        </div>
        <div class="filed-row">
            <div class="field-row left-coll">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Сountry'); ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'Choose country'); ?>"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?> </span>
                        <?=
                        $form->dropDownList($model, 'country_id', Countries::all(), array(
                            'class' => 'country-select select-invisible',
                            'options' => array('' => array('disabled' => true)),
                        )); ?>
                    </div>
                    <?= $form->error($model, 'country_id'); ?>
                </div>
            </div>

            <div class="field-row right-coll edit-select">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Address Type'); ?>
                    <span class="tooltip-icon"
                          title="<?= Yii::t('Front', 'Address type tooltip'); ?>"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom">
									<span class="select-custom-label">
										<?= Yii::t('Front', 'Choose'); ?>
									</span>
                        <?=
                        $form->dropDownList($model, 'email_type_id', Users_EmailTypes::all(), array(
                            'class' => 'country-select select-invisible item1',
                            'options' => array('' => array('disabled' => true)),
                        ));
                        ?>
                    </div>
                    <?= $form->error($model, 'email_type_id'); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </td>

</tr>
</tbody>
</table>