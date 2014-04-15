<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $date_id = $_GET["did"];
    $quote_id = $_GET["qid"];
    $userid = $_SESSION['userid'];


    if (isset($_POST['submit'])) {

    $query  = "INSERT INTO quote_discussions SET  ";
    $query .= "date_id = '{$date_id}', ";
    $query .= "quote_id = '{$quote_id}', ";
    $query .= "user_id = '{$userid}', ";
    $query .= "response = '{$_POST['response']}', ";
    $query .= "recordstatus = '1', datecreated = NOW() ";
        
        $result = mysqli_query($connection, $query) or die ("nope");
        $quid = mysqli_insert_id($connection);
        if ($result && mysqli_affected_rows($connection) >= 0) {
            // Success
            $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Response to Quote', actionid = 7, identifier = '{$_POST['response']}', identifierid = {$quid}, recordstatus = 1, datecreated = NOW()";
            mysqli_query($connection, $query);
            $_SESSION["message"] = "Comment posted.";
            header("Location: qdiscuss.php?id={$id}&did={$date_id}&qid={$quote_id}");
        } else {
            // Failure
            $message = "Comment post failed.";
        }
        
    }


     $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company, requirements.* \n"
    . "FROM campaigns\n"
    . "JOIN requirements \n"
    . "ON campaigns.id = requirements.campaign_id WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);

    $sql = "SELECT users.firstname, users.lastname, company.name, venue.name, quotes.date, quotes.capacity, quotes.face_value, quotes.guarantee, quotes.id, quotes.recordstatus, quotes.accepted, venue.id, quotes.datecreated, cast(quotes.datecreated as time) FROM quotes \n"
    . "JOIN venue ON quotes.venue_id = venue.id \n"
    . "JOIN users ON quotes.creator_id = users.id \n"
    . "JOIN company ON users.companyid = company.id WHERE quotes.id = {$quote_id} AND quotes.recordstatus = 1 ";
    $quotes = mysqli_query($connection, $sql) or die();
    $d = mysqli_fetch_row($quotes);
        $date = $d[4];
        $d[4] = date("d/m/Y", strtotime($date));

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
    $sql = "SELECT quote_discussions.response, quote_discussions.datecreated, users.firstname, users.lastname, cast(quote_discussions.datecreated as time) FROM quote_discussions JOIN users ON quote_discussions.user_id = users.id WHERE quote_discussions.quote_id = {$quote_id} AND quote_discussions.recordstatus = 1  ";
    $in = mysqli_query($connection, $sql) or die(mysql_error());

