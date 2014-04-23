<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $date_id = $_GET["did"];
    $userid = $_SESSION['userid'];

     $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company, requirements.* \n"
    . "FROM campaigns\n"
    . "JOIN requirements \n"
    . "ON campaigns.id = requirements.campaign_id WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);
               if (!empty($info)) {
        switch ($info[6]) {
            case "":
                $info[6] = " - " ;
                break;
            case "0000-00-00":
                $info[6] = " - " ;
                break;
            default:
                $date = strtotime($info[6]);
                $info[6] = date('d/m/Y', $date);
                break;
        }
        switch ($info[7]) {
            case "":
                $info[7] = " - " ;
                break;
            case "0000-00-00":
                $info[7] = " - " ;
                break;
            default:
                $date = strtotime($info[7]);
                $info[7] = date('d/m/Y', $date);
                break;
        }
    }
   
    $sql = "SELECT users.firstname, users.lastname, company.name, venue.name, quotes.date, quotes.capacity, quotes.face_value, quotes.guarantee, quotes.id, quotes.recordstatus, quotes.accepted, venue.id, quotes.datecreated, cast(quotes.datecreated as time), users.id \n"
    . "FROM quotes\n"
    . "JOIN venue ON quotes.venue_id = venue.id\n"
    . "JOIN users ON quotes.creator_id = users.id\n"
    . "JOIN company ON users.companyid = company.id\n"
    . "WHERE quotes.date_id = {$date_id} AND quotes.recordstatus = 1 ORDER BY company.name ";
    $quotes = mysqli_query($connection, $sql) or die();

    $sql = "SELECT city, countries.name, date, flexibility " 
     . " FROM routing "
     . " LEFT JOIN countries on routing.country = countries.code "
     . " WHERE id = {$date_id} ";

        $data = mysqli_query($connection, $sql) or die(mysql_error());
        $reqs = mysqli_fetch_row($data);
        $date = $reqs[2];
        $reqs[2] = date("d/m/Y", strtotime($date));

                            switch ($reqs[3]) {
                                case "0":
                                    $reqs[3] = "None" ;
                                    break;
                                case "1":
                                    $reqs[3] = "1 Day" ;
                                    break;
                                case "2":
                                    $reqs[3] = "3 Days" ;
                                    break;
                                case "3":
                                    $reqs[3] = "1 Week" ;
                                    break;
                                case "4":
                                    $reqs[3] = "2 Weeks" ;
                                    break;
                                default:
                                    $reqs[3] = "None" ;
                                    break;
                            }

        $seeq = mysqli_query($connection, "SELECT COUNT(id) FROM quotes WHERE date_id = {$date_id}");
        $count = mysqli_fetch_row($seeq);
        $count = $count[0];
