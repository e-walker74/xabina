<?php if($this->inTable): ?>
<table class="add-attachment-form">
	<tbody>
		<tr>
			<th><?= Yii::t('Front', 'Add Attachments'); ?></th>
		</tr>
		<tr>
			<td>
<?php endif; ?>
				<form enctype="multipart/form-data" id="file-form" name="upload" action="<?= Yii::app()->createUrl('file/upload', array('inTable' => $this->inTable, 'id' => (isset($model->id)) ? $model->id : Yii::app()->user->id)) ?>" method="post">
					<input type="hidden" name="type" value="<?= get_class($model) ?>">
					<div class="form-cell file-block">
						<div class="form-lbl">
							<?= Yii::t('Front', 'Select a file') ?><span title='<?= Yii::t('Front', 'Press "select" button to add new file') ?>' class="tooltip-icon"></span>
						</div>
						<div class="form-input file">
							<label class="file-label">
								<span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
								<span class="file-name"><?= Yii::t('Front', 'File is not selected'); ?></span>
								<span class="no-file-name"><?= Yii::t('Front', 'File is not selected'); ?></span>
								<input id="uFile" type="file" class="file-input">
							</label>
							<div class="error-message"></div>
						</div>

					</div>
					<div class="form-cell comment comment-block">
						<div class="form-lbl">
							<?= Yii::t('Front', 'Comments') ?><span title="<?= Yii::t('Front', 'You can add any comment to uploaded file, using text field below.') ?>" class="tooltip-icon"></span>
						</div>
						<div class="form-input">
							<textarea name="description" class="attach-textarea autosize"></textarea>
						</div>
						<div class="error-message"></div>
					</div>
					<input type="submit" class="add-button" value="<?= Yii::t('Front', 'Add'); ?>" />
				</form>		
<?php if($this->inTable): ?>				
			</td>
		</tr>
	</tbody>
</table>
<?php endif; ?>