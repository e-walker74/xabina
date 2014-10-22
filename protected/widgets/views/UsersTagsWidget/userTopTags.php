<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 24.09.14
 * Time: 14:30
 */
?>

<div class="new_tran_but">
    <span class="drdn-cont transaction-buttons-cont">
        <a class="button hashtag" data-toggle="dropdown"></a>
        <div id="tags-select-dropdown"
             class="dropdown-menu no-close tags-select-dropdown list-actions-dropdown list-unstyled act-list"
             role="menu">
            <div class="arr my_arr"></div>
            <div class="content-dropdown">
                <div class="drop_main_block">
                    <ul class="drop_tags_ul">
                        <?php foreach($tags as $tag): ?>
                            <li data-tag="<?= $tag->id ?>" <?php if(isset($this->_entity_tags[$tag->id])):?>style="display:none;"<?php endif; ?>><?= $tag->title ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="bot_block">
                        <span
                            onclick="$('.button.hashtag').click();$('#tags-add-dropdown').show();"
                            class="bot_other"><?= Yii::t('Front', 'Other') ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none;" id="tags-add-dropdown"
             class="dropdown-menu no-close contact-select-dropdown3 list-actions-dropdown list-unstyled act-list">
            <div class="arr my_arr"></div>
            <div class="content-dropdown">
                <div class="drop_title">
                    <?= Yii::t('Front', 'Tags') ?>
                    <a class="save-dropdown"></a>
                    <a onclick="$('#tags-add-dropdown').hide();"
                       class="close-dropdown-without-action"></a>
                </div>
                <div class="drop_bg_block">
                    <?= Yii::t('Front', 'new_tags_description_area') ?>
                </div>
                <div class="drop_main_block">
                    <textarea></textarea>
                </div>
            </div>
        </div>
    </span>
</div>

<script>
    XTags.addTags('<?= Yii::app()->createUrl('/ajax/addtag', array(
        'entity' => $this->_entity,
        'id' => $this->_entity_id
    )) ?>')
</script>