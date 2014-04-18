<div id="permissions">
	<div id="page-heading">
		<h1><?= Yii::t('Rights', 'Permissions') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Rights', 'Here you can view and manage the permissions assigned to each role.') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
                <!--<p><?php echo CHtml::link(Rights::t('core', 'Generate items for controller actions'), array('authItem/generate'), array(
                    'class'=>'generator-link',
                )); ?></p>-->
				<?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>'{items}',
                    'emptyText'=>Yii::t('Rights', 'No authorization items found.'),
                    'htmlOptions' => array('class' => 'grid-view permission-table'),
                    'itemsCssClass' => 'table table-striped table-bordered datatables',
                    'columns'=>$columns,
                )); ?>
			</div>
		</div>
        <script type="text/javascript">

            /**
            * Attach the tooltip to the inherited items.
            */
            jQuery('.inherited-item').rightsTooltip({
                title:'<?php echo Rights::t('core', 'Source'); ?>: '
            });

            /**
            * Hover functionality for rights' tables.
            */
            $('#rights tbody tr').hover(function() {
                $(this).addClass('hover'); // On mouse over
            }, function() {
                $(this).removeClass('hover'); // On mouse out
            });

        </script>
	</div>
</div>

