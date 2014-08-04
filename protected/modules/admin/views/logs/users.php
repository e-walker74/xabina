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
							'header' => Yii::t('Logs', 'User Login'),
							'value' => '$data->user->login',
							'name' => 'login',
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
