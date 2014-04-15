<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
    $id = $_GET['id'];

    $sql = "SELECT c.name, c.artist, c.company, l.name, l.id FROM campaigns AS c \n"
    . "JOIN lists AS l ON c.thumbnail = l.id\n"
    . "WHERE l.listid = 7 AND c.id = {$id}";
        $data = mysqli_query($connection, $sql);
        $info = mysqli_fetch_array($data);

     $tag1 = '';
     $tag2 = '';
     switch ($id) {
        case 28:
             $tag1 = 'bar';
             $title = 'Sales Distribution by Venue';
             break;
        case 29:
             $tag1 = 'bar';
             $title = 'Sales Distribution by Venue';
             break;
        case 30:
             $tag1 = 'line';
             $title = 'Annual Sales Figures';
             break;
        case 31:
             $tag1 = 'gender-stacked-chart';
             $tag2 = 'gender-pie-chart';
             $title = 'Gender Distribution';
             break;
     }
?>

<!-- Page content -->
<div id="page-content">
    <!-- Charts Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong><?php echo $info[1] ?></strong><br><?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Reports</li>
    </ul>
    <!-- END Charts Header -->

    <!-- Classic and Bars Chart -->
    <?php 
    if ($id == 28 || $id == 29) {
        echo
    '<div class="row">
        <div class="col-sm-12">
            <div class="block full">
                <div class="block-title">
                    <h2><strong>' . $title . '</strong> - ' . $info[1] . ': ' . $info[0] . '</h2>
                </div>
                <div id="' . $tag1 . '" class="chart"></div>
            </div>
        </div>
    </div>';
    } elseif ($id == 30) {
        echo
        '<div class="row">
        <div class="col-sm-6">
            <div class="block full">
                <div class="block-title">
                    <h2><strong>' . $title . '</strong> - ' . $info[1] . ': ' . $info[0] . '</h2>
                </div>
                <div id="' . $tag1 . '" class="chart"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <!-- Bars Chart Block -->
            <div class="block full">
                <!-- Bars Chart Title -->
                <div class="block-title">
                    <h2><strong>Total Number of Sales</strong> accumulated over time</h2>
                </div>
                <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
                <div id="placeholder" class="chart" style = "height:250px"></div>
                <!-- END Bars Chart Content -->
            </div>
            <div class="block full">
                <div class="block-title">
                    <h2><strong>Select Region</strong> to view on graph above</h2>
                </div>
                <div id="overview" class="chart" style = "height:150px"></div>
        </div>
    </div>';
    } else {
        echo 
    '<div class="row">
            <div class="col-sm-8">
                <div class="block full">
                    <div class="block-title">
                        <h2>Stacked - <strong>' . $title . ' </strong></h2>
                    </div>
                    <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
                    <div id="gender-stacked-chart" class="chart"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block full">
                    <div class="block-title">
                        <h2>Pie - <strong>' . $title . ' </strong></h2>
                    </div>
                    <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
                    <div id="gender-pie-chart" class="chart"></div>
                </div>
            </div>
        </div>';
        }
    ?>
</div>
</div>
<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<script src="../js/reporting/script.js"></script>
<script src="../js/reporting/zoom.js"></script>
<script src="http://www.flotcharts.org/flot/jquery.flot.selection.js"></script>
<script>$(function(){ ZoomChart.init(<?php echo $id; ?>); });</script>
<script>$(function(){ LineCharts.init(<?php echo $id; ?>); });</script>
<script>$(function(){ BarCharts.init(<?php echo $id; ?>); });</script>
<script>$(function(){ GenderCharts.init(<?php echo $id; ?>); });</script>
<?php include 'inc/template_end.php'; ?>