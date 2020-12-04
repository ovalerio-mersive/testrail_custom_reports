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
		<?php foreach ($priorities as $p): ?>
			<th style="text-align: right">$p->name</th>
		<?php endforeach ?>
	</tr>
	<?php arr::alternator() ?>
</table>
