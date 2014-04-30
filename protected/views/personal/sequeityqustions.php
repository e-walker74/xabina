<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_view" class="xabina-form-container">
		<div class="subheader"><?= Yii::t('Front', 'Security Questions'); ?></div>
		<table class="table xabina-table-personal">
			<tbody>
			<tr class="table-header">
				<th style="width: 53%"><?= Yii::t('Front', 'Security Questions'); ?></th>
				<th style="width: 40%"><?= Yii::t('Front', 'Answers'); ?></th>
				<th style="width: 7%"></th>
			</tr>
			
			<?php if(count($user->questions) < 2):?>
				<?php $this->renderPartial('_first_questions', array('user' => $user, 'model' => $model)) ?>
			<?php else: ?>
				<?php $this->renderPartial('_questions', array('user' => $user, 'model' => $model)) ?>
			<?php endif; ?>
			</tbody>
		</table>
		
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>" class="submit-button button-back"><?= Yii::t('Front', 'Back')?></a> 
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<script>
$('.types_dropdown').tempDropDown({
	list: {
		<? foreach(Users_EmailTypes::all() as $k => $v):?>
		<? if(!empty($k) && !empty($v)):?>
	    '<?=$k?>': {id:<?=$k?>, name:'<?=$v?>'},
		<? endif; ?>
		<? endforeach;?>
	},
	listClass: 'type_dropdown',
	callback: function(element, dropdown){
		$.post(
			'<?= Yii::app()->createUrl('/personal/changetype', array('type' => 'instmessagers')) ?>',
			{row_id : dropdown.attr('row-id'), type_id: $(element.currentTarget).attr('data-id')},
			function(data){
				
			}
		)
	}
});

$('.delete').confirmation({
	title: '<?= Yii::t('Front', 'Are you sure?') ?>',
	singleton: true,
	popout: true,
	onConfirm: function(){
		link = $(this).parents('.popover').prev('a')
		deleteRow(link);
		return false;
	}
})

</script>
