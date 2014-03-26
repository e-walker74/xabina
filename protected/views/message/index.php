<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'messages',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    //'action' => $this->createUrl('personal/editemails'),
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
        //'onsubmit'=>"return false;",/* Disable normal form submit */
        //'onkeypress'=>" if(event.keyCode == 13){ send(); } "
    ),
    //'focus'=>array($model,'first_name'),
    'clientOptions' => array(
        'validateOnSubmit' => false,
        'validateOnChange' => false,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid'
    ),
)); ?>
<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'All messages'); ?></div>
    <? $this->widget('MessagesMenu'); ?>
    <div class="messages-cont">
        <table class="xabina-messages-table ">
            <tbody>
            <? foreach ($messages as $k => $v): ?>
                <tr class="<?= empty($v->opened) ? 'no-read' : 'read' ?>">
                    <td width="76%">
                        <div
                            class="message-header <?= empty($v->opened) ? 'read' : 'no-read' ?>"><?= $v->to->name ?></div>
                        <div class="message-subject">
                            <?= text::limit_words($v->subject->title, 15) ?>
                        </div>
                    </td>
                    <td width="5%">
                        <a href="#" class="attachment-button"></a>
                    </td>
                    <td width="14%" class="datetime-td">
                        <?= date('d-m-Y', $v->updated_at) ?><br>
                        <?= date('H:i', $v->updated_at) ?>
                    </td>
                    <td width="5%">
                        <span class="remove-button" onclick="js:del_message('<?= $this->createUrl('message/del', array('ajax' => 'messages','del_id' => $v->id, 'do' => 2)) ?>', this)"></span>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <? $this->widget('CLinkPager', array(
            'pages' => $pages,
        ))?>
    </div>
</div>
<?php $this->endWidget(); ?>
