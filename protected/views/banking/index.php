<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My accounts'); ?></div>
	
	<?php $this->widget('XabinaAlert'); ?>
	
	<div class="subheader"><?= Yii::t('Front', 'Accounts'); ?></div>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'accounts-grid',
		'dataProvider'=>$accounts->search(),
		'summaryText' => '',
		'rowHtmlOptionsExpression' => 'array("class" => "clickable-row", "data-url" => Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)))',
		'itemsCssClass' => 'table xabina-table',
		'afterAjaxUpdate'=>'function(){$(\'.currency_dropdown\').tempDropDown({
			list: {
				EUR: \'EUR\',
				USD: \'USD\',
				RUB: \'RUB\',
				CHF: \'CHF\',
				JPY: \'JPY\'
			},
	         listClass: "currencies_dropdown"
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
			/*array(
				'header' => Yii::t('Front', 'Type'),
				'value' => 'Yii::t("Front", "[".$data->type_info->title."_account_type]");',
			),*/
			array(
				'header' => Yii::t('Front', 'Owner'),
				'value' => '$data->user->fullName',
				'footer' => '<span>'.Yii::t('Front', 'Total:').'</span>',
				'footerHtmlOptions'=>array('class' => 'totals-lbl'),
			),
			array(
				'htmlOptions' => array('style' => 'text-align:right;'),
				'header' => Yii::t('Front', 'Balance') . ' <span class="sort_arr"></span>',
				'value' => '($data->balance >= 0) ? "<span class=\"sum-inc\">".number_format($data->balance, 2, ".", " ")."</span>" : "<span class=\"sum-dec\">".number_format($data->balance, 2, ".", " ")."</span>"',
				'name' => 'balance',
				'type' => 'html',
				'footer' => $accounts->getUserBalanceInEUR(),
			),
			array(
				'header' => Yii::t('Front', 'Currency'),
				'value' => '"<div class=\"relative\"><span class=\"dropdown_button\">".$data->currency->code."</span></div>"',
				'footer' => '<div class="relative"><span class="dropdown_button  currency_dropdown">EUR<span class="currency_drdn_arr"></span></span></div>',
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
		'rowHtmlOptionsExpression' => 'array("class" => "clickable-row", "data-url" => Yii::app()->createUrl("/accounts/transaction", array("id" => $data->url)))',
		'emptyText' => Yii::t('Front', 'Transactions not found'),
		'columns'=>array(
			array(
				'header' => Yii::t('Front', 'Date'),
				'value' => 'date("d.m.Y", $data->created_at)',
				'type' => 'html',
			),
			/*array(
				'header' => Yii::t('Front', 'Description'),
				'value' => '"<b>" . $data->info->sender . "</b>" . "<br/>" . $data->operation',
				'type' => 'html',
			),*/
			array(
				'header' => Yii::t('Front', 'Account number'),
				'value' => 'chunk_split($data->account->number, 4)',
			),
			array(
				'header' => Yii::t('Front', 'Balance'),
				'htmlOptions' => array('style' => 'text-align:right;'),
				'value' => '($data->type == "positive") ? "<span class=\"sum-inc\">+".number_format($data->sum, 2, ".", " ")."</span>" : "<span class=\"sum-dec\">-".number_format($data->sum, 2, ".", " ")."</span>"',
				'type' => 'html',
			),
			array(
				'header' => Yii::t('Front', 'Currency'),
				'value' => '$data->account->currency->code',
			),
		),
	)); ?>
    <?php if(Yii::app()->user->checkRbacAccess('show_ads_block_widget')): ?>
	    <?php $this->widget('AdsBlocks'); ?>
    <?php endif; ?>
</div>