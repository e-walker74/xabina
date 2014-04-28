<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="xabina-form-container">
	<table class="xabina-table-upload transaction-table-cont" id="printTable">
		<tbody><tr class="header-tr">
			<td>
				<?= Yii::t('Front', 'Transaction details') ?>
				<div class="transaction-buttons-cont">
					<a class="button download" href="#"></a>
					<a class="button send" href="#"></a>
					<a class="button print" href="javaScript:void(0)" onclick="js:printDiv('printTable')" ></a>
				</div>
			</td>
		</tr>
		<tr class="form-tr">
			<td>
				<div class="transaction-info-cont">
					<table class="transaction-info-table table">
						<tbody>
						<?php foreach($trans->info->getPublicAttrs() as $label => $value): ?>
						<tr>
							<td class="name" width="20%"><?= $label ?></td>
							<td width="80%"><?= $value ?></td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td class="name" style="vertical-align: middle"><?= Yii::t('Front', 'Category') ?> </td>
							<td>
								<div class="select-custom select-category">
									<span class="select-custom-label">
										<?php if($trans->category): ?>
											<?= $trans->category->title ?>
										<?php else: ?>
											<?= Yii::t('Front', 'Choose'); ?>
										<?php endif; ?>
									</span>
									<select data-url="<?= Yii::app()->createUrl('/accounts/updatecategory', array('id' => $trans->id)) ?>" id="transaction-category-select" name="" class=" select-invisible country-select">
									<?php if(!$trans->category): ?>
										<option disabled="disabled" selected="selected"><?= Yii::t('Front', 'Choose'); ?></option>
									<?php endif; ?>
										<?php foreach(Transactions_Categories::model()->findAll('user_id = :uid OR user_id = 0', array(':uid' => Yii::app()->user->id)) as $trCat): ?>
											<option value="<?= $trCat->id ?>"><?= $trCat->title ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="transaction-buttons-cont">
									<a href="#" class="button edit"></a>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php $this->widget('WidgetUpload')->getFilesTable($trans, Yii::app()->user->id) ?>
								
								<?php $this->renderPartial('application.views.accounts._notes', array('trans' => $trans)); ?>
							</td>
						</tr>
					</tbody></table>
				</div>
			</td>
		</tr>
	</tbody></table>
	
	<table class="add-attachment-form">
		<tbody>
			<tr>
				<th><?= Yii::t('Front', 'Add Attachments &amp; Notes') ?></th>
			</tr>
			<tr>
				<td>
					<?php $this->widget('WidgetUpload', array('inTable' => false))->html($trans)?>
				</td>
			</tr>
			<tr>
				<td>
					<form id="addNotes" action="<?= Yii::app()->createUrl('/accounts/addnotetotransaction', array('id' => $trans->id)) ?>" method="POST">
					<table class="inner-table">
						<tbody><tr>
							<td style="width: 90%">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Note'); ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'tool tip for notes'); ?>"></span>
									</div>
									<div class="form-input">
										<textarea name="note-text" class="attach-textarea"></textarea>
									</div>
								</div>
							</td>
							<td style="width: 10%">
								<input type="submit" class="add-button" value="<?= Yii::t('Front', 'Add') ?>">
							</td>
						</tr>
					</tbody></table>
					</form>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="form-submit transaction-submit">
		<a href="<?= Yii::app()->createUrl('/accounts/cardbalance', array('account' => $trans->account->number)) ?>" class="submit-button button-back">Back</a>
	</div>
	</div>
</div>