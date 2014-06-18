<?php foreach ($types as $type): ?>
    <ul class="type-tbl-col type-block type-color-<?=$type['color']?>">
        <li class="type-head"><?=$type['title']?></li>
        <li class="type-per"><?=$type['bet']?>%</li>
        <li><?=$type['payments']?></li>
        <li><?=$type['term']?></li>
        <li><?=$type['currency']['title']?></li>
        <li class="type-order"><div class="type-circle-left"></div><div class="type-circle-right"></div><input type="submit" value="<?= Yii::t('Front', 'Order') ?>" class="type-order-btn" data-type_id="<?=$type['id']?>"></li>
    </ul>
<?php endforeach ?>
<div class="clear"></div>