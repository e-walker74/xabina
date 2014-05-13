<div class="add-attachment-form custom borderles">
    <div enctype="multipart/form-data" id="<?=$this->formId?>"
          name="upload" class="form-file-widget"
          action="<?= Yii::app()->createUrl('file/upload', array('inTable' => $this->inTable, 'id' => (isset($model->id)) ? $model->id : Yii::app()->user->id)) ?>" method="post">
        <input type="hidden" name="type" value="<?= get_class($model) ?>">
        <input type="hidden" name="typeSuffix" value="<?=$this->typeSuffix?>">
        <div class="pull-right">
            <button type="submit" class="add-button"><?= Yii::t('Front', 'Add'); ?></button>
        </div>
        <div class="attach-wrap">
            <div class="row">
                <div class="col-md-6 file-block">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Select a file') ?><span title='<?= Yii::t('Front', 'Press "select" button to add new file') ?>' class="tooltip-icon"></span>
                    </div>
                    <div class="form-input file">
                        <label class="file-label">
                            <span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
                            <span class="file-name"><?= Yii::t('Front', 'File is not selected'); ?></span>
                            <span class="no-file-name"><?= Yii::t('Front', 'File is not selected'); ?></span>
                            <input type="file" class="file-input" id="<?=$this->formId?>-file-input">
                        </label>
                        <div class="error-message"></div>
                    </div>

                </div>
                <div class="col-md-6 comment comment-block">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Comments') ?><span title="<?= Yii::t('Front', 'You can add any comment to uploaded file, using text field below.') ?>" class="tooltip-icon"></span>
                    </div>
                    <div class="form-input">
                        <textarea name="description" maxlength="250" class="attach-textarea autosize"></textarea>
                    </div>
                    <div class="error-message"></div>
                </div>
            </div>
        </div>
    </div>
</div>