<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_view" class="xabina-form-container">
		<div class="subheader"><?= Yii::t('Front', 'My security questions'); ?></div>
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

$('.delete').confirmation({
	title: '<?= Yii::t('Front', 'Are you sure?') ?>',
	singleton: true,
	popout: true,
	onConfirm: function(){
		link = $(this).parents('.popover').prev('a')
		deleteRow(link, function(){
			if($('.question-row').length < 5){
				$('.comment-tr').hide()
				$('.add-new-td').parent().show()
			}else{
				$('.comment-tr').show()
				$('.add-new-td').parent().hide()
			}
			resetPage()
			chechSequrityValuesData()
		});
		return false;
	}
})
chechSequrityValuesData()
</script>
