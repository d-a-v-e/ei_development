<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
     $id = $_GET['id'];

     $tag1 = '';
     $tag2 = '';
     switch ($id) {
        case 28:
             $tag1 = 'bar';
             break;
        case 29:
             $tag1 = 'bar';
             break;
        case 30:
             $tag1 = 'line';
             break;
        case 31:
             $tag1 = 'gender-stacked-chart';
             $tag2 = 'gender-pie-chart';
             break;
     }
?>

<!-- Page content -->
<div id="page-content">
    <!-- Charts Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-pie_chart"></i>Reporting
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Reporting</li>
    </ul>
    <!-- END Charts Header -->

    <!-- Classic and Bars Chart -->
    <?php 
    if ($id == 28 || $id == 29 || $id == 30) {
        echo
    '<div class="row">
        <div class="col-sm-12">
            <div class="block full">
                <div class="block-title">
                    <h2> Chart</h2>
                </div>
                <div id="' . $tag1 . '" class="chart"></div>
            </div>
        </div>
    </div>';
    } else {
        echo 
    '<div class="row">
            <div class="col-sm-8">
                <div class="block full">
                    <div class="block-title">
                        <h2><strong>Gender</strong> stacked sales chart</h2>
                    </div>
                    <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
                    <div id="gender-stacked-chart" class="chart"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block full">
                    <div class="block-title">
                        <h2><strong>Gender</strong> stacked sales chart</h2>
                    </div>
                    <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
                    <div id="gender-pie-chart" class="chart"></div>
                </div>
            </div>
        </div>';
        }
    ?>

</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/reporting/script.js"></script>
<script>$(function(){ LineCharts.init(<?php echo $id; ?>); });</script>
<script>$(function(){ BarCharts.init(<?php echo $id; ?>); });</script>
<?php include 'inc/template_end.php'; ?>