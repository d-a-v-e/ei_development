<?php include '../tours/inc/config.php'; ?>
<?php include '../tours/inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php 

    $userid = $_SESSION["userid"];
    $sql = "SELECT p.promoidentifier, p.promoname, CAST(p.startdate AS date), CAST(p.enddate AS date), p.promooutlets, p.promocustomer, p.redemptionoutlets, p.redemptioncustomer, p.redemptionitems, l.name, p.id FROM promotions AS p \n"
    . "JOIN lists as l ON p.promotype = l.id\n"
    . "WHERE l.listid = 4 AND p.recordstatus = 1";
    $data = mysqli_query($connection, $sql) or die();
?>
<!-- Page content -->
<div id="page-content">
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="hi hi-bullhorn"></i>Campaigns<br><a href=""><small> + Add new</small></a>
            </h1>
        </div>
    </div>

    <div class="row">
            <!-- Advanced Animated Image Widget Alternative -->
            <?php
                while ($row = mysqli_fetch_array($data)) {
                    if (!empty($row[2])) {
                        $row[2] = date("d/m/Y", strtotime($row[2]));
                    } else {
                        $row[2] = "<small>(None)</small>";
                    }
                    if (!empty($row[3])) {
                        $row[3] = date("d/m/Y", strtotime($row[3]));
                    } else {
                        $row[3] = "<small>(None)</small>";
                    }
            echo '
            <div class="col-md-4">
                <div class="widget">
                    <div class="widget-advanced widget-advanced-alt">
                        <div class="widget-header text-center themed-background-dark">
                        <div class="widget-options">';
                        echo
                        '</div>
                         <h3 class="widget-content widget-content-light clearfix">
                                <a href="campaign.php?id=' . $row[10] . '" class="themed-color-flatie">' . $row[0] . '</a><br>
                                <small>' . $row[1] . ' <br>(' . $row[9] . ')</small>
                            </h3>
                    </div>
                        <div class="widget-main">
                            <div class="list-group remove-margin">
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[2] . '</strong> to <strong>' . $row[3] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="fa fa-calendar fa-fw"></i> Dates</h4>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[4] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-share_alt"></i> Outlets (Promotion)</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[6] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-share_alt"></i> Outlets (Redemption)</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[5] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-group"></i> Customers (Promotion)</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[7] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-group"></i> Customers (Redemption)</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                                <div class="list-group-item">
                                    <span class="pull-right"><strong>' . $row[8] . '</strong></span>
                                    <h4 class="list-group-item-heading remove-margin"><i class="gi gi-ok_2"></i><i class="gi gi-ok_2"></i> Total Redeemed</h4>
                                    <p class="list-group-item-text"></p>
                                </div>
                            </div>
                        </div>
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