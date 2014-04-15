<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
    $id = $_GET["id"];
    //$date_id = $_GET["did"];
    $userid = $_SESSION['userid'];
    $_SESSION['message'] = '';

    $sql = "SELECT name, artist, company FROM campaigns WHERE id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die(mysql_error());
                $info = mysqli_fetch_row($data);

$sql = "SELECT city, date, id FROM routing WHERE campaign_id = {$id} AND recordstatus = 1";
                $data = mysqli_query($connection, $sql) 
                    or die(mysql_error());


 $queery = "SELECT routing_promoters.id, routing_promoters.invited, routing_promoters.date_id, routing_promoters.promoter_id, company.name, users.firstname, users.lastname \n"
    . "FROM routing_promoters \n"
    . "JOIN `company` on company.id = routing_promoters.promoter_id \n"
    . "JOIN users ON users.companyid = company.id\n"
    . "WHERE campaign_id = {$id}";
                $promoters = mysqli_query($connection, $queery) 
                    or die(mysql_error());
    
?>

<!-- Page content -->
<div id="page-content">
    <!-- Table Styles Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1>Invite<strong> Promoters</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>">Tour</a></li>
        <li><a href="routing.php?id=<?php echo $id; ?>">Routing</a></li>
        <li>Promoters</li>
    </ul>
    <div class="block">
        <div class="block-title">
            <h2><strong>Invite</strong> Promoters</h2>
        </div>
          <div  class="table-responsive" style="overflow-x: scroll;">
          <?php if (!empty($_SESSION['message'])) {
        echo
        '<div class="alert alert-' . $_SESSION['alert'] . ' alert-dismissable col-md-3 col-sm-3 col-xs-3">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-exclamation-circle"></i><p>' . $_SESSION['message'] . '</p>
        </div>';
            $_SESSION['message'] = '';
        }
          ?>
            <table class="table table-condensed table-borderless">
                            <thead>
                            <tr>
                            <th></th>
                                <?php 
                                    while ($dates = mysqli_fetch_row($data)) {
                                        echo "<th style='font-size: 16px;'><small>" . $dates[0] . "</small></th>" ;
                                    $datearray[] = $dates[2];
                                    }
                                ?>
                                <th></th><!--top row white space for 'save' buttons-->
                            </tr>
                            </thead>
                            <?php
                             
                             while ($pro = mysqli_fetch_row($promoters)) {
                                $dids = explode(",", $pro[2]);
                                echo "<tr><td width='20%'>". $pro[4] . " (" . $pro[5] . " " . $pro[6] . ")</td>";
                                for ($i=0; $i < sizeof($datearray); $i++) {
                                        echo "<form action='exe/save_promoters.php?id=" . $pro[3] . "' method='post' class='form'><td><input type='checkbox' value='1' name=" . $datearray[$i] ;
                                        if (in_array($datearray[$i], $dids)) { echo " checked='checked' "; }
                                        if (!is_null($pro[1])) { echo " disabled "; }
                                        echo "></td>" ;
                                    }
                                if (is_null($pro[1])) { echo '<td><input class="form-control" value="' . $id . '" name="campaign_id" type="hidden"></input><input type="submit" name="submit" class="submitForm btn btn-primary btn-sm" role="button" value="Set"></input>  <a class="btn btn-sm btn-danger" href=exe/remove_promoter.php?pid=' . $pro[0] . '&id=' . $id . ' ><span class="gi gi-remove"></span></a></form></td></tr>'; }
                                else { echo '<td><span class="label label-success"><i class="fa fa-envelope"></i> Invites Sent</span></form></td></tr>'; }
                                }
                            ?>
                        <tfoot>
                            <tr>
                                <td colspan="100">
                                    <div class="btn-group btn-group-sm">
                                        <a href="plookup.php?id=<?php echo $id; ?>" class="btn btn-primary" data-toggle="tooltip" title="Add"><i class="fa fa-plus"></i></a>
                                        <a href="exe/invite_promoter.php?id=<?php echo $id . "&uid=" . $userid ; ?>" class="btn btn-primary" data-toggle="tooltip" title="Send Invites"><i class="gi gi-envelope"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                        </table>
                        </div>
        <!-- END Row Styles Content -->
    </div>
    <!-- END Row Styles Block -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/tablesGeneral.js"></script>
<script>$(function(){ TablesGeneral.init(); });</script>
<?php include 'inc/template_end.php'; ?>