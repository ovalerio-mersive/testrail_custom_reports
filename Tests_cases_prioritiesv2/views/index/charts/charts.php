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
		chart_bar = new Highcharts.Chart({
            chart: {
                renderTo: 'chart0',
                type: 'bar'
            },
            title: {
                text: 'Test Cases by Priority'
            },
            xAxis: {
                categories: [
                                                                                            'Low'                                                                               ,
                                                            'Medium'                                                                                ,
                                                            'High'                                                                              ,
                                                            'Critical'                                                      ],
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
                {
                    name: 'Test Cases',
                    data: [34,313,4,7]              
                }
            ]
        });
	});
});

</script>