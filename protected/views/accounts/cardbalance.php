<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'Balance'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>
	<div class="account-selection">
		<span class="select-lbl"><?= Yii::t('Front', 'Account'); ?></span>
		<div class="select-custom account-select">
			<span class="select-custom-label">
					<?= $selectedAcc->user->fullName ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= chunk_split($selectedAcc->number, 4) ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= number_format($selectedAcc->balance, 0, "", " ") ?>
					<?= $selectedAcc->currency->title ?>
				</span>
			<select name="" class=" select-invisible">
				<?php foreach($accounts as $acc): ?>
				<option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> value="<?= $acc->number ?>">
					<?= $acc->user->fullName ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= chunk_split($acc->number, 4) ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?= number_format($acc->balance, 0, "", " ") ?>
					<?= $acc->currency->title ?>
				</option>
				<?php endforeach; ?>
			</select>

		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<div class="transfer-accordion" id="search_accordion">
		<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Advanced search'); ?> </a><span class="arr"></span></div>
		<div class="accordion-content">
			<?php $form=$this->beginWidget('CActiveForm', array(
				//'action'=>Yii::app()->createUrl(),
				'method'=>'get',
			    'id' => 'searchForm',
				'htmlOptions' => array(
                    'class' => 'advanced-search-form',
                    'data-pdf-url' => $this->createUrl('/accounts/transactionsonpdf').'/',
                    'data-doc-url' => $this->createUrl('/accounts/transactionsondoc').'/',
                    'data-csv-url' => $this->createUrl('/accounts/transactionsoncsv').'/'
                ),
			)); ?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="field-lbl"><?= $model->getAttributeLabel('keyword') ?> </div>
						<div class="field-input">
							<?= $form->textField($model, 'keyword', array('autocomplete' => 'off', 'class' => 'input-text', 'placeholder' => Yii::t('Front', 'You can filer transactions by Sender, Account number or any Keyword'))); ?>
							<?= $form->hiddenField($model, 'account_number', array('id'=>'searchForm_account_number')); ?>
                        </div>
					</div>
				</div>				
				<div class="row second-row" >
					<div class="col-nested-3">
						<div class="field-lbl"><?= Yii::t('Front', 'Date'); ?></div>
						<div class="field-input ">
							<?= $form->textField($model, 'from_date', array('autocomplete' => 'off', 'class' => 'input-text two-row-input calendar-input')); ?>
							<span class="calendar-ico"></span>
						</div>
						<div class="field-input two-line">
							<?= $form->textField($model, 'to_date', array('autocomplete' => 'off', 'class' => 'input-text two-row-input calendar-input')); ?>
							<span class="calendar-ico"></span>
						</div>
					</div>
					<div class="col-nested-3 transaction-sum">
						<div class="field-lbl "><?= Yii::t('Front', 'Sum') ?></div>
						<div class="field-input ">
							<span class="from-lbl"><?= Yii::t('Front', 'from') ?></span>
							<?= $form->textField($model, 'from_sum', array('autocomplete' => 'off', 'class' => 'input-text two-row-input')); ?>
						</div>
						<div class="field-input two-line">
							<span class="from-lbl "><?= Yii::t('Front', 'to') ?></span>
							<?= $form->textField($model, 'to_sum', array('autocomplete' => 'off', 'class' => 'input-text two-row-input')); ?>

						</div>
					</div>
					<div class="col-nested-3">
						<div class="field-lbl empty">d</div>
						<div class="field-input ">
							<div class="select-custom">
							<span class="select-custom-label"><?= Yii::t('Front', 'All transactions') ?></span>
								<?=  $form->dropDownList($model, 'type', array(
									'' => Yii::t('Front', 'All transactions'), 
									'incoming' => Yii::t('Front', 'Incoming'),
									'outgoing' => Yii::t('Front', 'Outgoing'),
								), array('class' => 'select-invisible')); ?>
							</div>
						</div>
						<div class="field-input  search-cont two-line">
							<input type="submit" class="search-button button-find" onclick="js:searchTransactions(this); return false;" value="<?= Yii::t('Front', 'Search'); ?>" />
						</div>

					</div>
				</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>

	<div class="subheader"><?= Yii::t('Front', 'Transaction'); ?>
        <div class="relative pull-right transaction-actions">
            <a class="relative button download-button dropdown_button" href="#"></a>
            <a class="button send-button" href="#"></a>
            <a class="button print-button" href="#"></a>
        </div>
	</div>
	<div class="transaction-table-header">
		<table class="transaction-header">
			<tbody><tr>
				<td width="15%"><?= Yii::t('Front', 'Date'); ?></td>
				<td width="10%"><?= Yii::t('Front', 'Type'); ?></td>
				<td width="38%"><?= Yii::t('Front', 'Description'); ?></td>
				<td width="20%"><?= Yii::t('Front', 'Value'); ?></td>
				<td width="17%"><?= Yii::t('Front', 'Balance'); ?></td>
				<td width="0%"> </td>
			</tr>
		</tbody></table>
	</div>
	<div class="transaction-table-overflow">
		<?php $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $transactions)) ?>
	</div>
	
	<?php $this->widget('AdsBlocks'); ?>
	
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/balance.js'); ?>