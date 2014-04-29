<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div id="attachments-block">
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
								<a class="button delete dialog-file-delete" href="<?= Yii::app()->createUrl('/file/delete', array('id' => $file->id)) ?>"></a>
							</div>
							<div class="edit-doc transaction-buttons-cont">
								<a class="button ok" href="<?= Yii::app()->createUrl('/file/edit', array('id' => $file->id)) ?>"></a>
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

<?php endif; ?>

<?php if($this->showDialog): ?>
<div class="dialog-file-delete-dialog">
	<div class="arr"></div>
	<?= Yii::t('Front', 'Are you sure you want to delete this file?'); ?>
	<a href="#" class="no" tabindex="-1"><?= Yii::t('Front', 'No'); ?></a>
	<a href="#"  class="yes" tabindex="-1"><?= Yii::t('Front', 'Yes'); ?></a>
</div>
<script>
	$( ".dialog-file-delete-dialog" ).dialog({
        autoOpen: false,
        appendTo: '#top_container .clearfix',
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        position:{
            my: 'right top',
            at: 'right bottom',
            of: ".user-logout"
        },
        show: 'fadeIn',
        resizable: false
    });
</script>
<?php endif; ?>