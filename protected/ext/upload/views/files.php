<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div id="attachments-block">
<?php endif; ?>
<?php if(count($files)): ?>
<?php if($this->inTable): ?>
<div class="inner-header"><?= Yii::t('Front', 'Attachment') ?></div>
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
							<img alt="" src="<?= Yii::app()->createUrl('/file/getMinimize', array('id' => $file->id, 'name' => $file->user_file_name)) ?>">
						</div>
						<div class="attach-comment">
							<div class="not-edit-doc">
							<?php if(mb_strlen($file->description) > 100): ?>
								<span><?= SiteService::subStrEx($file->description, 100); ?></span>
								<a href="javaScript:void(0)" onclick="$(this).prev('span').hide(); $(this).hide(); $(this).next('span').slideDown('slow');" class="show-more"><?= Yii::t('Front', 'show more') ?></a>
								<span style="display:none;"><?= $file->description ?></span>
							<?php else: ?>
								<?= $file->description ?>
							<?php endif; ?>
							</div>
							<div class="edit-doc">
								<textarea name="edit_file_comment" ></textarea>
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
								<a class="button delete" data-confirm-text="<?= Yii::t('Front', 'Are you sure You want to delete file?') ?>" href="<?= Yii::app()->createUrl('/file/delete', array('id' => $file->id)) ?>"></a>
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