?>
<!-- Page content -->
<div id="page-content">
        <!-- Header -->
   <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Discuss</strong> Quotes</h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>"> Tour</a></li>
        <li><a href="routing.php?id=<?php echo $id; ?>"> Routing</a></li>
        <li><a href="quotes.php?id=<?php echo $id . '&did=' . $date_id ; ?>"> Quotes</a></li>
        <li>Discuss Quotes</li>
    </ul>
    <!-- END Header -->

    <!-- Inbox Content -->
    <div class="row">
        <!-- Inbox Menu -->
        <div class="col-sm-4 col-lg-4">

              <!-- Reqs Block -->
            <div class="block">
                <!-- Reqs Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </div>
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
                            <td><strong>Region: </strong></td>
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

            <!-- Tags Block -->
            <div class="block full">
                <!-- Tags Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Add Tag"><i class="fa fa-plus"></i></a>
                    </div>
                    <h2> <i class="fa fa-tags"></i> User <strong>Tags</strong></h2>
                </div>
                <!-- END Tags Title -->

                <!-- Tags Content -->
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">1680</span>
                            <i class="fa fa-tag fa-fw text-success"></i> <strong>Work</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">350</span>
                            <i class="fa fa-tag fa-fw text-warning"></i> <strong>Friends</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">651</span>
                            <i class="fa fa-tag fa-fw text-danger"></i> <strong>Projects</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">156</span>
                            <i class="fa fa-tag fa-fw text-info"></i> <strong>For Later</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">296</span>
                            <i class="fa fa-tag fa-fw text-muted"></i> <strong>Sites</strong>
                        </a>
                    </li>
                </ul>
                <!-- END Tags Content -->
            </div>
            <!-- END Tags Block -->
        </div>
        <!-- END Inbox Menu -->

        <!-- View Message -->
        <div class="col-sm-8 col-lg-8">
        <!-- Responsive Partial Block -->
    <div class="block">
        <!-- Responsive Partial Title -->
        <div class="block-title">
            <h2><strong>Quote</strong></h2>
        </div>
        <!-- END Responsive Partial Title -->
        <div class="table-responsive">
        <!-- Responsive Partial Content -->
        <table class="table table-vcenter table-striped table-responsive">
            <thead>
                <tr>
                    <th><i class="gi gi-user"></i></th>
                    <th>Company</th>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Capacity</th>
                    <th>Face Value</th>
                    <th>Guarantee</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo 
                            '<tr>
                                <td>' . $d[0] . ' ' . $d[1] . '</td>
                                <td>' . $d[2] . '</td>
                                <td>' . $d[3] . '</td>
                                <td>' . $d[4] . '</td>
                                <td>' . $d[5] . '</td>
                                <td>' . $d[6] . '</td>
                                <td>' . $d[7] . '</td>
                            </tr>';
                ?>
            </tbody>
        </table>
        </div>
        <!-- END Responsive Partial Content -->
    </div>
    <!-- END Responsive Partial Block -->
            <!-- View Message Block -->
            <div class="block full">
                <!-- View Message Title -->
                <div class="block-title">
                    <h2><strong>Discussion</strong> <small><span class="label label-success">Quote</span></small></h2>
                </div>
                <!-- END View Message Title -->

                <!-- Message Meta -->
                <table class="table table-borderless table-vcenter remove-margin">
                    <tbody>
                        <tr>
                            <td class="text-center" style="width: 80px;">
                                <!--a href="page_ready_user_profile.php" class="pull-left">
                                    <img src="img/placeholders/avatars/avatar<?php echo rand(1, 16); ?>.jpg" alt="Avatar" class="img-circle">
                                </a-->
                            </td>
                            <td class="hidden-xs">
                            Discussion with 
                                <a><strong><?php echo $d[0] . ' ' . $d[1] ; ?></strong></a>
                            </td>
                            <td class="text-right">Quote made on <strong><?php echo date("d/m/Y", strtotime($d[12])) . ' at ' . $d[13] ; ?></strong></td>
                        </tr>
                </table>
                <hr>
                <!-- END Message Meta -->
                <?php                           
                    while ($inf = mysqli_fetch_row($in)) {
                        $inf[1] = date("d/m/Y", strtotime($inf[1]));
                        //echo "<p>" . $inf[2] . "<span style='float:right; color:gray;'>" . $inf[0] . " " . $inf[1] . "<b><small> " . $date . "</span></small></b></p>" ;
                        echo 
                            '<p>' . $inf[0] . '</p>
                            <p class="pull-right"><small>' . $inf[2] . ' ' . $inf[3] . '</small> <strong>' . $inf[1] . '</strong> at ' . $inf[4] . '</p>
                            ';
                    }
                ?>
                <!-- Quick Reply Form -->
                <form action="qdiscuss.php?id=<?php echo $id . '&did=' . $date_id . '&qid=' . $quote_id ; ?>" method="post">
                    <textarea id="message-quick-reply" name="response" rows="2" class="form-control push-bit" placeholder="Your message.."></textarea>
                    <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-share"></i> Post</button>
                </form>
                <!-- END Quick Reply Form -->
            </div>
            <!-- END View Message Block -->
        </div>
        <!-- END View Message -->
    </div>
    <!-- END Inbox Content -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>