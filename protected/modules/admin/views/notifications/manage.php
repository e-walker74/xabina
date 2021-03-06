<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Notifications', 'Notifications') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Notifications', 'Notifications list') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$model->search(),
					'ajaxUpdate' => true,
                    'filter'=>$model,
					'enableHistory'=>true,
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

                        'type',
                        'code',
						'announce',
                        array(

							'buttons'=>array(
								'view' => array(
									'label'=>'View', // text label of the button
									'url'=>"CHtml::normalizeUrl(array('view', 'notification_id'=>\$data->id))",
								),
								'users' => array(
									'label'=>'Users', // text label of the button
									'url'=>"CHtml::normalizeUrl(array('users', 'notification_id'=>\$data->id))",
								),
								'copy' => array(
									'label'=>'Copy', // text label of the button
									'url'=>"CHtml::normalizeUrl(array('create', 'notification_id'=>\$data->id))",
								),
								'delete' => array(
									'label'=>'Delete', // text label of the button
									'url'=>"CHtml::normalizeUrl(array('delete', 'notification_id'=>\$data->id))",
								),
							),
							'class'=>'CButtonColumn',
							'template' => '{view} {users} {copy} {delete}',
						)
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
