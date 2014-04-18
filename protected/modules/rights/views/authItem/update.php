<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Rights', 'Rights') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Rights', 'Update :name', array(
                    ':name'=>$model->name,
                    ':type'=>Rights::getAuthItemTypeName($model->type),
                )) ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
			</div>
		</div>

        <div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Rights', 'Relations') ?></h4>
				<div class="options">
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in relations">

                <?php if( $model->name!==Rights::module()->superuserName ): ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'dataProvider'=>$childDataProvider,
                            'template'=>'{items}',
                            'hideHeader'=>true,
                            'emptyText'=>Rights::t('core', 'This item has no children.'),
                            'itemsCssClass' => 'table table-striped table-bordered datatables',
                            'columns'=>array(
                                array(
                                    'name'=>'name',
                                    'header'=>Rights::t('core', 'Name'),
                                    'type'=>'raw',
                                    'htmlOptions'=>array('class'=>'name-column'),
                                    'value'=>'$data->getNameLink()',
                                ),
                                array(
                                    'name'=>'type',
                                    'header'=>Rights::t('core', 'Type'),
                                    'type'=>'raw',
                                    'htmlOptions'=>array('class'=>'type-column'),
                                    'value'=>'$data->getTypeText()',
                                ),
                                array(
                                    'header'=>'&nbsp;',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('class'=>'actions-column'),
                                    'value'=>'$data->getRemoveChildLink()',
                                ),
                            )
                        )); ?>

                        <?php if( $childFormModel!==null ): ?>

                            <?php $this->renderPartial('_childForm', array(
                                'model'=>$childFormModel,
                                'itemnameSelectOptions'=>$childSelectOptions,
                            )); ?>

                        <?php else: ?>

                            <p class="info"><?php echo Rights::t('core', 'No children available to be added to this item.'); ?>

                        <?php endif; ?>


                <?php else: ?>

                    <p class="info">
                        <?php echo Rights::t('core', 'No relations need to be set for the superuser role.'); ?><br />
                        <?php echo Rights::t('core', 'Super users are always granted access implicitly.'); ?>
                    </p>

                <?php endif; ?>
			</div>
		</div>
	</div>
</div>
