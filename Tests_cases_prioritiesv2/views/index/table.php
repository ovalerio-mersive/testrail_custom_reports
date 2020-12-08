<table class="grid">
<caption style="caption-side:bottom;text-align:right;">
<div class="card">
  <div class="card-header">
    Featured
  </div>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
<?php
	echo "<h3>" . lang('reports_tmpl_table_automated_p1') . ": " . $automated_p1_cases[0]->total_automated_tcs_with_priority . " ( x% )</h3>";
	echo "<h3>" . lang('reports_tmpl_table_automated_total') . ": " . $total_automated_cases[0]->total_automated_tcs . " ( x% )</h3>";
?>	
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