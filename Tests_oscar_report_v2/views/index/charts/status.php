<?php
$temp = array();
$temp['stats'] = $stats;
$temp['statuses'] = $statuses;
$GI->load->view('report_plugins/charts/status', $temp);
?>