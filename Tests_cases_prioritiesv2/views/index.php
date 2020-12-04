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
$stats->p_low = 0;
$stats->p_medium = 0;
$stats->p_high = 0;
$stats->p_critical = 0;
$stats->total_tcs = count($cases);
$stats->total_automated_tcs_p1 = $automated_p1_cases[0]->total_automated_tcs_with_priority;
$stats->total_automated_tcs = $total_automated_cases[0]->total_automated_tcs;

foreach ($cases as $c)
{
	echo "<br><br><br> -- ";
	print_r($c);
	switch ($c->p_name) {
		case "Low":
			$stats->p_low += 1;
			break;
		case "Medium":
			$stats->p_medium += 1;
			break;
		case "High":
			$stats->p_high += 1;
			break;
		case "Critical":
			$stats->p_critical += 1;
			break;
		default:
			break;
	}
}

echo "<br/><br/><hr/><br/>Total cases: 		" . $stats->total_tcs . "<br/>";
echo "Cases with Low priority: 		" . $stats->p_low . "  (". number_format((float)($stats->p_low * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "Cases with Medium priority: 	" . $stats->p_medium . "  (". number_format((float)($stats->p_medium * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "Cases with High priority: 	" . $stats->p_high . "  (". number_format((float)($stats->p_high * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "Cases with Critical priority: " . $stats->p_critical . "  (". number_format((float)($stats->p_critical * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "<hr/>";
echo "<br>Automated P1 test cases: " . $stats->total_automated_tcs_p1 . "  (". number_format((float)($stats->total_automated_tcs_p1 * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "<br>Total automated test cases: " . $stats->total_automated_tcs . "  (". number_format((float)($stats->total_automated_tcs * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
echo "<hr/>";
?>




<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>