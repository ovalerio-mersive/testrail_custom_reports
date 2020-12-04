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
		'js/jquery.js'
	)
);

$GI->load->view('report_plugins/layout/header', $header);
?>

<p>Content will be here!!</p>

<?php
echo "<br>REPORT-------------------------<br>";
print_r($report);
echo "<br>PROJECT-------------------------<br>";
print_r($project);
echo "<br>OPTIONS-------------------------<br>";
print_r($options);
echo "<br>Report 2-------------------------<br>";
print_r($report->custom_options['sections_ids']);
echo "<br>-------------------------<br><br><br><br><br>";
?>


<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>