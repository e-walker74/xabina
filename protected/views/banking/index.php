<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My accounts'); ?></div>
	
	<?php $this->widget('XabinaAlert'); ?>

	<?php if(Yii::app()->user->status == Users::USER_EMAIL_IS_ACTIVE): ?>
		<a href="<?= Yii::app()->createUrl('/banking/accountsactivation/') ?>" class="activate-account-button"><?= Yii::t('Front', 'Activate account'); ?></a>
	<?php elseif(Yii::app()->user->status == Users::USER_IS_ACTIVATED): ?>
		<a href="<?= Yii::app()->createUrl('verification/index') ?>" class="activate-account-button"><?= Yii::t('Front', 'Verificate account'); ?></a>
	<?php endif;?>
	<div class="subheader"><?= Yii::t('Front', 'Accounts'); ?></div>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'accounts-grid',
		'dataProvider'=>$accounts->search(),
		'summaryText' => '',
		'itemsCssClass' => 'table xabina-table',
		'afterAjaxUpdate'=>'function(){$(\'.currency_dropdown\').currencyDropDown({
			currencies: {
				EUR: \'EUR\',
				USD: \'USD\',
				RUB: \'RUB\',
				CHF: \'CHF\',
				JPY: \'JPY\'
			}
		})}',
		/*'htmlOptions' => array(
			'class' => 'table xabina-table',
		),*/
		//'filter'=>$accounts,
		//'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',
		//'cssFile'=>Yii::app()->getBaseUrl(true).'/css/styles-admin.css',
		'columns'=>array(
			array(
				'header' => Yii::t('Front', 'Account number'),
				'value' => 'chunk_split($data->number, 4)',
			),
			array(
				'header' => Yii::t('Front', 'Type'),
				'value' => 'Yii::t("Front", "[".$data->type_info->title."_account_type]");',
			),
			array(
				'header' => Yii::t('Front', 'Owner'),
				'value' => '$data->user->fullName',
				'footer' => '<span>'.Yii::t('Front', 'Total:').'</span>',
				'footerHtmlOptions'=>array('class' => 'totals-lbl'),
			),
			array(
				'header' => Yii::t('Front', 'Balance') . ' <span class="sort_arr"></span>',
				'value' => 'number_format($data->balance, 0, "", " ");',
				'name' => 'balance',
				'footer' => $accounts->getUserBalanceInEUR(),
			),
			array(
				'header' => Yii::t('Front', 'Currency'),
				'value' => '"<div class=\"relative\"><span class=\"currency_button\">".$data->currency->code."</span></div>"',
				'footer' => '<div class="relative"><span class="dropdown_button  currency_dropdown">EUR </span><span class="currency_drdn_arr"></span></div>',
				'type' => 'html',
			),
		),
	)); ?>
	
	<div class="subheader"><?= Yii::t('Front', 'Transactions'); ?></div>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'transactions-grid',
		'dataProvider'=>$transactions->search(),
		'summaryText' => '',
		'itemsCssClass' => 'table xabina-table',
		'emptyText' => Yii::t('Front', 'Transactions not found'),
		'columns'=>array(
			array(
				'header' => Yii::t('Front', 'Time'),
				'value' => 'date("d.m.Y", $data->created_at) . "<br/>" . date("G:i", $data->created_at)',
				'type' => 'html',
			),
			array(
				'header' => Yii::t('Front', 'Operation'),
				'value' => '$data->operation',
			),
			array(
				'header' => Yii::t('Front', 'Account number'),
				'value' => 'chunk_split($data->account->number, 4)',
			),
			array(
				'header' => Yii::t('Front', 'Balance'),
				'value' => '($data->type = "positive") ? "<span class=\"sum-inc\">+".number_format($data->sum, 0, "", " ")."</span>" : "<span class=\"sum-dec\">-".number_format($data->sum, 0, "", " ")."</span>"',
				'type' => 'html',
			),
			array(
				'header' => Yii::t('Front', 'Currency'),
				'value' => '$data->account->currency->code',
			),
		),
	)); ?>

	<?php $this->widget('AdsBlocks'); ?>
</div>