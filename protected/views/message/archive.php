<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'Archive'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>
    <? $this->widget('MessagesMenu'); ?>
    <div class="messages-cont">
        <table class="xabina-messages-table ">
            <tbody>
            <? foreach ($messages as $k => $v): ?>
                <tr class="<?=empty($v->opened) ? 'no-read' : 'read'?>">
                    <td width="76%">
                        <div class="message-header <?=empty($v->opened) ? 'read' : 'no-read'?>">
                        	<a href="<?= $this->createUrl('message/view/id/'.$v->id .'/type/archive')?>"><?=$v->to->name?></a>
                        </div>
                        <div class="message-subject"><?= text::limit_words($v->message, 15) ?></div>
                    </td>
                    <td width="5%">
                        <!--<a href="#" class="attachment-button"></a>-->
                    </td>
                    <td width="14%" class="datetime-td">
                        <?=date('d-m-Y',$v->updated_at)?><br>
                        <?=date('H:i',$v->updated_at)?>
                    </td>
                    <td width="5%">
                      
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

