<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 31.07.14
 * Time: 13:43
 * @param Users_Newsletter $model
 */
?>

<div class=" xabina-form-normal">
    <table id="newsletter-form" class="table xabina-table-contacts vertical-top">
        <tr class="table-header">
            <th style="width: 40%"><?= Yii::t('Personal', 'Options'); ?></th>
            <th style="width: 60%"><?= Yii::t('Personal', 'Status'); ?></th>
        </tr>
        <?php foreach(Users_Newsletter::$types as $type): ?>
            <tr>
                <td>
                    <?php
                    $checked = false;
                    foreach($model as $m):
                        if($m->letter_type == $type){
                            $checked = true;
                        }
                    endforeach;
                    ?>
                    <div class="checkbox-custom mini">
                        <label <?= ($checked) ? "class='checked'" : "" ?>>
                            <input type="checkbox" <?= ($checked) ? "checked='checked'" : "" ?> name="<?= $type ?>" data-url="<?= Yii::app()->createUrl('/personal/newsletter') ?>"/>
                        </label>
                    </div>
                    <?= Yii::t('Front', $type) ?>
                </td>
                <td>
                <span class="desc development truncate-text">
                    <?= SiteService::subStrEx(Yii::t('Personal', 'Newsletter_'.$type.'_description'), 500) ?>
                </span>
                <span class="desc development truncate-text" style="display: none;">
                    <?= Yii::t('Personal', 'Newsletter_'.$type.'_description') ?>
                </span>
                    <?php if(mb_strlen(Yii::t('Personal', 'Newsletter_'.$type.'_description'), 'utf8') >= 500): ?>
                        <a href="javaScript:void(0)" onclick="$('.development.truncate-text').toggle('slow')" class="truncation-toggle closed"><span><?= Yii::t('Personal', 'Show more') ?></span></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<script>
    Personal.bindNewsletterForm()
</script>