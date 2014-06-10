<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My contact') ?></div>
	<div class="contact-search-cont">
		<input class="contact-input" placeholder="<?= Yii::t('Front', 'Search...') ?>" type="text" id="linkName" />
		<a class="contact-search-but" href="#" style="display:none;"></a>
		<a class="add-contact-but rounded-buttons" href="<?= Yii::app()->createUrl('/contact/create') ?>"><?= Yii::t('Front', 'Add Contact') ?></a>
	</div>
	<div class="contacts-list-cont scroll-block">
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
	$('input.contact-input').clientListSearch({
		url: '<?= Yii::app()->createUrl('/contact/search') ?>'
	})
})
</script>