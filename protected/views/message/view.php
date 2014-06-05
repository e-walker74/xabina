<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'Received messages'); ?></div>
    <?php $this->widget('MessagesMenu'); ?>
    <div class="message-container">
        <div class="message-headers">
        	<?php if($type != 'archive'):?>
            <div class="message-controls">
                <a class="button-violet" href="<?=$this->createUrl('/message/new/', array('id' => $model->id)) ?>">
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
            <?php endif;?>
            
            <table class="message-headers-table">
                <tbody><tr>
                    <td width="12%"><?= Yii::t('Front', 'From:'); ?></td>
                    <td width="88%" class="from">
                        <?php if($model->from_id == (int)Yii::app()->user->id):?>
                        	<?= Yii::t('Front', 'Me'); ?>
                        <?php else: ?> 
                        	 <?=$model->from?>  
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'Subject:'); ?></td>
                    <td><?=$model->subject ?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'Date:'); ?></td>
                    <td><?=date('d M Y H:i',$model->sent_at)?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('Front', 'To:'); ?></td>
                    <td><?=$model->to?></td>
                </tr>
                </tbody></table>
            <!--<a class="attachment-link" href="#">Annual Financial Summary 2013</a>-->
        </div>

        <div class="message-text">
            <?=$model->message?>
        </div>
    </div>
    <?php if(!empty($dialogs)):?>
        <?php $this->renderPartial('_dialogs', array('dialogs' => $dialogs)); ?>
    <?php endif;?>
</div>