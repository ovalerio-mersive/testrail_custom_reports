<?php
$min_width = 960;

$header = array(
	'project' => $project,
	'report' => $report,
	'meta' => $report_obj->get_meta(),
	'min_width' => $min_width,
	'css' => array(
		'styles/reset.css' => 'all',
		'styles/view.css' => 'all',
		'styles/print.css' => 'print'
	),
	'js' => array(
		'js/jquery.js',
		'js/highcharts.js'
	)
);

$GI->load->view('report_plugins/layout/header', $header);
$GI->load->view('report_plugins/charts/defaults');
?>

<?php
$items = [];
foreach($sections as $s) {
	$section_info = array();
	foreach($priorities as $p) {
		$stats = obj::create();
		$stats->section_id = $s->id;
		$stats->priority_count = 0;
		$stats->priority_name = $p->name;
		foreach($cases as $c) {
			if ($c->case_p_id == $p->id && $c->case_s_id == $s->id) {
				$stats->priority_count += 1;
			}
		}
		array_push($items, $stats);
	}
}

$total_cases = 0;
foreach($cases as $c) {
	$total_cases += 1;
}
?>

<?php 
$temp = array();
$temp['priorities'] = $priorities;
$temp['case_groupby_name'] = $case_groupby_name;
$report_obj->render_view('index/charts', $temp);
?>

<h1>
	<img class="right noPrint" src="%RESOURCE%:images/icons/help.png" width="16" height="16" alt="" title="<?= lang('reports_tmpl_cases_header_info') ?>" />
	<?= lang('reports_tmpl_cases_header') ?> 
</h1>
<?php if ($cases): ?>
	<?php
	$temp = array();
	$temp['header'] = lang('reports_tmpl_section_item');
	$temp['priorities'] = $priorities;
	$temp['items'] = $items;
	$temp['total_cases'] = $total_cases;
	$temp['sections'] = $sections;
	$temp['suite_id'] = $suite_ids[0];
	$temp['automated_p1_cases'] = $automated_p1_cases;
	$temp['total_automated_cases'] = $total_automated_cases;
	$report_obj->render_view('index/table', $temp);
	?>
<?php else: ?>
	<p><?= lang('reports_tmpl_cases_empty') ?></p>
<?php endif ?>


<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>