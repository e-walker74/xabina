<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 24.09.14
 * Time: 13:53
 * @var Users_Tags $tags
 */
?>

<ul class="tags_ul" id="<?php $this->id . '-' . $transaction_id ?>">
    <?php if($tags): ?>
        <?php foreach($tags as $tag): ?>
            <li>
                <span><?= $tag->title ?></span>
                <a data-tag="<?= $tag->id ?>" data-url="<?= Yii::app()->createUrl('/ajax/removeTag', array(
                    'entity' => $this->_entity,
                    'entity_id' => $this->_entity_id,
                    'id' => $tag->id,
                    'cross_type' => $tag->tableName(),
                )) ?>" class="close-tags"></a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<script>
    XTags.deleteButtons()
</script>