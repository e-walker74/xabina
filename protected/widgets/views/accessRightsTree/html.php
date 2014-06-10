<script>
    $(document).ready(function(){
       $('.checkbox-custom').on('click', 'label', function(e){
            if($(this).find('input').prop('checked')){
                $(this).addClass('checked');
                e.stopPropagation();
            }else{
                $(this).removeClass('checked');
                e.stopPropagation();
            }
        }); 
    });
</script>
<div class="xabina-accordion add-role-accordion xabina-narrow-accordion" >
    <?php foreach ($rightsTree as $r):?>
        <div class="accordion-header">
            <a href="#" class="search-acc"><?php echo $r['name']; ?></a>
            <span class="arr"></span>
        </div>
    <div class="accordion-content "> 
        <?php if(isset($r['children'])):?>
            <?php $this->render('accessRightsTree/right', array('rightsTree' => $r['children']));?>
        <?php endif;?>
    </div>
    <?php endforeach;?>
    
</div>
