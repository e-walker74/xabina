<?php foreach ($rightsTree as $r):?>
    <div class="xabina-accordion accordion-inner head-of-param" >
        <div class="accordion-header">
            <div class="checkbox-custom narrow">
                <label class="">
                    <input type="checkbox" name="RbacRoles[rights][<?php echo $r['id']; ?>]">
                </label>
            </div>
            <a href="#" class="search-acc <?php if(isset($r['children'])):?>arr<?php endif;?>"><?php echo $r['name']; ?></a>
            <?php if(isset($r['children'])):?>
                <span class="arr"></span>
            <?php endif;?>
        </div>
        <?php if(isset($r['children'])):?>
        <div class="accordion-content "> 
            <?php $this->render('accessRightsTree/right', array('rightsTree' => $r['children']));?>
        </div>
        <?php endif;?>
    </div>
<?php endforeach;?>