<?php
$min_width = 250;
foreach ($statuses as $status)
{
	$min_width += 100;
}

$min_width = max(960, $min_width);
 
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
?>
 
The report content goes here.
<?php
$stats = obj::create();
$stats->passed_count = 0;
$stats->retest_count = 0;
$stats->failed_count = 0;
$stats->untested_count = 0;
$stats->blocked_count = 0;
$stats->custom_status1_count = 0;
$stats->custom_status2_count = 0;
$stats->custom_status3_count = 0;
$stats->custom_status4_count = 0;
$stats->custom_status5_count = 0;
$stats->custom_status6_count = 0;
$stats->custom_status7_count = 0;

foreach ($runs as $r)
{
	$stats->passed_count += $r->passed_count;
	$stats->retest_count += $r->retest_count;
	$stats->failed_count += $r->failed_count;
	$stats->untested_count += $r->untested_count;
	$stats->blocked_count += $r->blocked_count;
	$stats->custom_status1_count += $r->custom_status1_count;
	$stats->custom_status2_count += $r->custom_status2_count;
	$stats->custom_status3_count += $r->custom_status3_count;
	$stats->custom_status4_count += $r->custom_status4_count;
	$stats->custom_status5_count += $r->custom_status5_count;
	$stats->custom_status6_count += $r->custom_status6_count;
	$stats->custom_status7_count += $r->custom_status7_count;
	tests::set_status_percents($r);
}
tests::set_status_percents($stats);

$GI->load->view('report_plugins/charts/defaults')
?>

<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>