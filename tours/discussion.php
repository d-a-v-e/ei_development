<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
    $id = $_GET['cid'];
    $discussion_id = $_GET["id"];
    $user_id = $_SESSION['userid'];

    $filepath = "../img/tours/" . $id . "/attachments/" ;

            $upload_errors = array(
                UPLOAD_ERR_OK           => "",
                UPLOAD_ERR_INI_SIZE     => "Larger than upload_max_filesize.",
                UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
                UPLOAD_ERR_PARTIAL      => "Partial upload.",
                UPLOAD_ERR_NO_FILE      => "No file.",
                UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
                UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
                UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
                );


    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company FROM campaigns WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);

    $sql = "SELECT a.subject, DATE_FORMAT(a.`datecreated`, '%D %b %y') AS date, DATE_FORMAT(a.`datecreated`,'%H:%i') AS time,  b.firstname, b.lastname FROM discussions AS a "
             . " JOIN users AS b ON b.id = a.discussion_creator_id"
             . " WHERE a.id = {$discussion_id} AND a.recordstatus = 1";
    $data = mysqli_query($connection, $sql) or die();
    $disc = mysqli_fetch_row($data);

    $sql = "SELECT a.`response`, DATE_FORMAT(a.`datecreated`, '%D %b %y') AS date, DATE_FORMAT(a.`datecreated`,'%H:%i') AS time, u.firstname, u.lastname, a.id FROM discussion_responses AS a JOIN users AS u ON a.`contributer_id` = u.id WHERE discussion_id = {$discussion_id} AND a.recordstatus = 1 ORDER BY a.datecreated";
    $dat = mysqli_query($connection, $sql) or die();

    if (isset($_POST['submit'])) {
        $query  = "INSERT INTO discussion_responses SET ";
        $query .= " campaignid = {$id}, ";
        $query .= " discussion_id = {$discussion_id}, ";
        $query .= " contributer_id = {$user_id}, ";
        $query .= " response = '{$_POST['response']}', ";
        $query .= " recordstatus = 1, ";
        $query .= " datecreated = NOW()";

        // mysqli_query($connection, $query);
        // $insid = mysqli_insert_id($connection);

        $error = $_FILES['files']['error'];
                $message = $upload_errors[$error];

                $tmp_file = $_FILES['files']['tmp_name'];
                $target_file = basename($_FILES['files']['name']);
                $ext = pathinfo($target_file, PATHINFO_EXTENSION);

                        if (!file_exists($filepath)) {
                         mkdir($filepath, 0777, true);    }

                        $upload_dir = $filepath ;

                        if (move_uploaded_file($tmp_file, $upload_dir."/".$target_file)) {
                            $message = "File uploaded succesfully.";
                            $insid = 888;
                                 $string  = "INSERT INTO attachments SET  ";
                                 $string .= "typeid = 2, identifierid = {$insid}, path = '{$target_file}', campaign_id = {$id}, ";
                                 $string .= "recordstatus = '1', datecreated = NOW() ";
                                 echo $string . "<br>";
                                 //mysqli_query($connection, $string);
                                
                            $result = mysqli_query($connection, $query) or die ();
                        } else {
                            $error = $_FILES['files']['error'];
                            $message = $upload_errors[$error];
                        }
                        echo $message;

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
    <div class="row">
        <!-- View Message -->
        <div class="col-md-8 col-md-offset-2">
            <!-- View Message Block -->
            <div class="block full">
                <!-- View Message Title -->
                <div class="block-title">
                    <h2><strong>Discussion</strong></h2>
                </div>
                    <h2><strong>"<?php echo $disc[0]; ?>"</strong></h1>
                Started by <strong><?php echo $disc[3] . ' ' . $disc[4]; ?></strong> on <strong><?php echo $disc[1] . ' at ' . $disc[2]; ?></strong>
                    <?php 
                         $sql = "SELECT * FROM attachments WHERE identifierid = {$id} AND typeid = 1 AND campaign_id = {$id}";
                         $result = mysqli_query($connection, $sql);
                         if (mysqli_num_rows($result) >= 1) {
                            echo 
                            '
                            <div class="gallery gallery-widget" data-toggle="lightbox-gallery">
                            <small><strong>Attachments: </small></strong>
                                <div class="row">';
                                while ($a = mysqli_fetch_row($result)) {
                                    $ext = pathinfo($a[1], PATHINFO_EXTENSION);
                                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'  || $ext == 'bmp') {
                                        echo
                                            '<div class="col-xs-6 col-sm-3">
                                                <a href="../img/tours/'.$id.'/attachments/'.$a[1].'" class="gallery-link" title="Image Info">
                                                    <img src="../img/tours/'.$id.'/attachments/'.$a[1].'" alt="image">
                                                </a>
                                                '.$a[1].'
                                            </div>';
                                    } else {
                                        echo
                                            '<div class="col-xs-6 col-sm-3">
                                                <a href="../img/placeholders/photos/photo5.jpg" class="gallery-link" title="Image Info">
                                                    <img src="../img/placeholders/photos/photo5.jpg" alt="image">
                                                </a>
                                                '.$a[1].'
                                            </div>';
                                    }
                                }
                            echo
                                '</div>
                            </div>';
                        }

                    ?>
                <hr>
                <?php

                    while ($inf = mysqli_fetch_row($dat)) {
                        echo
                        '
                         <div class="pull-right">
                         <small>' . $inf[1] . ' at ' . $inf[2] . '</small><br><strong>' . $inf[3] . ' ' . $inf[4] . '</strong>
                         </div>';
                         echo '<p>' . $inf[0] . '</p>';
                         $sql = "SELECT id, `path` FROM attachments WHERE identifierid = {$inf[5]} AND typeid = 2 AND campaign_id = {$id}";
                         $result = mysqli_query($connection, $sql);
                        if (mysqli_num_rows($result) >= 1) {
                            echo 
                            '
                            <div class="gallery gallery-widget" data-toggle="lightbox-gallery">
                            <small><strong>Attachments: </small></strong>
                                <div class="row">';
                                while ($a = mysqli_fetch_row($result)) {
                                    $ext = pathinfo($a[1], PATHINFO_EXTENSION);
                                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'  || $ext == 'bmp') {
                                        echo
                                            '<div class="col-xs-6 col-sm-3">
                                                <a href="../img/tours/'.$id.'/attachments/'.$a[1].'" class="gallery-link" title="Image Info">
                                                    <img src="../img/tours/'.$id.'/attachments/'.$a[1].'" alt="image">
                                                </a>
                                                '.$a[1].'
                                            </div>';
                                    } else {
                                        echo
                                            '<div class="col-xs-6 col-sm-3">
                                                <a href="../img/placeholders/photos/photo5.jpg" class="gallery-link" title="Image Info">
                                                    <img src="../img/placeholders/photos/photo5.jpg" alt="image">
                                                </a>
                                                '.$a[1].'
                                            </div>';
                                    }
                                }
                            echo
                                '</div>
                            </div>';
                        }
                    echo '<hr>';
                    }
                 ?>
                 <hr>
                 <br>
                <form action="discussion.php?cid=<?php echo $id . '&id=' . $discussion_id ; ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                    <!-- Bootstrap WYSIWYG5 (class is initialized in js/app.js -> uiInit()) -->
                    <div class="form-group">
                        <div class="col-xs-12">
                            <textarea id="textarea-wysiwyg" name="response" rows="5" class="form-control textarea-editor" maxlength="1000" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="files">Add Attachments</label>
                        <div class="col-md-9">
                            <input type="file" id="files" name="files" multiple>
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
        </div>
    </div>
</div>
<?php include 'inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->
<script src="../js/ckeditor/ckeditor.js"></script>

<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>