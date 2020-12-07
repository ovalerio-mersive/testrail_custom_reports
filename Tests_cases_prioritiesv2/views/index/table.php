<table class="grid">
<caption style="caption-side:bottom;text-align:right;">
	<h3><?= lang('reports_tmpl_table_automated_p1') ?>: <?php $total_automated_cases ?> </h3>
	<h3><?= lang('reports_tmpl_table_automated_total') ?>: </h3>
</caption>
	<tr class="header">
		<th><?=h( $header )?></th>
		<?php foreach ($priorities as $p): ?>
			<th style="text-align: right">
				<span class="statusBox">&nbsp;&nbsp;</span>
				<?= h( $p->name ) ?>
			</th>
		<?php endforeach ?>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($section_ids as $section_id): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<tr class="<?= $alt ?>">
		<?php
			echo "<td>" . $section_id . "</td>";
			foreach($items as $item) {
				if ($section_id == $item->section_id) {
					echo "<td style='text-align: right'>" . $item->priority_count . "</td>";
				}
			}
		?>
		</tr>
	<?php endforeach ?>
</table>