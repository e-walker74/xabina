<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My accounts'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'accounts-grid',
		'dataProvider'=>$accounts->search(),
		'summaryText' => '',
		'itemsCssClass' => 'table xabina-table accounts-table',
		'rowHtmlOptionsExpression' => 'array("class" => "clickable-row", "data-url" => Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)))',
		/*'htmlOptions' => array(
			'class' => 'table xabina-table',
		),*/
		//'filter'=>$accounts,
		//'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',
		//'cssFile'=>Yii::app()->getBaseUrl(true).'/css/styles-admin.css',
		'columns'=>array(
			array(
				'header' => Yii::t('Front', 'Account'),
				'value' => '"<b>".$data->user->fullName."</b><br/>".chunk_split($data->number, 4)',
				'type' => 'html',
			),
			array(
				'header' => Yii::t('Front', 'Type'),
				'value' => 'Yii::t("Front", "[".$data->type_info->title."_account_type]");',
			),
			array(
				'header' => Yii::t('Front', 'Name'),
				'value' => '"we have no names"',
			),
			array(
				'header' => Yii::t('Front', 'Balance') . ' <span class="sort_arr"></span>',
				'value' => '($data->balance >= 0) ? "<span class=\"sum-inc\">".number_format($data->balance, 2, ".", " ")."</span>" : "<span class=\"sum-dec\">".number_format($data->balance, 2, ".", " ")."</span>"',
				'htmlOptions' => array('style' => 'text-align:right;'),
				'headerHtmlOptions' => array('style' => 'text-align:right;'),
				'name' => 'balance',
				'type' => 'html',
			),
			array(
				'header' => Yii::t('Front', 'Currency'),
				'value' => '"<div class=\"relative\"><span class=\"currency_button\">".$data->currency->code."</span></div>"',
				'type' => 'html',
			),
			array(
				'header' => '',
				'value' => '"<a href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\" class=\"details-link\"></a>"',
				'htmlOptions' => array('class' => 'details-col'),
				'type' => 'html',
			),
		),
	)); ?>

	<?php $this->widget('AdsBlocks'); ?>
</div>