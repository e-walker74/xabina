<div class="xabina-form-normal">
    <table class="table  xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 42%"><?= Yii::t('Personal', 'Select Questions') ?></th>
            <th style="width: 49%"><?= Yii::t('Personal', 'Answers') ?></th>
            <th style="width: 9%"></th>
        </tr>
        <?php foreach($user->questions as $ques): ?>
            <tr class="question-row" data-value="<?= $ques->question->id ?>">
                <td><?= $ques->question->question ?></td>
                <td>
                    <div class="masked-value">**********</div>
                    <input class="original-value" type="hidden" value="<?= $ques->answer ?>">
                    <a href="javascript:void(0);" class="mask-toggle"></a>
                </td>
                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button delete" href="javaScript:void(0)" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'question', 'id' => $ques->id)) ?>" ></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'users_securityquestions',
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
                        'successCssClass'=>'valid',
                        'afterValidate' => 'js:Personal.afterValidate',
                        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                    ),
                )); ?>
                <?php $model = new Users_Securityquestions(); ?>
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Personal', 'Question') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Personal', 'questions_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <div class="select-custom">
                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $model,
                                        'question_id',
                                        CHtml::listData($question, 'id', 'question'),
                                        array(
                                            'class' => 'country-select select-invisible',
                                            'empty' => Yii::t('Personal', 'Select'),
                                        )
                                    ); ?>
                                    <?= $form->error($model, 'question_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Answer'); ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Personal', 'questions_answer_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'answer', array('class' => 'input-text')); ?>
                                <?= $form->error($model, 'answer'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 ">
                        <div class="transaction-buttons-cont edit-submit-cont">
                            <input type="submit" value="" class="button ok"/>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
        <?php if(empty($user->questions)): ?>
            <tr>
                <td colspan="3">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'users_securityquestions-two',
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
                            'successCssClass'=>'valid',
                            'afterValidate' => 'js:Personal.afterValidate',
                            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                        ),
                    )); ?>
                    <?php $model = new Users_Securityquestions(); ?>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Question') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'questions_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <div class="select-custom">
                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $model,
                                            'question_id',
                                            CHtml::listData($question, 'id', 'question'),
                                            array(
                                                'class' => 'country-select select-invisible',
                                                'empty' => Yii::t('Personal', 'Select'),
                                            )
                                        ); ?>
                                        <?= $form->error($model, 'question_id'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Answer'); ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'questions_answer_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model, 'answer', array('class' => 'input-text')); ?>
                                    <?= $form->error($model, 'answer'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" value="" class="button ok"/>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>