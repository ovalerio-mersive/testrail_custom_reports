<table class="grid">
	<colgroup>
		<col></col>
		<?php foreach ($statuses as $status): ?>
			<col style="width: 100px"></col>
		<?php endforeach ?>
		<col style="width: 75px"></col>
	</colgroup>
	<tr class="header">
		<th><?=h( $header )?></th>
		<?php foreach ($statuses as $status): ?>
			<th style="text-align: right">
				<span class="statusBox" style="<?= tests::get_status_box_colors($status->color_dark) ?>">&nbsp;&nbsp;</span>
				<?=h( $status->label ) ?>
			</th>
		<?php endforeach ?>
		<th style="text-align: right"><?= lang('reports_tmpl_table_total') ?></th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($items as $item): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<tr class="<?= $alt ?>">
			<td><?=h( $item->name )?></td>
			<?php $total = 0 ?>
			<?php foreach ($statuses as $status): ?>
				<?php if (isset($results[$item->id][$status->id])): ?>
					<?php $total += $results[$item->id][$status->id] ?>
				<?php endif ?>
			<?php endforeach ?>
			<?php foreach ($statuses as $status): ?>
			<td style="text-align: right">
				<?php if (isset($results[$item->id][$status->id])): ?>
					<?php $result = $results[$item->id][$status->id] ?>
					<?php if ($total > 0): ?>
						<?php $percent = (int) (($result / $total) * 100) ?>
					<?php else: ?>
						<?php $percent = 0 ?>
					<?php endif ?>
				<?php else: ?>
					<?php $result = 0 ?>
					<?php $percent = 0 ?>
				<?php endif ?>
				<?= $result ?> <span class="secondary">(<?= $percent ?>%)</span>
			</td>
			<?php endforeach ?>
			<td style="text-align: right"><?= $total ?></td>
		</tr>
	<?php endforeach ?>
</table>
