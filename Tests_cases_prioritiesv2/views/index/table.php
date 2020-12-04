<table class="grid">
	<colgroup>
		<col></col>
		<?php foreach ($cases as $case): ?>
			<col style="width: 100px"></col>
		<?php endforeach ?>
		<col style="width: 75px"></col>
	</colgroup>
	<tr class="header">
		<th><?=h( $header )?></th>
		<?php foreach ($cases as $case): ?>
			<th style="text-align: right">
				<span class="statusBox" style="<?= tests::get_status_box_colors($status->color_dark) ?>">&nbsp;&nbsp;</span>
				<?=h( $case->id ) ?>
			</th>
		<?php endforeach ?>
		<!-- <th style="text-align: right"><?= lang('reports_tmpl_table_total') ?></th> -->
	</tr>
	<?php arr::alternator() ?>
</table>
