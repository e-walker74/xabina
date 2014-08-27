<?
$model->status = Users_NotificationsStatuses::STATUS_NEW;
?>

<a href="#" data-toggle="dropdown" role="button"><?$count = $model->search()->getTotalItemCount();if($count){?><span><?= $count ?></span><?}?></a>
<div class="dropdown-menu notification-popup" role="menu">
                <div class="arrow_gray"></div>
                <div class="popup-tabs popup-notify-tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
                <ul class="list-unstyled ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                    <li style="width: 25%" class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tab1-p" aria-labelledby="ui-id-5" aria-selected="true"><a href="#tab1-p" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5"><div class="general">&nbsp;</div><?$count = $model->search()->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></a></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab2-p" aria-labelledby="ui-id-6" aria-selected="false"><a href="#tab2-p" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-6"><div class="danger">&nbsp;</div><?$count = $model->search(Users_Notifications::TYPE_EMERGENCY)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></a></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab3-p" aria-labelledby="ui-id-7" aria-selected="false"><a href="#tab3-p" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-7"><div class="warning">&nbsp;</div><?$count = $model->search(Users_Notifications::TYPE_WARNING)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></a></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab4-p" aria-labelledby="ui-id-8" aria-selected="false"><a href="#tab4-p" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-8"><div class="info">&nbsp;</div><?$count = $model->search(Users_Notifications::TYPE_INFORMATION)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></a></li>
                </ul>
                <div class="clearfix"></div>
                <div id="tab1-p" aria-labelledby="ui-id-5" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                <div class="dialogues-content">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
<?
$model->status = null;
?>
<?php $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'/notifications/_notif_view',
	'template'=>'{items}'
)); ?>
					 </ul>
                    </div>

                </div>
                </div>
                <div id="tab2-p" aria-labelledby="ui-id-6" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
<div class="dialogues-content">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
					<?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_EMERGENCY),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">
                        There is no new notification in this section.
                    </div>',
	'template'=>'{items}'
)); ?> </ul></div>

                </div>

                </div>
                <div id="tab3-p" aria-labelledby="ui-id-7" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="dialogues-content">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
                        <?php

$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_WARNING),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">
                        There is no new notification in this section.
                    </div>',
	'template'=>'{items}'
)); ?>
                    </ul>
                    </div>

                </div>
                </div>
                <div id="tab4-p" aria-labelledby="ui-id-8" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="dialogues-content">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">    <?php

$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_INFORMATION),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">
                        There is no new notification in this section.
                    </div>',
	'template'=>'{items}'
)); ?></ul>
                    </div>

                </div>
                </div>
                </div>

                <a href="<?= Yii::app()->createUrl('/banking/notifications') ?>" class="notification-all">See all notification</a>
            </div>