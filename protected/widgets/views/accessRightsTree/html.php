<div class="xabina-accordion transfer-accordion xabina-narrow-accordion" >
    <?php foreach ($rightsTree as $r):?>
        <div class="accordion-header head-accordion-param">
            <a href="#" class="search-acc"><?php echo $r['name']; ?></a>
            <?php if (isset($r['children'])): ?>
                <span class="arr"></span>
            <?php endif; ?>
            <input type="hidden" name="RbacRoles[rights][<?php echo $r['id']; ?>]">
        </div>
        <div class="accordion-content top-right head-of-param">
            <?php if (isset($r['children'])): ?>
                <?php $this->render('accessRightsTree/right', array('rightsTree' => $r['children'])); ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
