<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Accounts', 'Activations') ?></h1>
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
					'dataProvider'=>$activations->search(),
					'ajaxUpdate' => true,
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$activations,
					'rowCssClassExpression' => '($data->step == 4) ? "to-moderator" : (($data->step == 7) ? "ok" : "")',
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
							'header' => Yii::t('Front', 'User Email'),
							'name' => 'email',
						),
						'phone',
						'first_name',
						'last_name',
						'step',
						array(
							'class'=>'CButtonColumn',
							'updateButtonUrl'=>'Yii::app()->createUrl("/admin/accounts/activationupdate", array("id" => $data->user_id))',
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
