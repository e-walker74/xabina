<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Rights', 'Rights') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Rights', 'Here you can view which permissions has been assigned to each user.') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
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
					//'pager' => 'BootstrapPager',
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
                            //'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getAssignmentNameLink()',
                        ),
                        array(
                            'name'=>'assignments',
                            'header'=>Rights::t('core', 'Roles'),
                            'type'=>'raw',
                            //'htmlOptions'=>array('class'=>'role-column'),
                            'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
                        ),
                        array(
                            'name'=>'assignments',
                            'header'=>Rights::t('core', 'Tasks'),
                            'type'=>'raw',
                            //'htmlOptions'=>array('class'=>'task-column'),
                            'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
                        ),
                        array(
                            'name'=>'assignments',
                            'header'=>Rights::t('core', 'Operations'),
                            'type'=>'raw',
                            //'htmlOptions'=>array('class'=>'operation-column'),
                            'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
                        ),
                    )
                )); ?>
			</div>
		</div>
	</div>
</div>
