<? // $form->errorSummary($model); ?>
<div class="col-lg-9 col-md-9 col-sm-9">
  <div class="h1-header">
    <?= Yii::app()->controller->action ->id == 'new' ? Yii::t('Front', 'New message') :   Yii::t('Front', 'Received messages');?>
  </div>
  <? $this->widget('MessagesMenu'); ?>
  <div class="reply-container">
    <div class="message-headers">
    
		<?php $this->renderPartial('_form', array('model' => $model)); ?>
      
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
                    <div class="violet-button-slim">
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
<script>
$(window).bind('beforeunload', function(){
	return '<?= Yii::t('Front', 'Are you sure you want to leave? Your message will be deleted'); ?>';
});
$('.message-controls a').click(function(){
	$(window).unbind('beforeunload')
})
</script>
