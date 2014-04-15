<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php 
$json = file_get_contents("http://www.biota-labs.com/ei/sales/ei_return_sales_campaigns.php?clientid=1");
$data = json_decode($json, true);

?>
<?php 

    $userid = $_SESSION["userid"];

    $sql = "SELECT * FROM campaigns WHERE thumbnail IS NOT NULL";
                $data = mysqli_query($connection, $sql) 
                    or die();

?>
<!-- Page content -->
<div id="page-content">
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-charts"></i>Reports</a>
            </h1>
        </div>
    </div>

    <div class="row">
            <!-- Advanced Animated Image Widget Alternative -->
            <?php
                while ($row = mysqli_fetch_array($data)) {
                    echo 
                        '<div class="col-sm-6 col-md-4">
                        <div class="widget">
                            <div class="widget-simple">
                            <h3><strong>' . $row[3] . '</strong></h3><h4> ' . $row[2] . '</h4><br> ' . $row[4] . ' 
                                <a href="reports.php?id=' . $row[0] . '" class="widget-icon pull-right themed-background">
                                    <i class="gi gi-stats"></i>
                                </a>
                                <h3 class="animation-stretchLeft">';
                                switch ($row[6]) {
                                    case 1:
                                        $row[6] = ""
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                }

                                echo '</h3>
                            </div>
                        </div>
                    </div>';
                }
            ?>
    </div>
</div>
<!-- END Page Content -->
<?php include '../tours/inc/page_footer.php'; ?>
<?php include '../tours/inc/template_scripts.php'; ?>
<?php include '../tours/inc/template_end.php'; ?>