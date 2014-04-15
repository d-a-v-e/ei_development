<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
    $id = $_GET['cid'];
    $discussion_id = $_GET["id"];
    $user_id = $_SESSION['userid'];

    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company FROM campaigns WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);

    $sql = "SELECT a.subject, DATE_FORMAT(a.`datecreated`, '%d/%m/%Y') AS date, DATE_FORMAT(a.`datecreated`,'%H:%i') AS time,  b.firstname, b.lastname FROM discussions AS a "
             . " JOIN users AS b ON b.id = a.discussion_creator_id"
             . " WHERE a.id = {$discussion_id} AND a.recordstatus = 1";
    $data = mysqli_query($connection, $sql) or die();
    $disc = mysqli_fetch_row($data);

    $sql = "SELECT a.`response`, DATE_FORMAT(a.`datecreated`, '%d/%m/%Y') AS date, DATE_FORMAT(a.`datecreated`,'%H:%i') AS time, u.firstname, u.lastname, a.id FROM discussion_responses AS a JOIN users AS u ON a.`contributer_id` = u.id WHERE discussion_id = {$discussion_id} AND a.recordstatus = 1 ORDER BY a.datecreated";
    $dat = mysqli_query($connection, $sql) or die();

    if (isset($_POST['submit'])) {
        $query  = "INSERT INTO discussion_responses SET ";
        $query .= " campaignid = {$id}, ";
        $query .= " discussion_id = {$discussion_id}, ";
        $query .= " contributer_id = {$user_id}, ";
        $query .= " response = '{$_POST['response']}', ";
        $query .= " recordstatus = 1, ";
        $query .= " datecreated = NOW()";
        mysqli_query($connection, $query);

        $insid = mysqli_insert_id($connection);
        $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Response to \"{$disc[0]}\"', actionid = 4, identifier = '{$_POST['response']}', identifierid = {$insid}, recordstatus = 1, datecreated = NOW()";
        mysqli_query($connection, $query);

        header("Location: discussion.php?cid={$id}&id={$discussion_id}");
    }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Inbox Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Discussion</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id ?>">Tour</a></li>
        <li><a href="discussions.php?id=<?php echo $id ?>">Discussions</a></li>
        <li>"<?php echo $disc[0]; ?>"</li>
    </ul>
    <!-- END Inbox Header -->

    <!-- Inbox Content -->
    <div class="row">
        <!-- View Message -->
        <div class="col-md-8 col-md-offset-2">
            <!-- View Message Block -->
            <div class="block full">
                <!-- View Message Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></a>
                    </div>
                    <h2><strong>Discussion</strong></h2>
                </div>
                <!-- END View Message Title -->

                <!-- Message Meta -->
                                <h2><strong>"<?php echo $disc[0]; ?>"</strong></h1>
                            Started by <strong><?php echo $disc[3] . ' ' . $disc[4]; ?></strong> on <strong><?php echo $disc[1] . ' at ' . $disc[2]; ?></strong>
                <hr>
                <?php

                    while ($inf = mysqli_fetch_row($dat)) {

                        echo
                        '
                        <div class="pull-right">
                        <div class="btn-group btn-group-xs" >
                            <a href="exe/deleteresponse.php?id=' . $discussion_id . '&rid=' . $inf[5] . '&cid=' . $id . '" class="btn btn-danger" title="Delete"><i class="fa fa-times"></i></a>
                        </div>
                        </div>
                         <p>' . $inf[0] . '</p>
                         <small>' . $inf[1] . ' at ' . $inf[2] . '</small><br><strong>' . $inf[3] . ' ' . $inf[4] . '</strong>
                         <br>
                        <hr>';

                    }

                 ?>
                 <hr>
                 <br>
                <form action="discussion.php?cid=<?php echo $id . '&id=' . $discussion_id ; ?>" method="post" class="form-horizontal form-bordered">
                    <!-- Bootstrap WYSIWYG5 (class is initialized in js/app.js -> uiInit()) -->
                    <div class="form-group">
                        <div class="col-xs-12">
                            <textarea id="textarea-wysiwyg" name="response" rows="5" class="form-control textarea-editor" required></textarea>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
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
<script src="../js/ckeditor/ckeditor.js"></script>

<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>