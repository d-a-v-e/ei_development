<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];

     $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT name, artist, company FROM campaigns WHERE id = {$id}";
                $data = mysqli_query($connection, $sql) or die();
                $info = mysqli_fetch_row($data);

    if ($m01s04 ==1) {

        $sql = "SELECT companyid, routing_promoters.date_id, routing_promoters.campaign_id\n"
        . "FROM users \n"
        . "JOIN routing_promoters on users.companyid = routing_promoters.promoter_id \n"
        . "WHERE users.id = {$userid}\n"
        . "LIMIT 1";

        $data = mysqli_query($connection, $sql) or die("No");
        $pro = mysqli_fetch_row($data);
        $pro[1] = rtrim($pro[1], ',');

        $sql = "SELECT DISTINCT routing.id, routing.city, countries.name, routing.date, routing.flexibility FROM routing_promoters, routing INNER JOIN countries on countries.code = routing.country WHERE promoter_id = {$pro[0]} AND routing.id IN ($pro[1]) AND routing.recordstatus = 1 AND routing_promoters.campaign_id = {$id} ";
    
    } else {
        $sql = "SELECT routing.id, routing.city, countries.name, routing.date, routing.flexibility\n"
        . "FROM routing\n"
        . "INNER JOIN `countries` on countries.code = routing.country\n"
        . "WHERE campaign_id = {$id} AND recordstatus = 1 ORDER BY date ASC";
    }       
        $dates = mysqli_query($connection, $sql) or die();

    $sql = "SELECT COUNT(id) FROM routing WHERE campaign_id = {$id}";
    $inf = mysqli_query($connection, $sql) or die();    
    $datecount = mysqli_fetch_row($inf);
    $datecount = $datecount[0];

?>
<!-- Page content -->
<div id="page-content">
    <!-- Table Responsive Header -->
   <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Routing</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>"> Tour</a></li>
        <li>Routing</li>
    </ul>
    <!-- END Table Responsive Header -->

    <!-- Responsive Partial Block -->
    <div class="block">
        <!-- Responsive Partial Title -->
        <div class="block-title">
            <?php 
                if ($m01s04 == 0) {
                    echo 
                    '<div class="block-options pull-right">
                        <a href="quick_add.php?id=' . $id . '" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Quick Add (for confirmed dates only)"><i class="gi gi-flash"></i></a>
                        <a href="adddate.php?id=' . $id . '" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Add Date" data-original-title="Add date"><i class="gi gi-circle_plus"></i></a>
                        <a href="promoters.php?id=' . $id . '" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Invite Promoters" data-original-title="Add date"><i class="gi gi-envelope"></i></a>
                    </div>';
                }
            ?>
            <h2><strong>Routing</strong> <small> &bull;<a href="map.php?id=<?php echo $id ?>" > <i class="fa fa-map text-primary"></i>View Map</a></small></h2>
        </div>
        <table class="table table-vcenter table-striped">
                <?php 
                if ($datecount >= 1) {
                        echo 
                        '
                        <thead>
                            <tr>
                                <!--th style="width: 150px;" class="text-center"><i class="gi gi-user"></i></th-->
                                <th>Date</th>
                                <th>Location</th>
                                <th>Promoter</th>
                                <th class="hidden-sm hidden-xs">Flexibility</th>
                                <th style="width: 150px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
                    while ($d = mysqli_fetch_row($dates)) {
                        $val = mysqli_query($connection, "SELECT COUNT(id) FROM quotes WHERE date_id = {$d[0]} AND recordstatus = 1");
                        $quote_number= mysqli_fetch_row($val);
                        $sql = "SELECT u.firstname, u.lastname, c.name, v.name FROM quotes AS q\n"
                        . "JOIN users AS u ON q.creator_id = u.id\n"
                        . "JOIN company AS c ON u.companyid = c.id\n"
                        . "JOIN venue AS v ON q.venue_id = v.id\n"
                        . "WHERE q.date_id = {$d[0]} AND q.recordstatus = 1 AND q.accepted = 1 ";
                        $ex = mysqli_query($connection, $sql);
                        $pro = mysqli_fetch_row($ex);
                        $switcher = "info";
                        $d[3] = date("d/m/Y", strtotime($d[3]));
                                switch ($d[4]) {
                                    case "0":
                                        $d[4] = "None" ;
                                        break;
                                    case "1":
                                        $d[4] = "1 Day" ;
                                        break;
                                    case "2":
                                        $d[4] = "3 Days" ;
                                        break;
                                    case "3":
                                        $d[4] = "1 Week" ;
                                        break;
                                    case "4":
                                        $d[4] = "2 Weeks" ;
                                        break;
                                    default:
                                        $d[4] = "None" ;
                                        break;
                                }
                            if ($pro) {
                                $promoter = $pro[0] . ' ' . $pro[1] . ' (' . $pro[2] . ')' ;
                                $venue = $pro[3] . ' - ';
                                $d[4] = "Confirmed";
                                $switcher = "success";
                            } else {
                                $promoter = "";
                                $venue = "";
                            }
                        echo 
                            '<tr>
                                <td>' . $d[3] . '</td>
                                <td>'. $venue . $d[1] . ', ' . $d[2] . '</td>
                                <td class="hidden-xs">' . $promoter  . '</td>
                                <td class="hidden-sm hidden-xs"><span class="label label-' . $switcher . '">' . $d[4] . '</span></td>
                                <td class="text-center">
                                <div class="btn-group btn-group-xs">';
                        
                        if ($m01s04 == 0) {
                        echo
                                        '<a href="quotes.php?id=' . $id . '&did=' . $d[0] . '" data-toggle="tooltip" title="View Quotes" class="btn btn-default"><i class="gi gi-chat"></i>(' . $quote_number[0] . ')</a>
                                        <a href="edate.php?id=' . $id . '&did=' . $d[0] . '" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="exe/delete_date.php?id=' . $id . '&did=' . $d[0] . '" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                        } else {
                        echo
                                        '<a href="quotes.php?id=' . $id . '&did=' . $d[0] . '" data-toggle="tooltip" title="Add/View Quotes" class="btn btn-default"><i class="gi gi-circle_plus"></i></a>';
                        }
                            '</div>
                        </td>
                    </tr>';
                    }
                } else {
                    echo '<h4>No Dates Yet</h4><p><a href="adddate.php?id=' . $id . '">Add</a></p>';
                }
                ?>
            </tbody>
        </table>

        <!-- END Responsive Partial Content -->
    </div>
    <!-- END Responsive Partial Block -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>