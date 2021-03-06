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
					'dataProvider'=>$mail->search(),
					'ajaxUpdate' => true,
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$mail,
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
							'header' => Yii::t('Front', 'User Login'),
							'name' => 'login',
							'value' => '($data->user) ? $data->user->login : ""',
						),
						array(
							'header' => Yii::t('Front', 'Template'),
							'name' => 'template',
							'value' => '$data->template',
						),
						array(
							'header' => Yii::t('Front', 'Email'),
							'name' => 'email',
							'value' => '$data->email',
						),
						array(
							'header' => Yii::t('Front', 'Is Print'),
							'name' => 'is_print',
							'value' => '$data->is_print',
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
