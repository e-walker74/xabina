<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 01.10.14
 * Time: 17:58
 * @var WCrossLink $this
 */
?>
<div class="comment-block" data-url="<?= Yii::app()->createUrl('/ajax/crosscomment', array('cross_id' => $cross_id)) ?>">

        <span class="comment drdn-cont">
            <a href="#" class="transaction_comment <?php if($comment): ?>active<?php endif; ?>" data-toggle="dropdown"></a>
            <div class="dropdown-menu no-close contact-select-dropdown2 list-actions-dropdown list-unstyled act-list" role="menu">
                <div class="arr my_arr"></div>
                <div class="content-dropdown with-info" <?php if(!$comment): ?>style="display: none"<?php endif; ?>>
                    <div class="drop_title">
                        <?= Yii::t('Cross', 'Comment') ?>
                        <a class="edit-dropdown" onclick="return CrossLinks.editComment(this)"></a>
                        <a class="close-dropdown"></a>
                    </div>
                    <div class="casual_text">
                        <?= $comment ?>
                    </div>
                </div>
                <div class="content-dropdown without-info" <?php if($comment): ?>style="display: none"<?php endif; ?>>
                    <div class="drop_title">
                        <?= Yii::t('Cross', 'Comment') ?>
                        <a class="save-dropdown" onclick="return CrossLinks.changeComment(this)"></a>
                        <a class="close-dropdown"></a>
                    </div>
                    <div class="drop_bg_block">
                        <?= Yii::t('Cross', 'You may add comment here') ?>
                    </div>
                    <div class="drop_main_block">
                        <textarea><?= $comment ?></textarea>
                    </div>
                </div>
            </div>
        </span>
</div>