<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
$json = file_get_contents("http://www.biota-labs.com/ei/sales/ei_return_sales_campaigns.php?clientid=1");
$data = json_decode($json, true);

?>
<?php 

    $userid = $_SESSION["userid"];

    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company, campaigns.id, campaigns.personnel, campaigns.mainpicture, requirements.start_date, requirements.end_date, requirements.id, campaigns.creatorid, campaigns.thumbnail FROM campaigns\n"
    . "JOIN requirements ON campaigns.id = requirements.campaign_id\n"
    . "WHERE personnel LIKE '%{$userid}%' AND campaigns.recordstatus = 1";
                $data = mysqli_query($connection, $sql) 
                    or die();

?>
<!-- Page content -->
<div id="page-content">
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-suitcase"></i>Tours<br><a href="tnew.php"><small> + Add new</small></a>
            </h1>
        </div>
    </div>

    <div class="row">
            <!-- Advanced Animated Image Widget Alternative -->
            <?php
                while ($row = mysqli_fetch_array($data)) {
                      
                    $personnel = sizeof(explode(",", $row[4]));
                    if (!empty($row[6])) {
                        $row[6] = date("d/m/Y", strtotime($row[6]));
                    } else {
                        $row[6] = "<small>(None)</small>";
                    }
                    if (!empty($row[7])) {
                        $row[7] = date("d/m/Y", strtotime($row[7]));
                    } else {
                        $row[7] = "<small>(None)</small>";
                    }
                    $inf = "SELECT COUNT(id) FROM routing WHERE campaign_id = {$row[3]} AND recordstatus = 1 ";
                    $dat = mysqli_query($connection, $inf);
                    $routing = mysqli_fetch_array($dat);
                    $inf = "SELECT COUNT(id) FROM discussions WHERE campaignid = {$row[3]} AND recordstatus = 1";
                    $dat = mysqli_query($connection, $inf);
                    $discussions = mysqli_fetch_array($dat);

            echo '
            <div class="col-md-4">
                <div class="widget">
                    <div class="widget-advanced widget-advanced-alt">
                        <div class="widget-header text-center themed-background-dark">
                        <div class="widget-options">';

                        if ($row[9] == $userid) {
                        echo
                            '<div class="btn-group btn-group-xs">
                                 <a href="tedit.php?id=' . $row[3] . '" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit Details"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-xs btn-default" data-toggle="tooltip" title="Invite Personnel"><i class="hi hi-user text-success"></i></button>
                            </div>';
                        }
                        echo
                        '</div>
                         <h3 class="widget-content widget-content-light clearfix">
                                <a href="tour.php?id=' . $row[3] . '" class="pull-right">    
                                </a>
                                <a href="tour.php?id=' . $row[3] . '" class="themed-color-flatie">' . $row[1] . '</a><br>
                                <small>' . $row[0] . ' <br>(' . $row[2] . ')</small>
                            </h3>
                    </div>
                        <div class="widget-main">
                            <div class="list-group remove-margin">
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[6] . '</strong> to <strong>' . $row[7] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="fa fa-calendar fa-fw"></i> Dates</h4>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $personnel . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="fa fa-users fa-fw"></i> Personnel</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $routing[0] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="fa fa-map-marker fa-fw"></i> Routing</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $discussions[0] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="fa fa-comment fa-fw"></i> Discussions</h4>
                                    <p class="list-group-item-text"></p>
                                </div>';
                                if (!empty($row[10])) {
                                echo
                                '<div class="list-group-item">
                                    <a href="report.php?id=' . $row[3] . '" class="pull-right"><strong><i class="gi gi-plus fa-fw"></i></strong></a>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-charts fa-fw"></i> Reports</h4>
                                </div>';
                                } else {
                                    echo
                                '<div class="list-group-item">
                                    <span class="pull-right"><strong><i class="gi gi-plus "></i></strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-charts fa-fw"></i> Reports</h4>
                                </div>';
                                }
                            echo
                            '</div>
                        </div>
                    </div>
                </div>
            </div>';
                }
            ?>
    </div>
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>