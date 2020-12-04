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

<?php
$stats = obj::create();
$stats->p1s = 0;
$stats->p2s = 0;
$stats->p3s = 0;
$stats->p4s = 0;
// $stats->total_tcs = count($cases);

foreach ($cases as $c)
{
	// echo "<br><br><br> -- ";
	// print_r($case);
	switch ($c->priority_id) {
		case 1:
			$stats->p1s += 1;
			break;
		case 2:
			$stats->p2s += 1;
			break;
		case 3:
			$stats->p3s += 1;
			break;
		case 4:
			$stats->p4s += 1;
			break;
		default:
			break;
	
	}

	echo "Cases with p1: " . $stats->p1s . "<br/>";
	echo "Cases with p2: " . $stats->p2s . "<br/>";
	echo "Cases with p3: " . $stats->p3s . "<br/>";
	echo "Cases with p4: " . $stats->p4s . "<br/>";

}

?>




<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>