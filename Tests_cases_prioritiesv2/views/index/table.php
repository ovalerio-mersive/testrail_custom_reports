<table class="grid">
<caption style="caption-side:bottom;text-align:right;">
<div class="card p-2">
	<label style="font-size:13;"><?php echo lang('reports_tmpl_table_automated_p1') . ": <b>". $automated_p1_cases[0]->total_automated_tcs_with_priority ."/20%</b>"; ?></label><br/>
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
		<th style='text-align: right'>Total</th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($sections as $section): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<tr class="<?= $alt ?>">
		<?php
			echo "<td>" . $section->name . "</td>";
			$total_tcs = 0;
			foreach($items as $item) {
				if ($section->id == $item->section_id) {
					echo "<td style='text-align: right'>" . $total_cases . " - " . $item->priority_count . " (" . round(($item->priority_count * 100) / $total_cases) . "%)" . "</td>";
					$total_tcs += $item->priority_count;
				}
			}
			echo "<td style='text-align: right;background-color:#ffff0029;'>" . $total_tcs . "</td>";
		?>
		</tr>
	<?php endforeach ?>
</table>