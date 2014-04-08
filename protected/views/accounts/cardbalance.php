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
		<a href="javaScript:void(0)" onclick="js:updateTransactionsTable(this);" class="refresh-button"></a>
	</div>

	<div class="balance-search">
		<div class="advanced-search">
			<a href="#" class="advanced-button"><span><?= Yii::t('Front', 'Аdvanced search'); ?></span></a>
		</div>
		<a class="outcoming trans-button" href="<?= Yii::app()->createUrl('/transfers/outgoing', array('account' => $selectedAcc->number)) ?>"><?= Yii::t('Front', 'outgoing transfer'); ?></a>
		<!--<div class="incoming trans-button"><?= Yii::t('Front', 'incoming transfer'); ?></div>-->



	</div>
	<div class="clearfix"></div>
	<div class="advanced-search-form" style="display: none">
		<?php $form=$this->beginWidget('CActiveForm', array(
			//'action'=>Yii::app()->createUrl(),
			'method'=>'get',
			'id' => 'searchForm',
			'htmlOptions' => array('data-pdf-url' => $this->createUrl('/accounts/transactionsonpdf').'/'),
		)); ?>
		<div class="row">
			<div class="col-nested-3">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('sender') ?> 
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'sender', array('autocomplete' => 'off', 'class' => 'input-text')); ?>
				</div>
			</div>
			<div class="col-nested-3">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('account_number') ?> 
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'account_number', array('autocomplete' => 'off', 'class' => 'input-text')); ?>
				</div>
			</div>
			<div class="col-nested-3">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('keyword') ?> 
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'keyword', array('autocomplete' => 'off', 'class' => 'input-text')); ?>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-nested-3">
				<div class="field-lbl"><?= Yii::t('Front', 'Date'); ?></div>
				<div class="field-input ">
					<span class="from-lbl"><?= Yii::t('Front', 'from') ?></span>
					<?= $form->textField($model, 'from_date', array('autocomplete' => 'off', 'class' => 'input-text two-row-input calendar-input')); ?>
					<span class="calendar-ico"></span>
				</div>
				<div class="field-input two-line">
					<span class="from-lbl "><?= Yii::t('Front', 'to') ?></span>
					<?= $form->textField($model, 'to_date', array('autocomplete' => 'off', 'class' => 'input-text two-row-input calendar-input')); ?>
					<span class="calendar-ico"></span>
				</div>
			</div>
			<div class="col-nested-3">
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
					<a class="search-button" href="javaScript:void(0)" onclick="js:searchTransactions(this)"><?= Yii::t('Front', 'Search'); ?></a>
				</div>

			</div>

		</div>
		<?php $this->endWidget(); ?>
	</div>


	<div class="subheader"><?= Yii::t('Front', 'Transaction'); ?>
		<div class="relative pull-right">
			<div class="trans-download dropdown_button"><a href="#"><span><?= Yii::t('Front', 'Download Statement'); ?></span></a></div>
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
		<?php $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $selectedAcc->transactions)) ?>
	</div>
	
	<?php $this->widget('AdsBlocks'); ?>
	
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/balance.js'); ?>