?>
<!-- Page content -->
<div id="page-content">
    <!-- Table Responsive Header -->
   <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Quotes</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>"> Tour</a></li>
        <li><a href="routing.php?id=<?php echo $id; ?>"> Routing</a></li>
        <li>Quotes</li>
    </ul>
    <!-- END Table Responsive Header -->

    <div class="row">
            <div class="col-md-6 col-lg-7">
                <!-- Reqs Block -->
            <div class="block">
                <!-- Reqs Title -->
                <div class="block-title">
                    <h2><strong>Requirements</strong> <small>&bull; <a href="javascript:void(0)" data-toggle="tooltip" title="Download requirements PDF"> <i class="fa fa-file-text text-primary"></i> PDF</a></small></h2>
                </div>
                <!-- END Info Title -->

                <!-- Info Content -->
                <table class="table table-borderless table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Timeframe: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[6] ?></strong> to <strong><?php echo $info[7] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Avg. Capacity: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[8] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><strong>Region: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[9] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Base Currency: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[10] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Avg. Face Value: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[11] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Seating: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[13] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Guarantee: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[12] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"><strong>Notes</strong></td>
                            <td><?php echo $info[14] ?></td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Requirements Content -->
            </div>
            <!-- END Requirements Block -->
        </div>
        <div class="col-lg-5 col-md-6">
        <!-- Block with Options Left -->
            <div class="block">
                <!-- Block with Options Left Title -->
                <div class="block-title clearfix">
                    <h2 class="pull-right"><small><a href="javascript:void(0)" data-toggle="tooltip" title="Download requirements PDF"> <i class="fa fa-file-text text-primary"></i> PDF</a></small> &bull; <strong>Tender</strong> Request</h2>
                </div>
                <!-- END Block with Options Left Title -->

                <!-- Block with Options Left Content -->
                <!-- Info Content -->
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Location: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $reqs[0] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Country: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $reqs[1] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Timeframe: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $reqs[2] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Flexibility: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $reqs[3] ?></strong></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Requirements Content -->
                <!-- END Block with Options Left Content -->
            </div>
            <!-- END Block with Options Left -->
        </div>
    </div>

    <!-- Responsive Partial Block -->
    <div class="block">
        <!-- Responsive Partial Title -->
        <div class="block-title">
            <h2><strong>Quotes</strong></h2>
        </div>
        <!-- END Responsive Partial Title -->
        <div class="table-responsive">
        <!-- Responsive Partial Content -->
        <table class="table table-vcenter table-striped table-responsive">
            <thead>
                <tr>
                    <?php
                if ($count >= 1) {
                    if ($m01s04 == 0) {
                        echo 
                        '<th style="width: 150px;"><i class="gi gi-user"></i></th>';
                    }
                        echo 
                               '<th>Date</th>
                                <th>Venue</th>
                                <th>Guarantee</th>
                                <th>Capacity</th>
                                <th><i class="fa fa-ticket"></i> <small>(Min)</small></th>
                                <th><i class="fa fa-ticket"></i> <small>(Max)</small></th>
                                <th style="width: 150px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';

                    while ($d = mysqli_fetch_row($quotes)) {
                        if ($m01s04 == 0) {
                        $val = mysqli_query($connection, "SELECT COUNT(id) FROM quote_discussions WHERE quote_id = {$d[8]} AND recordstatus = 1");
                        $discussions = mysqli_fetch_row($val);
                        $val = mysqli_query($connection, "SELECT SUM(qp.capacity) AS cap, MIN(qp.min_price) AS min, MAX(qp.max_price) AS max  FROM quote_pricing AS qp RIGHT JOIN quotes AS q ON q.id = qp.quote_id WHERE q.id = {$d[8]}");
                        $pricing = mysqli_fetch_row($val);
                        
                        $d[4] = date("d/m/Y", strtotime($d[4]));

                            echo '<tr class=';
                                        if ($d[10] == 2) {
                                            echo '"danger"';
                                        } elseif ($d[10] == 1) {
                                            echo '"success"';
                                        }
                            echo '>';
                            if ($m01s04 == 0) {
                            echo
                                '<td>' . $d[0] . ' ' . $d[1] . ' (' . $d[2] . ')</td>';
                            }
                            echo 
                                '<td>' . $d[4] . '</td>
                                <td>' . $d[3] . '</td>
                                <td>' . $d[7] . '</td>
                                <td class="text-center">' . $pricing[0] . '</td>
                                <td class="text-center">' . $pricing[1] . '</td>
                                <td class="text-center">' . $pricing[2] . '</td>
                                <td class="text-center" style="width: 150px;">
                                    <div class="btn-group btn-group-xs">';
                                        // if promoter or not...
                                        if ($m01s04 == 0) {
                                            echo
                                            '<a href="qdiscuss.php?id=' . $id . '&did=' . $date_id . '&qid=' . $d[8] . '" data-toggle="tooltip" title="View Discussions" class="btn btn-default"><i class="gi gi-chat"></i>(' . $discussions[0] . ')</a>';
                                            if ($d[10] == 1) {
                                                echo '<a href="exe/decline_quote.php?id=' . $id . '&did=' . $date_id . '&qid=' . $d[8] . '" data-toggle="tooltip" title="Decline" class="btn btn-warning"><i class="gi gi-minus"></i></a></div>';
                                            } elseif ($d[10] == 2) {
                                            echo '<span class="btn btn-disabled"><i class="fa fa-check"></i></span></div>';
                                            } else {
                                                echo '<a href="exe/accept_quote.php?id=' . $id . '&did=' . $date_id . '&qid=' . $d[8] . '" data-toggle="tooltip" title="Accept" class="btn btn-success"><i class="fa fa-check"></i></a></div>';
                                            }
                                        } else {
                                            echo
                                            '<a href="qdiscuss.php?id=' . $id . '&did=' . $date_id . '&qid=' . $d[8] . '" data-toggle="tooltip" title="View Discussions" class="btn btn-default"><i class="gi gi-chat"></i>(' . $discussions[0] . ')</a></div>';
                                            }
                                             if ($d[14] !== $userid) { // RESET THIS!!
                                                echo ' <div class="btn-group btn-group-xs">';
                                                echo '<a href="edit_quote.php?id=' . $id . '&did=' . $date_id . '&qid=' . $d[8] . '" data-toggle="tooltip" title="Edit" class="btn btn-info"><i class="fa fa-pencil"></i></a>';
                                                echo '<a href="exe/delete_quote.php?id=' . $id . '&did=' . $date_id . '&qid=' . $d[8] . '" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-times"></i></a>';
                                                echo '</div>';
                                            }

                                        }
                                    }
                            echo     
                                '</td>
                                <tr>
                                    <td colspan="100">
                                    <div class="btn-group btn-group-sm pull-right">
                                        <a href="addquote.php?id=' . $id . '&did=' . $date_id . '" data-toggle="tooltip" title="New Quote" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                    </div>
                                    </td>
                                </tr>
                            </tr>';
                    } else {
                        echo '<h4>No Quotes Yet</h4><p>';
                            echo '<a href="addquote.php?id=' . $id . '&did=' . $date_id . '"> Add Quote</a></p>';
                    }
                ?>
            </tbody>
        </table>
        </div>
        <!-- END Responsive Partial Content -->
    </div>
    <!-- END Responsive Partial Block -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>