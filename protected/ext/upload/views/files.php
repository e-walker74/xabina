<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div id="<?=$this->formId?>-attachments-block" class="attachments-block">
<?php endif; ?>
<?php if(count($files)): ?>
<?php if($this->inTable): ?>
<!--<div class="inner-header"><?= Yii::t('Front', 'Attachment') ?></div>-->
<table class="inner-table attachments-table">
	<tbody>
		<tr>
			<th style="width:13%"><?= Yii::t('Front', 'File type') ?></th>
			<th style="width:42%"><?= Yii::t('Front', 'File comments') ?></th>
			<th style="width:25%"><?= Yii::t('Front', 'Sender') ?></th>
			<th style="width:20%"></th>
		</tr>
		<tr>
			<td colspan="4">
<?php endif; ?>
				<ul class="attachments-list list-unstyled">
					<?php foreach($files as $file): ?>
					<li>
						<div class="attach-img">
							<a href="<?= Yii::app()->createUrl('/file/get', array('id' => $file->id, 'name' => $file->user_file_name)) ?>">
								<img alt="" src="<?= Yii::app()->createUrl('/file/getMinimize', array('id' => $file->id, 'name' => $file->user_file_name)) ?>">
							</a>
						</div>
						<div class="attach-comment">
							<div class="not-edit-doc">
							<?= $file->shortDescription ?>
							</div>
							<div class="edit-doc">
								<textarea name="edit_file_comment" ><?= $file->description ?></textarea>
								<div class="error-message"></div>
							</div>
						</div>
						<div class="attach-sender">
							<?= $file->user->fullName; ?>
							<div class="datetime"><span><?= date('d.m.Y', $file->created_at) ?></span><?= date('H:i', $file->created_at) ?></div>

						</div>
						<div class="attach-actions">
							<div class="not-edit-doc transaction-buttons-cont">
								<a class="button download" href="<?= Yii::app()->createUrl('/file/get', array('id' => $file->id, 'name' => $file->user_file_name)) ?>"></a>
								<a class="button edit" href="javaScript:void(0)" onclick="editRow($(this).parents('li'))"></a>
								<a class="button delete dialog-file-delete" data-url="<?= Yii::app()->createUrl('/file/delete', array('id' => $file->id)) ?>" href="javaScript:void(0)"></a>
							</div>
							<div class="edit-doc transaction-buttons-cont">
								<a class="button ok" href="<?= Yii::app()->createUrl('/file/edit', array('id' => $file->id)) ?>"></a>
								<a class="button cancel" href="javaScript:void(0)"></a>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
<?php if($this->inTable): ?>
			</td>
		</tr>

	</tbody>
</table>
<?php endif; ?>
<?php endif; ?>

<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<script>
$(document).ready(function(){
	$('#<?=$this->formId?>-attachments-block .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			link = $(this).parents('.popover').prev('a')
			deletefile(link);
			return false;
		}
	})

})
</script>
<?php endif; ?>


