<?
$model->status = Users_NotificationsStatuses::STATUS_NEW;
?>
<div class="col-lg-9 col-md-9 col-sm-9">
            <div class="h1-header"><?= Yii::t('Front', 'Notifications'); ?></div>
            <div class="edit-tabs notify-tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
                <ul class="list-unstyled ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                    <li style="width: 25%" class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tab1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tab1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><div class="general">&nbsp;</div></a><?$count = $model->search()->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab2" aria-labelledby="ui-id-2" aria-selected="false"><a href="#tab2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><div class="danger">&nbsp;</div></a><?$count = $model->search(Users_Notifications::TYPE_EMERGENCY)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab3" aria-labelledby="ui-id-3" aria-selected="false"><a href="#tab3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"><div class="warning">&nbsp;</div></a><?$count = $model->search(Users_Notifications::TYPE_WARNING)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab4" aria-labelledby="ui-id-4" aria-selected="false"><a href="#tab4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"><div class="info">&nbsp;</div></a><?$count = $model->search(Users_Notifications::TYPE_INFORMATION)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                </ul>
<?
$model->status = null;
?>
                <div class="clearfix"></div>
                <div id="tab1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                    <div class="notification-table-header">
                            <table class="notification-header">
                                <tbody><tr>
                                    <td colspan="99">

                                        <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
											<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>
                                        </div>


                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
<?php $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_notif_view',
	'template'=>'{items}'
)); ?>

                    </ul>
                    </div>

                    </div>
                </div>
                <div id="tab2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="notification-table-header">
                    <table class="notification-header">
                        <tbody><tr>
                            <td colspan="99">

                                <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
                                    	<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>


                                </div>


                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">

<?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_EMERGENCY),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">'.Yii::t('Front', 'There is no notification in this section.').'</div>',
	'template'=>'{items}'
)); ?>
                        </ul>
                    </div>
                </div>
                </div>
                <div id="tab3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="notification-table-header">
                    <table class="notification-header">
                        <tbody><tr>
                            <td colspan="99">

                                <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
                                    	<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>


                                </div>


                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
                            <?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_WARNING),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">'.Yii::t('Front', 'There is no notification in this section.').'</div>',
	'template'=>'{items}'
)); ?>
                        </ul>
                    </div>
                </div>
                </div>
                <div id="tab4" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="notification-table-header">
                    <table class="notification-header">
                        <tbody><tr>
                            <td colspan="99">

                                <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
                                    	<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>


                                </div>


                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
                            <?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_INFORMATION),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">'.Yii::t('Front', 'There is no notification in this section.').'</div>',
	'template'=>'{items}'
)); ?>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        </div>