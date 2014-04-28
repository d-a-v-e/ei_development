<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
    $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company \n"
    . "FROM campaigns WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);

    if (isset($_POST['submit'])) {
        $personnel_id = $userid;
        $personnel = explode(", ", $_POST['personnel']);
            foreach ($personnel as $value) {
                $sql = "SELECT id FROM users WHERE email IN ('{$value}') ";
                $data = mysqli_query($connection, $sql);
                $newids[] = implode ("", mysqli_fetch_row($data));
            }
            $personnel_id .= ", " . implode(", ", $newids);

        $query  = "INSERT INTO discussions SET ";
        $query .= "campaignid = {$id}, ";
        $query .= "discussion_creator_id = {$userid}, ";
        $query .= "subject = '{$_POST['subject']}', ";
        $query .= "participants = '{$personnel_id}', ";
        $query .= "recordstatus = 1, datecreated = NOW()";;
        mysqli_query($connection, $query);
        $discussion_id = mysqli_insert_id($connection);
        echo $query;

        $query  = "INSERT INTO discussion_responses SET ";
        $query .= "campaignid = {$id}, ";
        $query .= "contributer_id = {$userid}, " ;
        $query .= "discussion_id = {$discussion_id}, " ;
        $query .= "response = '{$_POST['content']}', ";
        $query .= "recordstatus = 1, datecreated = NOW()";
        $result = mysqli_query($connection, $query);

        $insid = mysqli_insert_id($connection);

        if ($result && mysqli_affected_rows($connection) >= 0) {
            $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Discussion Created', actionid = 4, identifier = '{$_POST['subject']}', identifierid = {$insid}, recordstatus = 1, datecreated = NOW()";
            mysqli_query($connection, $query);
            header("Location: discussions.php?id=$id");
        } else {
            header("Location: discussions.php?id=$id");
        }
    }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Forms General Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Add</strong> Discussion</h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php">Home</a></li>
        <li><a href="tour.php?id=<?php echo $id; ?>">Tour</a></li>
        <li>Add Discussion</li>
    </ul>
    <!-- END Forms General Header -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Horizontal Form Block -->
            <div class="block">
                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2><strong>New</strong> Discussion</h2>
                </div>
                <!-- END Horizontal Form Title -->

                <!-- Horizontal Form Content -->
                <form action="new_desc.php?id=<?php echo $id; ?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="personnel">To</label>
                        <div class="col-md-9">
                            <textarea type="text" id="personnel" name="personnel" class="form-control" placeholder="Invite participants: Please insert email addresses separated by commas"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="subject">Subject</label>
                        <div class="col-md-9">
                            <input type="text" id="content" name="subject" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea-wysiwyg">Content</label>
                            <div class="col-md-9">
                                <textarea  id="textarea-wysiwyg" name="content" rows="5" class="form-control textarea-editor" required></textarea>
                            </div> 
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-file-multiple-input">Attach Docs</label>
                        <div class="col-md-9">
                            <input type="file" id="example-file-multiple-input" name="example-file-multiple-input" multiple>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="gi gi-chat"></i> Create</button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/formsGeneral.js"></script>
<script>$(function(){ FormsGeneral.init(); });</script>
<?php include 'inc/template_end.php'; ?>