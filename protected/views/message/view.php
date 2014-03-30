<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'Received messages'); ?></div>
    <? $this->widget('MessagesMenu'); ?>
    <div class="message-container">
        <div class="message-headers">
        	<? if($type != 'archive'):?>
            <div class="message-controls">
                <a class="button-violet" href="<?=$this->createUrl('message/new/'.$model->dialog_id) ?>">
					<?= Yii::t('Front', 'Reply'); ?>
                </a>
                <?=CHtml::link(Yii::t('Front', 'Delete'), Yii::app()->createUrl('/message/del/', array(
				'del_id' => $model->id, 
				'do' => $type == 'inbox' ? 3 : 2,
				//'dialog_id' => $model->dialog_id,
				)), array(
                        'class' => 'button-violet',
						'confirm' => Yii::t('Front', 'Are you sure?'),
                    )
                ); 
              ?>
                
            </div>
            <? endif;?>
            
            <table class="message-headers-table">
                <tbody><tr>
                    <td width="12%"><?= Yii::t('Front', 'From:'); ?></td>
                    <td width="88%" class="from">
                        <? if($model->from_id == (int)Yii::app()->user->id):?>
                        	<?= Yii::t('Front', 'Me'); ?>
                        <? else: ?> 
                        	 <?=$model->to->name?>  
                        <? endif;?>
                    </td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'Subject:'); ?></td>
                    <td><?=$model->subject->title?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'Date:'); ?></td>
                    <td><?=date('d M Y H:i',$model->updated_at)?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'To:'); ?></td>
                    <td><?=$model->to->name?></td>
                </tr>
                </tbody></table>
            <!--<a class="attachment-link" href="#">Annual Financial Summary 2013</a>-->
        </div>

        <div class="message-text">
            <?=$model->message?>
        </div>
    </div>
    <? if(!empty($dialogs)):?>
        <?php $this->renderPartial('_dialogs', array('dialogs' => $dialogs)); ?>
    <? endif;?>
</div>