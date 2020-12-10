<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $GI->load->view('report_plugins/charts/defaults') ?>

<?php $chart_height = max(count($priorities_categories_data) * 40 + 75, 150) ?>

<div class="chartContainer">
	<div id="chart0" style="height: <?php echo  $chart_height ?>px;"></div>
</div>

<div class="chartContainer">
	<div id="chart1" style="height: <?php echo  $chart_height ?>px;"></div>
</div>

<script type="text/javascript">
var chart_bar;
var chart_bar2;

function beforePrint()
{
	chart_bar.setSize(900, <?php echo  $chart_height ?>, false);
    $('#chart0').css('width', '900px');

    chart_bar1.setSize(900, <?php echo  $chart_height ?>, false);
	$('#chart1').css('width', '900px');
}

function afterPrint()
{
	$('#chart0').css('width', '');
	var options = chart_bar.options;
	chart_bar.destroy();
    chart_bar = new Highcharts.Chart(options);
    
    $('#chart1').css('width', '');
	var options = chart_bar1.options;
	chart_bar1.destroy();
	chart_bar1 = new Highcharts.Chart(options);
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
                    categories: <?php echo  json::encode( $priorities_categories_data ) ?>,
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
                        data: <?php echo  json::encode( $priorities_series_data ) ?>
                    }
                ]
            }
        );

        chart_bar1 = new Highcharts.Chart(
            {
                chart: {
                    renderTo: 'chart1',
                    type: 'bar'
                },
                title: {
                    text: 'Stacked bar chart'
                },
                xAxis: {
                    categories: <?php echo  json::encode( $sections_categories_data ) ?>,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total fruit consumption'
                    }
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                series: [{
                    name: 'John',
                    data: [5, 3, 4, 7, 2, 3]
                }, {
                    name: 'Jane',
                    data: [2, 2, 3, 2, 1, 3]
                }, {
                    name: 'Joe',
                    data: [3, 4, 4, 2, 5, 3]
                }]
            }
        )
	});
});

</script>