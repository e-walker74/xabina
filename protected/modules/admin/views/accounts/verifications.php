<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Accounts', 'Verifications') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Accounts', 'Information from activation form') ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$verifications->search(),
					'ajaxUpdate' => true,
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$verifications,
					'rowCssClassExpression' => '($data->status == 1) ? "to-moderator" : (($data->status == 3) ? "ok" : "")',
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
						'user.email',
						'status',
						array(
							'class'=>'CButtonColumn',
							'updateButtonUrl'=>'Yii::app()->createUrl("/admin/accounts/verificationupdate", array("id" => $data->user_id, "type" => $data->type))',
							'template' => '{update}',
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
