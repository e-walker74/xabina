<div style="text-align:right;" class="total_currencies">
	<?php foreach($currencies as $curr): ?>
		<span class="<?= $curr->code ?> <?php if($total >= 0): ?>sum-inc<?php else: ?>sum-dec<?php endif; ?>">
			<?= number_format(round($total * $curr->last_value, 3), 2, ".", " ") ?>
		</span>
	<?php endforeach; ?>
</div>