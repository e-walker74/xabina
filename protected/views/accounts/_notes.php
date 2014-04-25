<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div id="notes-list">
<?php endif; ?>
<?php if($trans->notes): ?>
<div class="inner-header"><?= Yii::t('Front', 'Notes') ?></div>
	<table class="inner-table attachments-table">
		<tbody>
		<tr>
			<th style="width:55%"><?= Yii::t('Front', 'Note') ?></th>
			<th style="width:25%"><?= Yii::t('Front', 'Sender') ?></th>
			<th style="width:20%"></th>
		</tr>
		<tr>
			<td colspan="4">
				<ul class="attachments-list list-unstyled">
					<?php foreach($trans->notes as $note): ?>
						<li>
							<div class="attach-note">
								<?php if(mb_strlen($note->text) > 100): ?>
									<span><?= SiteService::subStrEx($note->text, 100); ?></span>
									<a href="javaScript:void(0)" onclick="$(this).prev('span').hide(); $(this).hide(); $(this).next('span').slideDown('slow');" class="show-more"><?= Yii::t('Front', 'show more') ?></a>
									<span style="display:none;"><?= $note->text ?></span>
								<?php else: ?>
									<?= $note->text ?>
								<?php endif; ?>
							</div>
							<div class="attach-sender">
								<?= $note->user->fullName ?>
								<div class="datetime"><span><?= date('d.m.Y', $note->created_at) ?></span><?= date('H:i', $note->created_at) ?></div>
							</div>
							<div class="attach-actions">
								<div class="transaction-buttons-cont">
									<a class="button download" href="#"></a>
									<a class="button edit" href="#"></a>
									<a data-confirm-text="<?= Yii::t('Front', 'Are you sure you want to delete this note') ?>" class="button delete" href="<?= Yii::app()->createUrl('/accounts/deleteNote', array('id' => $note->id)) ?>"></a>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
		</tbody>
	</table>
<?php endif; ?>
<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<?php endif; ?>