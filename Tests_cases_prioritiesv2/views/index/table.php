<table class="grid">
<caption style="caption-side:bottom;text-align:right;">
<div class="card p-2">
	<label style="font-size:13;"><?php echo lang('reports_tmpl_table_automated_p1') . ": <b>". $automated_p1_cases[0]->total_automated_tcs_with_priority ."/20%</b>"; ?></label>
	<label style="font-size:13;"><?php echo lang('reports_tmpl_table_automated_total') . ": <b>". $total_automated_cases[0]->total_automated_tcs ."/20%</b>"; ?></label>
</div>
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