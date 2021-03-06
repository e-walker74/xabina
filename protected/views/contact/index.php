<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My contact') ?></div>
	<div class="contact-search-cont">
		<span class="clear-input-cont index-table">
			<input class="contact-input" style="width: 100%" placeholder="<?= Yii::t('Front', 'Search...') ?>" type="text" id="linkName" />
			<span class="clear-input-but"></span>
		</span>
        <div class="select-custom select-narrow category-select">
            <span class="select-custom-label"></span>
            <?= CHtml::dropDownList(
                'category_id_list',
                '',
                CHtml::listData($contact_categories, 'id', 'section'),
                array(
                    'class' => 'select-invisible country-select',
                    'empty' => Yii::t('Front', 'Select'),
                )
            ); ?>
        </div>
        <div class="select-custom select-narrow category-select">
            <span class="select-custom-label"></span>
            <?= CHtml::dropDownList(
                'types_list',
                '',
                array(
                    'personal' => Yii::t('Front', 'Personal'),
                    'company' => Yii::t('Front', 'Company'),
                ),
                array(
                    'class' => 'select-invisible country-select',
                    'empty' => Yii::t('Front', 'All types'),
                )
            ); ?>
        </div>
		<a class="contact-search-but" href="#" style="display:none;"></a>
		<a class="add-contact-but rounded-buttons" href="<?= Yii::app()->createUrl('/contact/create') ?>"><?= Yii::t('Front', 'Add Contact') ?></a>
	</div>
	<div class="scroll-cont">
		<?php Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'contactList'))->html() ?>
	</div>
	<script>
		$(document).ready(function(){
			$('.contact-search-but').searchContactButtonByName({
				inputSelectorForName : '#linkName',
				searchLineSelector: '#linkName',
				parentSelector: '.scroll-block'
			})
		})
	</script>
</div>
<script>
$(document).ready(function(){
<!--	$('input.contact-input').clientListSearch({-->
<!--		url: '--><?//= Yii::app()->createUrl('/contact/search') ?><!--'-->
<!--	})-->
})
</script>