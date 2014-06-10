<?php foreach ($rightsTree as $r):?>
           
    <div class="xabina-accordion accordion-inner" >        
        <div class="accordion-header">
            <div class="checkbox-custom narrow">
                <label class="">
                    <input type="checkbox" name="RbacRoles[rights][<?php echo $r['id']; ?>]">
                </label>
            </div>
            <a href="#" class="search-acc"><?php echo $r['name']; ?></a><span class="arr"></span>
        </div>
        <?php if(isset($r['children'])):?>
        <div class="accordion-content "> 
            <?php $this->render('accessRightsTree/right', array('rightsTree' => $r['children']));?>
        </div>
        <?php endif;?>

    </div>
<?php endforeach;?>