<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $GI->load->view('report_plugins/charts/defaults') ?>

<?php $chart_height = max(count($priorities) * 25 + 75, 150) ?>

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
		chart_bar = new Highcharts.Chart(
            {
                chart: {
                    renderTo: 'chart0',
                    type: 'pie'
                },
                title: {
                    text: 'All Cases in Selected Sections'
                },
                subtitle: {
                    text: 'Priorities'
                },
                xAxis: {
                    // categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                    categories: [
<?php $is_first = true ?>
<?php foreach ($priorities as $p): ?>
    <?php if (!$is_first): ?>
    ,
    <?php endif ?>
    <?php $category = h($p->name) ?>
    <?php echo  js::encode_string($category)?>
    <?php $is_first = false ?>
<?php endforeach ?>
                    ],
                    tickmarkPlacement: 'on',
                    title: {
                        enabled: false
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Priorities (All selected sections)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    enabled: true
                    // pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
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
<?php foreach ($priorities as $p): ?>
    <?php $data[] = $p->id ?>
<?php endforeach ?>
{
    name: <?php echo  js::encode_string(lang('reports_tmpl_cases_cases')) ?>,
    data: <?php echo  json::encode( $data ) ?>
}]
            }
        );
	});
});

</script>