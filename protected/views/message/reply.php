<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'messages',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    //'action' => $this->createUrl('message/save'),
    //'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
        //'onsubmit'=>"return false;",/* Disable normal form submit */
        //'onkeypress'=>" if(event.keyCode == 13){ send(); } "
    ),
    //'focus'=>array($model,'first_name'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid',
        'afterValidate' => 'js:function(form, data, hasError) {
                    form.find("input").removeClass("input-error");
                    form.find("input").parent().removeClass("input-error");
                    form.find(".validation-icon").fadeIn();
                    if(hasError) {
                        for(var i in data) {
                            $("#"+i).addClass("input-error");
                            $("#"+i).parent().addClass("input-error");
                            $("#"+i).next(".validation-icon").fadeIn();
                        }
                        return false;
                    }
                    else {
                        return true;
                    }
                }',
        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                    if(hasError){
                        if(!$("#"+attribute.id).hasClass("input-error")){
                            $("#"+attribute.id+"_em_").hide().slideDown();
                        }
                        $("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
                        $("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
                        $("#"+attribute.id).next(".validation-icon").fadeIn();
                    } else {
                        if($("#"+attribute.id).hasClass("input-error")){
                            $("#"+attribute.id+"_em_").show().slideUp();
                        }
                        $("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
                        $("#"+attribute.id).next(".validation-icon").fadeIn();
                        $("#"+attribute.id).addClass("valid");
                    }
                }'
    ),
)); ?>
<?= $form->errorSummary($model); ?>

<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header">
        <?= Yii::t('Front', 'Received messages'); ?>
    </div>
    <? $this->widget('MessagesMenu'); ?>
    <div class="xabina-alert">
        <?= Yii::t('Front', 'In order to change Your Personal Details, please upload the new copy of Your ID (passport, driving licence, etc.)'); ?>
    </div>
    <div class="reply-container">
        <div class="message-headers">

            <div class="message-controls">
                <?=CHtml::link(Yii::t('Front', 'Send message'), "#", array(
                        'submit' => array('/message/save/send/'. $id .'/' . $dialog_id),
                        'csrf' => true,
                        'class' => 'button-violet'
                    )
                ); ?>

                <a class="button-violet" href="#" id="attachment_add">
                    <?= Yii::t('Front', 'Add attachment'); ?>
                </a>

                <?=CHtml::link(Yii::t('Front', 'Save message'), "#", array(
                        'submit' => array('/message/save/save/'. $id .'/' . $dialog_id),
                        'csrf' => true,
                        'class' => 'button-violet'
                    )
                ); ?>
                <?php /* CHtml::link(Yii::t('Front', 'Cancel'), "#", array(
                        'submit' => array('/message/new/cancel/'.$model->id),
                        'csrf' => true,
                        'class' => 'button-violet'
                    )
                ); */
                ?>
                
                <a class="button-violet" href="<?= Yii::app()->createUrl('/message/cancel/' . $model->id) ?>" id="attachment_add">
                    <?= Yii::t('Front', 'Cancel'); ?>
                </a>
            </div>
            <table class="message-headers-table">
                <tbody>
                <tr>
                    <td><div style="height: 5px"></div></td>
                    <td></td>
                </tr>
                <tr>
                    <td width="12%"><?= Yii::t('Front', 'To:'); ?></td>
                    <td width="88%">
                        <div class="select-custom">
                            <span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?></span>
                            <?=$form->dropDownList($model, 'to_id', Messages_To::all(), array(
                                'class' => 'country-select select-invisible',
                            )); ?>
                        </div>
                        <?= $form->error($model, 'to_id'); ?></td>
                </tr>
                <tr>
                    <td><div style="height: 14px"></div></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'Subject:'); ?></td>
                    <td><div class="select-custom">
                            <span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?></span>
                            <?=$form->dropDownList($model, 'subject_id', Messages_Subject::all(), array(
                                'class' => 'country-select select-invisible',
                            )); ?>
                        </div>
                        <?= $form->error($model, 'subject_id'); ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <?= $form->textArea($model, 'message', array('class' => 'message-reply-textarea')); ?>
            <?= $form->error($model, 'message'); ?>
            <!-- <input type="text" value="<?//empty($dialog_id) ? 0 : $dialog_id?>" name="Messages[dialog_id]"/>-->

            <div class="xabina-form-container" id="message-reply-attachment">
                <table class="xabina-table-transaction-document xabina-table-upload">
                    <tbody>
                    <tr class="form-tr">
                        <td style="width: 44%;"><div class="td-cont field-input">
                                <div class="field-row">
                                    <div class="field-lbl">
                                        <?= Yii::t('Front', 'File Type'); ?>
                                        <span class="tooltip-icon" title="tooltip text"></span></div>
                                    <div class="field-input">
                                        <div class="select-custom"> <span class="select-custom-label">
                        <?= Yii::t('Front', 'Choose'); ?>
                        </span>
                                            <select class="country-select select-invisible">
                                            </select>
                                            <span class="validation-icon"></span></div>
                                    </div>
                                </div>
                                <div class="field-row">
                                    <div class="field-lbl">
                                        <?= Yii::t('Front', 'Comments'); ?>
                                        <span class="tooltip-icon" title="tooltip text"></span></div>
                                    <div class="field-input">
                                        <textarea class="textarea file-comments-textarea" name="" id="" cols="30"
                                                  rows="10"></textarea>
                                    </div>
                                </div>
                            </div></td>
                        <td style="width: 44%;"><div class="td-cont ">
                                <div class="field-row">
                                    <div class="field-lbl">
                                        <?= Yii::t('Front', 'File Upload'); ?>
                                        <span class="tooltip-icon" title="tooltip text"></span></div>
                                    <div class="file-row">
                                        <?= Yii::t('Front', 'File is loaded:'); ?>
                                        <span class="file-name">
                      <?= Yii::t('Front', 'Skan passport 1'); ?>
                      </span> <span class="remove-file"></span></div>
                                    <div class="file-row">
                                        <?= Yii::t('Front', 'File is loaded:'); ?>
                                        <span class="file-name">
                      <?= Yii::t('Front', 'Skan passport 1'); ?>
                      </span> <span class="remove-file"></span></div>
                                    <label class="file-label"> <span class="file-button">
                      <?= Yii::t('Front', 'Select'); ?>
                      </span>
                                        <?= Yii::t('Front', 'File is not selected'); ?>
                                        <input class="file-input" type="file">
                                    </label>
                                </div>
                                <div class="field-row">
                                    <div
                                        class="violet-button-slim">
                                        <?= Yii::t('Front', 'Upload selected files'); ?>
                                    </div>
                                </div>
                            </div></td>
                        <td width="12%"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <? if(!empty($dialogs)):?>
        <?php $this->renderPartial('_dialogs', array('dialogs' => $dialogs)); ?>
    <? endif;?>
</div>
<?php $this->endWidget(); ?>
