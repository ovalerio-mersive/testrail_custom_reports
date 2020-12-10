<?php 
print_r($categories_data);
?>
<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $GI->load->view('report_plugins/charts/defaults') ?>

<?php $chart_height = max(count($priorities) * 40 + 75, 150) ?>

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
                    type: 'bar'
                },
                title: {
                    text: 'All Cases in Selected Sections'
                },
                subtitle: {
                    text: 'Priorities'
                },
                xAxis: {
                    categories: <?php echo  json::encode( $series_data ) ?>,
                    tickmarkPlacement: 'on',
                    title: {
                        enabled: false
                    }
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
                legend: {
                    enabled: false
                },
                tooltip: {
                    enabled: true
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [
{
    name: <?php echo  js::encode_string(lang('reports_tmpl_cases_cases')) ?>,
    data: <?php echo  json::encode( $series_data ) ?>
}]
            }
        );
	});
});

</script>