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
                    type: 'column'
                },
                title: {
                    text: 'World\'s largest cities per 2017'
                },
                subtitle: {
                    text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population (millions)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
                },
                series: [{
                    name: 'Population',
                    data: [
                        ['Shanghai', 24.2],
                        ['Beijing', 20.8],
                        ['Karachi', 14.9],
                        ['Shenzhen', 13.7],
                        ['Guangzhou', 13.1],
                        ['Istanbul', 12.7],
                        ['Mumbai', 12.4],
                        ['Moscow', 12.2],
                        ['São Paulo', 12.0],
                        ['Delhi', 11.7],
                        ['Kinshasa', 11.5],
                        ['Tianjin', 11.2],
                        ['Lahore', 11.1],
                        ['Jakarta', 10.6],
                        ['Dongguan', 10.6],
                        ['Lagos', 10.6],
                        ['Bengaluru', 10.3],
                        ['Seoul', 9.8],
                        ['Foshan', 9.3],
                        ['Tokyo', 9.3]
                    ],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:.1f}', // one decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            }
        );
	});
});

</script>