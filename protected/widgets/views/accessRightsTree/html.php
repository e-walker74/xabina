<div class="xabina-accordion transfer-accordion xabina-narrow-accordion" >
    <?php foreach ($rightsTree as $r):?>
        <div class="accordion-header">
            <a href="#" class="search-acc"><?php echo $r['name']; ?></a>
            <?php if(isset($r['children'])):?>
                <span class="arr"></span>
            <?php endif;?>
        </div>
    <div class="accordion-content "> 
        <?php if(isset($r['children'])):?>
            <?php $this->render('accessRightsTree/right', array('rightsTree' => $r['children']));?>
        <?php endif;?>
    </div>
    <?php endforeach;?>
    
</div>
