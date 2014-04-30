<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="xabina-form-container">
	
	
	<div class="h1-header">
		<?= Yii::t('Front', 'My personal cabinet'); ?>
	</div>
	<div class="subheader"><?= Yii::t('Front', 'Manage settings'); ?></div>
	<form name="settings-form" id="settings_form">
	<table class="table xabina-table table-options">
		<tbody><tr class="table-header">
			<th width="15%"><?= Yii::t('Front', 'Options'); ?></th>
			<th width="80%"></th>
			<th width="5%"></th>
		</tr>
		<tr class="user-settings-data">
			<td><?= Yii::t('Front', 'Language'); ?></td>
			<td class="data"><?= Languages::$languages[$user->settings->language] ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-block">
			<td><?= Yii::t('Front', 'Language'); ?></td>
			<td>
				<div class="select-custom ">
					<span class="select-custom-label"><?= Languages::$languages[$user->settings->language] ?></span>
					<?= CHtml::activeDropDownList($user->settings, 'language', Languages::$languages, array('class' => 'select-invisible')) ?>
				</div>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button ok"></a>
				</div>
			</td>
		</tr>
		<tr class="user-settings-data">
			<td><?= Yii::t('Front', 'Statement language'); ?></td>
			<td class="data"><?= Languages::$languages[$user->settings->statement_language] ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-block">
			<td><?= Yii::t('Front', 'Statement language'); ?></td>
			<td>
				<div class="select-custom ">
					<span class="select-custom-label"><?= Languages::$languages[$user->settings->statement_language] ?></span>
					<?= CHtml::activeDropDownList($user->settings, 'statement_language', Languages::$languages, array('class' => 'select-invisible')) ?>
				</div>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button ok"></a>
				</div>
			</td>
		</tr>
		<tr class="user-settings-data">
			<td><?= Yii::t('Front', 'Font size'); ?></td>
			<td class="data"><?= $user->settings->font_size ?>px</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-block">
			<td><?= Yii::t('Front', 'Font size'); ?></td>
			<td>
				<div class="select-custom ">
					<span class="select-custom-label"><?= $user->settings->font_size ?>px</span>
					<?= CHtml::activeDropDownList($user->settings, 'font_size', array(
						'10' => '10px',
						'12' => '12px',
						'14' => '14px',
						'16' => '16px',
					), array('class' => 'select-invisible')) ?>
				</div>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button ok"></a>
				</div>
			</td>
		</tr>
		<tr class="user-settings-data">
			<td><?= Yii::t('Front', 'Time zone'); ?></td>
			<td class="data"><?= $user->settings->time_zone ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-block">
			<td><?= Yii::t('Front', 'Time zone'); ?></td>
			<td>
				<div class="select-custom ">
					<span class="select-custom-label"><?= $user->settings->time_zone ?></span>
					<?= CHtml::activeDropDownList($user->settings, 'time_zone', array(
						'1' => '1',
						'2' => '3',
					), array('class' => 'select-invisible')) ?>
				</div>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button ok"></a>
				</div>
			</td>
		</tr>
		<tr class="user-settings-data">
			<td><?= Yii::t('Front', 'Currency'); ?></td>
			<td class="data"><?= $user->settings->currency->code ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-block">
			<td><?= Yii::t('Front', 'Currency'); ?></td>
			<td>
				<div class="select-custom ">
					<span class="select-custom-label"><?= $user->settings->currency->code ?></span>
					<?= CHtml::activeDropDownList($user->settings, 'currency_id', 
					CHtml::listData(Currencies::model()->findAll(), 'id', 'title'),
					array('class' => 'select-invisible')) ?>
				</div>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="#" class="button ok"></a>
				</div>
			</td>
		</tr>
	</tbody></table>
	
	<div class="form-submit">
		<a href="<?= Yii::app()->createUrl('/personal/index') ?>" class="submit-button button-back">Back</a>
	</div>
	
	</form>
	</div>
</div>


<script>
	
	$('.edit').click(function(){
		reset_setings()
		$(this).parents('tr').hide().next('.edit-block').show()
		return false;
	})
	
	var reset_setings = function(){
		$('.edit-block').hide();
		$('.user-settings-data').show();
	}
	
	$('.ok').click(function(){
		row = $(this).parents('tr')
		
		$.ajax({
			type: "POST",
			success: function(data){
				if(data.success){
					successNotify('<?= Yii::t('Front', 'Account Settings') ?>', '<?= Yii::t('Front', 'Changes was successfully saved') ?>')
					row.prev('.user-settings-data').find('.data').html(row.find('select option:selected').text())
					reset_setings()
				}
			},
			dataType: 'json',
			data: $('#settings_form').serialize()
		});
		return false;
	})
	
</script>