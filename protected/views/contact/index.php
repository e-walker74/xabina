<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My contact') ?></div>
	<div class="contact-search-cont">
		<input class="contact-input" type="text" />
		<a class="contact-search-but" href="#"></a>
		<a class="add-contact-but rounded-buttons" href="#"><?= Yii::t('Front', 'Add Contact') ?></a>
	</div>
	<div class="contacts-list-cont">
		<?php Widget::get('contactListWidget')->html() ?>
	</div>
</div>
<script>
$(document).ready(function(){
	$('input.contact-input').clientListSearch({
		url: '<?= Yii::app()->createUrl('/contact/search') ?>'
	})
})
</script>