
<h1><?= Yii::t('Transfers', 'Outgoing') ?></h1>

<div class="col-md-12">
	<div class="tab-content">
		<div class="panel panel-midnightblue">
			<div class="panel-body"><?= Yii::t('Transfers', '<p>Use on search (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) before value.</p>') ?>
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
								'user.email',
								'account.number',
								'amount',
								'currency.code',
								array(
									'header' => 'type',
									'value' => '$data->form_type',
								),
								//'urgent',
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