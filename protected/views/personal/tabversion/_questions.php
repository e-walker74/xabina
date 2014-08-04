<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.07.14
 * Time: 13:42
 */ ?>

<?php if(count($user->questions) < 2):?>
    <?php $this->renderPartial('tabversion/questions/_first_questions', array('question' => $question,'user' => $user, 'model' => $model)) ?>
<?php else: ?>
    <?php $this->renderPartial('tabversion/questions/_questions', array('question' => $question,'user' => $user, 'model' => $model)) ?>
<?php endif; ?>

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