<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Rights', 'Rights') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Rights', 'Roles') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
            <p><?php echo CHtml::link(Rights::t('core', 'Create a new role'), array('authItem/create', 'type'=>CAuthItem::TYPE_ROLE), array(
                'class'=>'add-role-link',
            )); ?></p>
				<?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>'{items}',
                    'emptyText'=>Rights::t('core', 'No roles found.'),
                    'itemsCssClass' => 'table table-striped table-bordered datatables',
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getGridNameLink()',
                        ),
                        array(
                            'name'=>'description',
                            'header'=>Rights::t('core', 'Description'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'description-column'),
                        ),
                        array(
                            'name'=>'bizRule',
                            'header'=>Rights::t('core', 'Business rule'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'bizrule-column'),
                            'visible'=>Rights::module()->enableBizRule===true,
                        ),
                        array(
                            'name'=>'data',
                            'header'=>Rights::t('core', 'Data'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'data-column'),
                            'visible'=>Rights::module()->enableBizRuleData===true,
                        ),
                        array(
                            'header'=>'&nbsp;',
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'actions-column'),
                            'value'=>'$data->getDeleteRoleLink()',
                        ),
                    )
                )); ?>
			</div>
            <p class="info"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></p>
		</div>
	</div>
</div>