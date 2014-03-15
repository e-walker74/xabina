<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Accounts', 'Accounts') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Accounts', 'Accounts List') ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$accounts->search(),
					'ajaxUpdate' => true,
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$accounts,
					'summaryCssClass' => 'dataTables_info',
					'template' => '{items}
									<div class="row">
										<div class="col-xs-6">
											{summary}
										</div>
										<div class="col-xs-6">
											{pager}
										</div>
									</div>',
					'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
					//'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
					'pager' => 'BootstrapPager',
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
							'value' => '$data->user->email',
							'name' => 'holderEmail',
							'footer' => '<span>'.Yii::t('Front', 'Total:').'</span>',
							'footerHtmlOptions'=>array('class' => 'totals-lbl'),
						),
						array(
							'header' => Yii::t('Front', 'Balance') . ' <span class="sort_arr"></span>',
							'value' => 'number_format($data->balance, 0, "", " ");',
							'name' => 'balance',
							'footer' => $accounts->getUserBalanceInEUR(true),
						),
						array(
							'header' => Yii::t('Front', 'Currency'),
							'value' => '$data->currency->code',
							'footer' => 'EUR',
							'type' => 'html',
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
