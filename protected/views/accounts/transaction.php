<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="xabina-form-container">
	<table class="xabina-table-upload transaction-table-cont" id="printTable">
		<tbody><tr class="header-tr">
			<td>
				<?= Yii::t('Front', 'Transaction details') ?>
                <?php $form=$this->beginWidget('CActiveForm', array(
                        'method'=>'get',
                        'id' => 'searchForm',
                        'htmlOptions' => array(
                            'data-pdf-url' => $this->createUrl('/banking/accounts/transaction/'.$trans->id.'/pdf/'),
                            'data-doc-url' => $this->createUrl('/banking/accounts/transaction/'.$trans->id.'/doc'),
                            'data-csv-url' => $this->createUrl('/banking/accounts/transaction/'.$trans->id.'/csv/')
                        ),
                    )); ?>
                <?php $this->endWidget(); ?>
			</td>
            <td>
                <div class="relative pull-right transaction-actions">
                    <a class="relative button download-button dropdown_button" href="#"></a>
                    <a class="button send" href="#"></a>
                    <a class="button print" href="javaScript:void(0)" onclick="js:printDiv('printTable')" ></a>
                </div>
            </td>
		</tr>
		<tr class="form-tr">
			<td colspan="2">
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
                                <div id="category-block">
                                    <div class="select-custom select-category non-edit-doc">
                                        <span class="select-custom-label">
                                            <?php if($trans->category): ?>
                                                <?= $trans->category->title ?>
                                            <?php else: ?>
                                                <?= Yii::t('Front', 'Choose'); ?>
                                            <?php endif; ?>
                                        </span>
                                        <select data-url="<?= Yii::app()->createUrl('/accounts/updatecategory', array('id' => $trans->id)) ?>" id="transaction-category-select" name="" class=" select-invisible country-select">
                                        <?php if(!$trans->category): ?>
                                            <option disabled="disabled"><?= Yii::t('Front', 'Choose'); ?></option>
                                        <?php endif; ?>
                                            <?php foreach($categories as $trCat): ?>
                                                <option value="<?= $trCat->id ?>"><?= $trCat->title ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="edit-doc input-sm">
                                        <?php echo CHtml::activeTextField(new Transactions_Categories(), 'title', array(
                                                'data-url' => $this->createUrl('/accounts/addCategory'),
                                                'id' => 'category-title'
                                            )); ?>
                                        <div class="error-message"></div>
                                    </div>
                                    <div class="transaction-buttons-cont non-edit-doc">
                                        <a href="#" class="button edit"></a>
                                    </div>
                                    <div class="transaction-buttons-cont edit-doc">
                                        <a class="button ok" href="#"></a>
                                        <a class="button cancel" href="javaScript:void(0)"></a>
                                    </div>
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

                        <div class="add-attachment-form custom borderles">
                            <div class="pull-right">
                                <input type="submit" class="add-button" value="<?= Yii::t('Front', 'Add') ?>">
                            </div>
                            <div class="attach-wrap">
                                <div class="form-cell">
                                    <div class="form-lbl">
                                        <?= Yii::t('Front', 'Note'); ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'tool tip for notes'); ?>"></span>
                                    </div>
                                    <div class="form-input">
                                        <textarea name="note-text" class="attach-textarea"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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