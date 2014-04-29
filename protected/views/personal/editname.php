<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <div id="emails_edit">
    <div class="xabina-form-container">
	
		<div id="emails_edit">
			<div class="xabina-form-container">
				<div class="subheader">
					<?= Yii::t('Front', 'Personal details'); ?>
				</div>
				<table class="table xabina-table-personal">
					<tbody>
						<tr class="table-header">
							<th width="40%"><?= Yii::t('Front', 'First Name') ?></th>
							<th width="60%"><?= Yii::t('Front', 'Last Name') ?></th>
						</tr>
						<tr class="comment-tr">
							<td colspan="2" style="line-height: 1.43!important">
								<span class="rejected">
								<?= Yii::t('Front', 'If you want to change Your First and/or Last Name, You need to upload the new copy of Your Passport or ID') ?>
								</span>
							</td>
						</tr>
						<?php if($user->personal): ?>
						<tr class="form-sms-tr">
							<td><?= $user->personal->first_name ?></td>
							<td><?= $user->personal->last_name ?></td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
				<?php if($user->personal_documents): ?>
				<div class="subheader">
					<?= Yii::t('Front', 'Verified documents'); ?>
				</div>
				<table class="table xabina-table-personal">
					<tbody>
						<tr class="table-header">
							<th width="40%"><?= Yii::t('Front', 'File Type') ?></th>
							<th width="60%"><?= Yii::t('Front', 'Expiry Date') ?></th>
						</tr>
						<?php foreach($user->personal_documents as $doc): ?>
						<?php if(($doc->expiry_date - time()) <= 0): ?>
						<tr class="comment-tr border-red">
							<td colspan="2" style="line-height: 1.43!important">
								<span class="rejected">
								<?= Yii::t('Front', 'Your :type has expired. Please upload a copy of Your new :type below.', array(':type' => $doc->file_type)) ?>
								</span>
							</td>
						</tr>
						<tr class="form-sms-tr">
							<td><strong><?= $doc->file_type ?></strong></td>
							<td>
								<span class="rejected">
									<?= date('d.m.Y', $doc->expiry_date); ?>
								</span>
							</td>
						</tr>
						<?php elseif(($doc->expiry_date - time()) <= 3600*7*30*3): ?>
						<tr class="comment-tr border-yellow">
							<td colspan="2" style="line-height: 1.43!important">
								<span class="pending">
								<?= Yii::t('Front', 'Your document is about to expire in less than 3 months. We kindly advise you to upload new document, to avoid account suspention in the future') ?>
								</span>
							</td>
						</tr>
						<tr class="form-sms-tr">
							<td><strong><?= $doc->file_type ?></strong></td>
							<td>
								<span class="pending">
									<?= date('d.m.Y', $doc->expiry_date); ?>
								</span>
							</td>
						</tr>
							
						<?php else: ?>
						
						<tr class="form-sms-tr">
							<td><strong><?= $doc->file_type ?></strong></td>
							<td>
								<span class="approved">
									<?= date('d.m.Y', $doc->expiry_date); ?>
								</span>
							</td>
						</tr>
						<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php endif; ?>

				<div class="subheader">
					<?= Yii::t('Front', 'Verification documents'); ?>
				</div>
				<table class="table xabina-table-personal inner-table">
					<tbody>
						<tr class="table-header">
							<th><?= Yii::t('Front', 'Add Attachments'); ?></th>
						</tr>
						<tr class="add-attachment-form">
							<td>
								<?php $this->widget('WidgetUpload', array('inTable' => false))->html($user->personal)?>
								
								<?php $this->widget('WidgetUpload')->getFilesTable($user->personal, Yii::app()->user->id) ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="clearfix"></div>
		</div>
	
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a> 
		</div>
		</div>
    <div class="clearfix"></div>
  </div>
</div>
