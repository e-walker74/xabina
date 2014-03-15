<div class="total_currencies">
	<?php foreach($currencies as $curr): ?>
		<span class="<?= $curr->code ?>"><?= number_format(round($total * $curr->last_value, 3), 0, "", " ") ?></span>
	<?php endforeach; ?>
</div>