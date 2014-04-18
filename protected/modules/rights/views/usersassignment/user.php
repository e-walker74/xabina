<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Rights', 'Assignments for ":username"', array(
            ':username'=>$model->getName()
        )) ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Admins', 'Update') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
            <div class="panel-body collapse in">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>'{items}',
                    'itemsCssClass' => 'table table-striped table-bordered datatables',
					'summaryCssClass' => 'dataTables_info',
					'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
//                            'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getNameText()',
                        ),
                        array(
                            'name'=>'type',
                            'header'=>Rights::t('core', 'Type'),
                            'type'=>'raw',
//                            'htmlOptions'=>array('class'=>'type-column'),
                            'value'=>'$data->getTypeText()',
                        ),
                        array(
                            'header'=>'&nbsp;',
                            'type'=>'raw',
//                            'htmlOptions'=>array('class'=>'actions-column'),
                            'value'=>'$data->getRevokeAssignmentLink()',
                        ),
                    )
                )); ?>
            </div>
        </div>
        <div class="panel panel-midnightblue">
            <div class="panel-heading ">
				<h4><?= Yii::t('Admins', 'Assign item') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php if( $formModel!==null ): ?>

                        <?php $this->renderPartial('_form', array(
                            'model'=>$formModel,
                            'itemnameSelectOptions'=>$assignSelectOptions,
                        )); ?>

                <?php else: ?>

                    <p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>

                <?php endif; ?>
			</div>
		</div>
	</div>
</div>

