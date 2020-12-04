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
echo "<br>-------------------------<br><br><br><br><br>";
print_r($cases);
echo "<br>-------------------------<br><br><br><br><br>";

echo "<br>-------------------------<br><br><br><br><br>";
print_r($suite_ids);
echo "<br>-------------------------<br><br><br><br><br>";
?>

<?php foreach ($cases as $case): ?>
<?php   echo "<br/> ---" ?>
<?php   print_r($case); ?>
<?php endforeach ?>


<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>