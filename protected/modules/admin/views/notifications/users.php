<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Notifications', 'Notifications') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Notifications', 'Notifications user list') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$model->admin(),
					'ajaxUpdate' => true,
                    'filter'=>$model,
                    //'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
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
						'user_id',
                        'status',
                        array(

							'buttons'=>array(
								'status' => array(
									'label'=>'Update Status', // text label of the button
									'url'=>"CHtml::normalizeUrl(array('updateStatus', 'status_id'=>\$data->id))",
								),
							),
							'class'=>'CButtonColumn',
							'template' => '{status}',
						)
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
