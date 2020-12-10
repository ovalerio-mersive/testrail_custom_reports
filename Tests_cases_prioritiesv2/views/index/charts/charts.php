<?php 
print_r($items);
?>

<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $GI->load->view('report_plugins/charts/defaults') ?>

<?php $chart0_height = max(count($priorities_categories_data) * 30 + 75, 150) ?>
<?php $chart1_height = max(count($sections_categories_data) * 30 + 75, 150) ?>

<div class="chartContainer">
	<div id="chart0" style="height: <?php echo  $chart0_height ?>px;"></div>
</div>

<div class="chartContainer">
	<div id="chart1" style="height: <?php echo  $chart1_height ?>px;"></div>
</div>

<script type="text/javascript">
var chart_bar;
var chart_bar2;

function beforePrint()
{
	chart_bar.setSize(900, <?php echo  $chart0_height ?>, false);
    $('#chart0').css('width', '900px');

    chart_bar1.setSize(900, <?php echo  $chart1_height ?>, false);
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
                    categories: <?php echo json::encode( $priorities_categories_data ) ?>,
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
                    categories: <?php echo json::encode( $sections_categories_data ) ?>,
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
                series: [
                    <?php
                        $row_per_section = array();
                        $all_rows = array();
                        foreach ($priorities as $p) {
                            $total_tcs = 0; 
                            foreach ($sections as $section) {
                                foreach($items as $item) {
                                    if ($p->name == $item->priority_name && $section->id == $item->section_id) {
                                        $total_tcs += $item->priority_count;
                                    }
                                } 
                                array_push($row_per_section, $total_tcs); 
                            }
                            array_push($all_rows, $total_tcs); 
                        }
                        // print_r($all_rows);
                    ?>
                    <?php foreach ($priorities_categories_data as $data_name): ?>
                        {
                            name: <?php echo js::encode_string($data_name) ?>,
                            data: <?php echo json::encode( [1, 2, 3, 4, 5, 6] ) ?>,
                        },
                    <?php endforeach ?>
                        
                    // {
                    //     name: <?php echo js::encode_string($p->name) ?>,
                    //     data: <?php echo json::encode( [1, 2, 3, 4, 5] ) ?>,
                    // },
                ]
                // series: [{
                //     name: 'John',
                //     data: [5, 3, 4, 7, 2, 3]
                // }, {
                //     name: 'Jane',
                //     data: [2, 2, 3, 2, 1, 7]
                // }, {
                //     name: 'Joe',
                //     data: [3, 4, 4, 2, 5, 10]
                // }]
            }
        )
	});
});

</script>