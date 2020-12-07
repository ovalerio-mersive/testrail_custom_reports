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


$summary = [];

foreach($section_ids as $s) {
	echo "<br/><br/>";
	print_r($s);
	$stats = obj::create();
	$stats->section_name = "";
	$stats->priority_name = "";
	$stats->priority_count = 0;

	foreach($priorities as $p) {
		foreach($cases as $c) {
			// if ($stats->priority_name == "") {
			// 	$stats->section_name = $c->section_name;
			// 	$stats->priority_name = $c->p_name;
			// }
			if ($c->case_p_id == $p->id && $c->case_s_id == $s && $c->case_p_id == $p->id) {
				$stats->section_name = $c->section_name;
				$stats->priority_name = $c->p_name;
				$stats->priority_count += 1;
			}
		}
	}
	array_push($summary, $stats);
}

echo "<br/><br/><br/><br/>";
print_r($summary);

// foreach ($cases as $c)
// {
// 	switch ($c->p_name) {
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

// <h1>For debuging</h1>
// print_r($priorities);

// echo "<br/><br/><hr/><br/>Total cases: 		" . $stats->total_tcs . "<br/>";
// echo "Cases with Low priority: 		" . $stats->p_low . "  (". number_format((float)($stats->p_low * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
// echo "Cases with Medium priority: 	" . $stats->p_medium . "  (". number_format((float)($stats->p_medium * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
// echo "Cases with High priority: 	" . $stats->p_high . "  (". number_format((float)($stats->p_high * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
// echo "Cases with Critical priority: " . $stats->p_critical . "  (". number_format((float)($stats->p_critical * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
// echo "<hr/>";
// echo "<br>Automated P1 test cases: " . $stats->total_automated_tcs_p1 . "  (". number_format((float)($stats->total_automated_tcs_p1 * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
// echo "<br>Total automated test cases: " . $stats->total_automated_tcs . "  (". number_format((float)($stats->total_automated_tcs * 100) / $stats->total_tcs, 2, '.', '') ."%)" . "<br/>";
// echo "<hr/>";
?>




<?php
$temp = array();
$temp['report'] = $report;
$temp['meta'] = $report_obj->get_meta();
$temp['show_options'] = true;
$temp['show_report'] = true;
$GI->load->view('report_plugins/layout/footer', $temp);
?>