
<h1><?= Yii::t('Users', 'System emails') ?></h1>

<div class="col-md-12">
	<div class="tab-content">
		<div class="panel panel-midnightblue">
			<div class="panel-body"><?= Yii::t('Users', '<p>Use on search (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) before value.</p>') ?>
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$mails->search(),
					'ajaxUpdate' => true,
					'filter'=>$mails,
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
					'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
					'columns'=>array(
						'code',
						'sender',
						'subject',
						'fromName',
						'template',
						'params',
                        array(
                            'header' => Yii::t('Mails', 'Send test'),
                            'value' => 'CHtml::link("Send test email", "javascript:;", array("class" => "btn btn-default btn-block bootbox-test-mail", "data-template" => $data->code))',
                            'type' => 'raw',
                        ),
						array(
							'class'=>'CButtonColumn',
							//'viewButtonUrl'=>'Yii::app()->createUrl("user/index", array("id" => $data->id))',
							'template' => '{update}',
							'buttons' => array(
								'update' => array(
									'label' => '',
									'imageUrl'=>false,  // make sure you have an image
                                    'htmlOptions' => array('data-toggle' => 'modal')
								),
							),
						)
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
