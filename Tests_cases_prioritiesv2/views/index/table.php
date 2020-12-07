<?php print_r($items); ?>
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
	<?php foreach ($items as $sections): ?>
		<?php $alt = arr::alternator('odd', 'even') ?>
		<tr class="<?= $alt ?>">
			<?php foreach ($sections as $s): ?>
				<td><?php print_r($s); ?></td>
			<?php endforeach ?>
		</tr>
	<?php endforeach ?>
</table>