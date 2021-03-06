
<h1><?= Yii::t('Users', 'Last Personal uploaded files') ?></h1>

<div class="col-md-12">
	<div class="tab-content">
		<div class="panel panel-midnightblue">
			<div class="panel-body"><?= Yii::t('Users', '<p>Use on search (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) before value.</p>') ?>
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
					'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
					'pager' => 'BootstrapPager',
					'columns'=>array(
								array(
									'header' => Yii::t('Front', 'Date'),
									'value' => 'date("Y-m-d h:m", $data->created_at)',
								),
								'user.email',
								array(
									'class'=>'CButtonColumn',
									//'viewButtonUrl'=>'Yii::app()->createUrl("user/index", array("id" => $data->id))',
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