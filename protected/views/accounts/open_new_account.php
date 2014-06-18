<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'Open new account') ?></div>
    <div class="xabina-progress-bar">
        <div class="step step1 current">
            <div class="step-name">Choose account</div>
            <div class="step-arr"></div>
        </div>
        <div class="step step3">
            <div class="step-name">Terms &amp; Fees</div>
            <div class="step-arr"></div>
        </div>
    </div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'new-account-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'errorMessageCssClass' => 'error-message',
        'htmlOptions' => array(
            'class' => 'form-validable',
        ),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'errorCssClass'=>'input-error',
            'afterValidate' => 'js:afterValidate',
            'afterValidateAttribute' => 'js:afterValidateAttribute'
        ),
    )); ?>
        <div class="xabina-form-container ">
            <div class="form-row clearfix">
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="field-lbl">
                        <?= $model->getAttributeLabel('name') ?>
                        <span title="<?= Yii::t('Front', 'Name of new accountt') ?>" class="tooltip-icon"></span>
                    </div>
                    <div class="field-input">
                        <?= $form->textField($model, 'name', array('autocomplete' => 'off','class'=>'input-text')); ?>
                        <?= $form->error($model, 'name'); ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 	">
                    <div class="field-lbl">
                        <?= $model->getAttributeLabel('currency_id') ?>
                        <span title="<?= Yii::t('Front', 'currency title') ?>" class="tooltip-icon"></span>
                    </div>
                    <div class="field-input">
                        <div class="select-custom full-width">
                            <span class="select-custom-label">Выберите</span>
                        <?= CHtml::activeDropDownList($model, 'currency_id',
                            CHtml::listData(Currencies::model()->findAll(), 'id', 'title'),
                            array('class' => 'сurrency-select select-invisible')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="field-lbl">
                        <?= Yii::t('Front', 'Type of new account') ?>
                        <span title="<?= Yii::t('Front', 'Account type title') ?>" class="tooltip-icon"></span>
                    </div>
                    <div class="field-input">
                        <div class="select-custom full-width">
                            <span class="select-custom-label">select</span>
                        <?= CHtml::activeDropDownList($model, 'type_id',
                            CHtml::listData(AccountsCategory::model()->findAll(), 'id', 'title'),
                            array('class' => 'type-select select-invisible')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="type-tbl tbl-1" id="type-container">
                        <ul class="type-tbl-col type-params">
                            <li><?= Yii::t('Front', 'Name accountt') ?><span title="Название" class="tooltip-icon"></span></li>
                            <li><?= Yii::t('Front', 'Bet') ?><span title="Ставка" class="tooltip-icon"></span></li>
                            <li><?= Yii::t('Front', 'Payment') ?><span title="Выплата" class="tooltip-icon"></span></li>
                            <li><?= Yii::t('Front', 'Term') ?><span title="Срок" class="tooltip-icon"></span></li>
                            <li><?= Yii::t('Front', 'Currencyt') ?><span title="Валюта" class="tooltip-icon"></span></li>
                            <li class="type-small-text"><span><?= Yii::t('Front', 'Choose you card') ?> →</span></li>
                        </ul>

                    </div>
                </div>
            </div>
            <?= $form->hiddenField($model, 'type_id', array('id'=>'account-type-id', 'value' => 0)); ?>
            <div class="form-submit">
                <div class="submit-button button-back">Back</div>
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>