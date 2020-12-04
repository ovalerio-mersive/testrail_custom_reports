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
$stats->total_tcs = count($cases);
$stats->total_automated_tcs_p1 = $automated_p1_cases[0]->total_automated_tcs_with_priority;
$stats->total_automated_tcs = $total_automated_cases[0]->total_automated_tcs;

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
}

echo "Total cases: " . $stats->total_tcs . "<br/>";
echo "Cases with p1: " . $stats->p1s . "  (". number_format((float)($stats->p1s * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "Cases with p2: " . $stats->p2s . "  (". number_format((float)($stats->p2s * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "Cases with p3: " . $stats->p3s . "  (". number_format((float)($stats->p3s * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "Cases with p4: " . $stats->p4s . "  (". number_format((float)($stats->p4s * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";

echo "<br><br>Automated P1 test cases: " . $stats->total_automated_tcs_p1 . "  (". number_format((float)($stats->total_automated_tcs_p1 * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "<br><br>Total automated test cases: " . $stats->total_automated_tcs . "  (". number_format((float)($stats->total_automated_tcs * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";

?>




<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>