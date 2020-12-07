<!-- <?php print_r($items); ?> -->
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
	<?php 

		// // get the sections
		// $current_secction = "";
		// $rows = array();
		// $p_low = 0;
		// $p_medium = 0;
		// $p_high = 0;
		// $p_critical = 0;

		// foreach ($items as $item) {
		// 	if ($current_secction != "" && $current_secction != $item->section_name ) {
		// 		$rows['section_name'] = $item->section_name;
		// 		$p_low = 0;
		// 		$p_medium = 0;
		// 		$p_high = 0;
		// 		$p_critical = 0;
		// 	}

		// 	switch ($item->p_name) {
		// 		case "Low":
		// 			$stats->p_low += 1;
		// 			break;
		// 		case "Medium":
		// 			$stats->p_medium += 1;
		// 			break;
		// 		case "High":
		// 			$stats->p_high += 1;
		// 			break;
		// 		case "Critical":
		// 			$stats->p_critical += 1;
		// 			break;
		// 		default:
		// 			break;
		// 	}
		// }

		// // get sumary per section
		// foreach($sections as $section) {
		// 	foreach ($cases as $case ) {
		// 		if ($case->section_name == $section) {

		// 		}
		// 	}
		// }
	?>
</table>
