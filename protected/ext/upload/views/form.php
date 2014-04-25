<?php if($this->inTable): ?>
<table class="add-attachment-form">
	<tbody>
		<tr>
			<th><?= Yii::t('Front', 'Add Attachments &amp; Notes'); ?></th>
		</tr>
		<tr>
			<td>
<?php endif; ?>
				<form enctype="multipart/form-data" name="upload" action="<?= Yii::app()->createUrl('file/upload', array('id' => (isset($model->id)) ? $model->id : Yii::app()->user->id)) ?>" method="post">
					<input type="hidden" name="type" value="<?= get_class($model) ?>">
					<table class="inner-table">
						<tbody><tr>
						<td style="width: 45%; ">
							<div class="form-cell">
								<div class="form-lbl" style="text-indent: -9999px">a</div>
								<div class="form-input">
									<label class="file-label">
										<span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
										<span class="file-name"><?= Yii::t('Front', 'File is not selected'); ?></span>
										<span class="no-file-name"><?= Yii::t('Front', 'File is not selected'); ?></span>
										<input id="uFile" type="file" class="file-input">
									</label>
									<div class="success-popup-cont">
										<div class="success-popup">
											<span></span>
											<div class="arr"></div>
										</div>
									</div>
								</div>

							</div>
						</td>
						<td style="width: 45%; ">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Comments') ?><span title="<?= Yii::t('Front', 'Comments to file') ?>" class="tooltip-icon"></span>
								</div>
								<div class="form-input">
									<textarea name="description" class="attach-textarea"></textarea>
								</div>
							</div>
						</td>
						<td style="width: 45%; ">
							<input type="submit" class="add-button" value="<?= Yii::t('Front', 'Add'); ?>" />
						</td>
						</tr>
					</tbody></table>
				</form>		
<?php if($this->inTable): ?>				
			</td>
		</tr>
	</tbody>
</table>
<?php endif; ?>