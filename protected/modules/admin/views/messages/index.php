<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Messages', 'Messages') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Messages', 'Messages List') ?></h4>
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
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$model,
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
							'header' => Yii::t('Front', 'Dialog'),
							'value' => '"<b>".$data->user->email . "</b> Subject: " . $data->subject->title',
							'type' => 'html',
						),
						array(
							'class'=>'CButtonColumn',
							'viewButtonUrl'=>'Yii::app()->createUrl("/admin/messages/view", array("id" => $data->dialog_id))',
							'template' => '{view}',
							'buttons' => array(
								'update' => array(
									//'label' => '',
									//'imageUrl'=>false,  // make sure you have an image
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
