<table class="table xabina-table-personal">
    <tbody>
    <tr class="table-header">
        <th style="width: 53%"><?= Yii::t('Front', 'Security Questions'); ?></th>
        <th style="width: 40%"><?= Yii::t('Front', 'Answers'); ?></th>
        <th style="width: 7%"></th>
    </tr>
<?php if(count($user->questions) < 2):?>
    <?php $this->renderPartial('_first_questions', array('user' => $user, 'model' => $model)) ?>
<?php else: ?>
    <?php $this->renderPartial('_questions', array('user' => $user, 'model' => $model)) ?>
<?php endif; ?>
    </tbody>
</table>
<script>
    chechSequrityValuesData()
    $('.mask-toggle').on('mouseenter', function (e) {
        var $maskedEl = $(this).parents('td').find('.masked-value');
        var $originalEl = $(this).parents('td').find('.original-value');
        $maskedEl.html($originalEl.val()).addClass('normal-font');
    })
    $('.mask-toggle').on('mouseleave', function (e) {
        var $maskedEl = $(this).parents('td').find('.masked-value');
        var $originalEl = $(this).parents('td').find('.original-value');
        $maskedEl.html('**********').removeClass('normal-font');
    })
</script>