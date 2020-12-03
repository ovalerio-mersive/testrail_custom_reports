<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $GI->load->view('report_plugins/charts/defaults') ?>

<?php $chart_height = max(count($case_groups) * 25 + 75, 150) ?>

<div class="chartContainer">
	<div id="chart0" style="height: <?php echo  $chart_height ?>px;"></div>
</div>

<script type="text/javascript">
var chart_bar;

function beforePrint()
{
	chart_bar.setSize(900, <?php echo  $chart_height ?>, false);
	$('#chart0').css('width', '900px');
}

function afterPrint()
{
	$('#chart0').css('width', '');
	var options = chart_bar.options;
	chart_bar.destroy();
	chart_bar = new Highcharts.Chart(options);
}

$(function () {
	$(document).ready(function() {
		chart_bar = new Highcharts.Chart({
			chart: {
				renderTo: 'chart0',
				type: 'bar'
			},
			title: {
				text: '<?php echo  langf('reports_cpg_charts_bar_title',
					h($case_groupby_name)) ?>'
			},
			xAxis: {
				categories: [
				<?php $is_first = true ?>
				<?php foreach ($case_groups as $group): ?>
					<?php if (!$is_first): ?>
					,
					<?php endif ?>
					<?php $category = h($group->name) ?>
					<?php echo  js::encode_string($category)?>
					<?php $is_first = false ?>
					<?php endforeach ?>
				],
				tickmarkPlacement: 'on',
				title: {
					enabled: false
				}
			},
			tooltip: {
				enabled: true
			},
			legend: {
				enabled: false
			},
			yAxis: {
				title: {
					text: ''
				},
				allowDecimals: false,
				labels: {
					overflow: 'justify'
				}
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			series: [
				<?php $data = array() ?>
				<?php foreach ($case_groups as $group): ?>
					<?php $data[] = $group->case_count ?>
				<?php endforeach ?>
				{
					name: <?php echo  js::encode_string(lang('reports_cpg_cases_cases')) ?>,
					data: <?php echo  json::encode( $data ) ?>
				}
			]
		});
	});
});

</script>