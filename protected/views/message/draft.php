<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'Drafts'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>
    <? $this->widget('MessagesMenu'); ?>
    <div class="messages-cont">
        <table class="xabina-messages-table ">
            <tbody>
            <? foreach ($messages as $k => $v): ?>
                <tr class="<?=empty($v->opened) ? 'no-read' : 'read'?>">
                    <td width="76%">
                        <div class="message-header <?=empty($v->opened) ? 'read' : 'no-read'?>">
							<a href="<?= $this->createUrl('message/save', array('type' => 'edit' , 'id' => $v->id))?>"><?=$v->to->name?></a>
                        </div>
                        <div class="message-subject"> <?= text::limit_words($v->message, 15) ?></div>
                    </td>
                    <td width="5%">
                        <!--<a href="#" class="attachment-button"></a>-->
                    </td>
                    <td width="14%" class="datetime-td">
                        <?=date('d-m-Y',$v->updated_at)?><br>
                        <?=date('H:i',$v->updated_at)?>
                    </td>
                    <td width="5%">
                        <a href="#" class="remove-button" onclick="js:del_message('<?= $this->createUrl('message/del', array(
						'ajax' => 'messages',
						'del_id' => $v->id, 
						'do' => 1
						)) ?>', this, '<?=Yii::t('Front', 'Are You sure You want to delete this message? It will not be moved to Archive folder.')?>'); return false;"></a>
                    </td>
                </tr>
            <? endforeach;?>
            </tbody>
        </table>
        <? $this->widget('CLinkPager', array(
            'pages' => $pages,
        ))?>
    </div>
</div>

