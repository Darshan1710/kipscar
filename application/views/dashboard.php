
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE; ?></title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
    <script src="<?php echo base_url()?>js/charts/loader.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url() ?>js/plugins/visualization/d3/d3.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/styling/switchery.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/ui/moment/moment.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/pickers/daterangepicker.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/dashboard.js"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <?php $this->load->view('common/navbar'); ?>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <?php $this->load->view('common/sidebar'); ?>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                   
                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
                            <li class="active">Dashboard</li>
                        </ul>

                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                    <div class="content">

                    <!-- Main charts -->
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Traffic sources -->
                            <div class="panel panel-flat">
                                
                                <div class="content">
                   
                                    <div class="card-body">
                                        
                                        
                                        <div class="row ">
                                                <div class="col-lg-3">
                                                <div class="panel bg-teal-400">
                                                    <div class="panel-body">
                                                        <h3 class="no-margin"><?php echo $dashboard['total_customer'] ?></h3>
                                                        Total Customer
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- /members online -->
                                        </div>


                                        
                                    </div>


                                </div>
                                
                            </div>
                            <!-- /traffic sources -->

                        </div>

                    </div>
                    <!-- /main charts -->



                     <!-- Footer -->
                    <?php $this->load->view('common/footer'); ?>
                    <!-- /footer -->

                </div>
                


                   

                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->

</body>
</html>
<script type="text/javascript">
  /* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - lines
 *
 *  Google Visualization line chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleLineBasic = function() {


    //
    // Setup module components
    //

    // Line chart
    var _googleLineBasic = function() {
        if (typeof google == 'undefined') {
            console.warn('Warning - Google Charts library is not loaded.');
            return;
        }

        google.charts.load('current', {'packages':['bar']});

        // Initialize chart
        google.charts.load('current', {
            callback: function () {

                // Draw chart
                drawLineChart();

                // Resize on sidebar width change
                $(document).on('click', '.sidebar-control', drawLineChart);

                // Resize on window resize
                var resizeLineBasic;
                $(window).on('resize', function() {
                    clearTimeout(resizeLineBasic);
                    resizeLineBasic = setTimeout(function () {
                        drawLineChart();
                    }, 200);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawLineChart() {

            // Define charts element
            var line_chart_element_1 = document.getElementById('google-line-question-1');

            var line_chart_element_2 = document.getElementById('google-line-question-2');
            
            // Data
            var data_1 = google.visualization.arrayToDataTable([
                ['Date', 'Sales'],

                <?php 
                $i = 0;
                foreach($order as $row){

                   echo "['".$row['created_at']."',
                          ".$row['final_total']."],";
                }
                ?>
            ]);

            var data_2 = google.visualization.arrayToDataTable([
                ['Date', 'No of Enquiry'],

                <?php 
                $i = 0;
                foreach($enquiry as $row){

                   echo "['".$row['created_at']."',
                          ".$row['final_count']."],";
                }
                ?>
            ]);

            // Options
            var options = {
                fontName: 'Roboto',
                height: 400,
                curveType: 'function',
                fontSize: 12,
                chartArea: {
                    left: '5%',
                    width: '94%',
                    height: 350
                },
                pointSize: 4,
                tooltip: {
                    textStyle: {
                        fontName: 'Roboto',
                        fontSize: 13
                    }
                },
                vAxis: {
                    title: 'Sales in Rs',
                    titleTextStyle: {
                        fontSize: 13,
                        italic: false
                    },
                    gridlines:{
                        color: '#e5e5e5',
                        count: 10
                    },
                    minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxis: { 
                        ticks: [0,1000,2000,3000,4000,5000]
                    }
            };


            //coulmn options

            // // Options
            // var coloptions = {
  
                
            //     legend: { position: 'top', maxLines: 3 },
            //     bar: { groupWidth: '25%' },
            //     isStacked: true,
            //     tooltip: {
            //         textStyle: {
            //             fontName: 'Roboto',
            //             fontSize: 13
            //         }
            //     },
            //     hAxis:{
            //       title : 'Answer',
            //     },
            //     vAxis: { 
            //             title : 'Number of visits',
            //             ticks: [0,100,200,300,400,500]
            //         }
            // };


            // Draw chart
            var line_chart = new google.visualization.LineChart(line_chart_element_1);
            line_chart.draw(data_1, options);

            var line_chart = new google.visualization.LineChart(line_chart_element_2);
            line_chart.draw(data_2, options);

        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleLineBasic();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleLineBasic.init();



    var start = moment().subtract(7, 'days');
    var end = moment();

    function cb(start, end) {
        $('#date_picker').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#date_picker').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')]
        }
    }, cb);

</script>
