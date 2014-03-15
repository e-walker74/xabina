<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Users', 'Update User: <b>' . $model->login . '</b>') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Users', 'Basic information') ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Users', 'Accounts') ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-up"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in" style="display:none">
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
							'value' => '$data->user->fullName',
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
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Users', 'Logs') ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-up"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in" style="display:none">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$logs->search(),
					'ajaxUpdate' => true,
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$logs,
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
							'header' => Yii::t('Logs', 'Time'),
							'value' => 'date("d-M-Y H:i", $data->created_at)',
							'name' => 'created_at',
						),
						array(
							'header' => Yii::t('Logs', 'Action Type'),
							'value' => '$data->type',
							'name' => 'type',
						),
						array(
							'header' => Yii::t('Logs', 'IP'),
							'value' => '$data->ip_address',
							'name' => 'ip_address',
						),
						array(
							'header' => Yii::t('Logs', 'Browser'),
							'value' => '$data->browser',
							'name' => 'browser',
						),
						array(
							'header' => Yii::t('Logs', 'Browser Version'),
							'value' => '$data->browser_version',
							'name' => 'browser_version',
						),
						array(
							'header' => Yii::t('Logs', 'Operation System'),
							'value' => '$data->os',
							'name' => 'os',
						),
						array(
							'header' => Yii::t('Logs', 'Country'),
							'value' => '$data->region',
							'name' => 'region',
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
