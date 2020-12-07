<pre>
<?php var_dump($items); ?>
</pre>
<table class="grid">
	<colgroup>
		<col></col>
		<?php foreach ($priorities as $p): ?>
			<col style="width: 100px"></col>
		<?php endforeach ?>
		<col style="width: 300px"></col>
		<col style="width: 150px"></col>
	</colgroup>
	<tr class="header">
		<th><?=h( $header )?></th>
		<?php foreach ($priorities as $p): ?>
			<th style="text-align: right">
				<span class="statusBox">&nbsp;&nbsp;</span>
				<?= h( $p->name ) ?>
			</th>
		<?php endforeach ?>
		<th style="text-align: right"><?= lang('reports_tmpl_table_automated_p1') ?></th>
		<th style="text-align: right"><?= lang('reports_tmpl_table_automated_total') ?></th>
	</tr>
	<?php arr::alternator() ?>
	<?php foreach ($section_ids as $section_id): ?>
		<?php foreach ($priorities as $p): ?>
			<?php $alt = arr::alternator('odd', 'even') ?>
			<tr class="<?= $alt ?>">
			<?php
				echo "<td>" . $section_id . "</td>";
				foreach($items as $item) {
					if ($section_id == $item->section_id) {
						echo "<td>" . $item->priority_count . "</td>";
					}
				}
				// echo "<td>" . key($sections) . " -- Count obj: " . $sections[key($sections)]->priority_count . "</td>";
			?>
			</tr>
			<?php endforeach ?>
	<?php endforeach ?>
</table>