<?php include '../inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php 
    $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT a.id, a.name, a.city, c.name, a.label, a.genre, a.description FROM artist AS a JOIN currencies AS c ON a.country = c.iso_alpha2 WHERE id = {$id}";
    $data = mysqli_query($connection, $sql) or die();
    $art = mysqli_fetch_row($data);
    if (substr($art[1], strlen($art[1]) - 5, strlen($art[1])) === ", The") {
        $art[1] = "The " . substr($art[1], 0, strlen($art[1]) - 5);
    }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Forms General Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><?php echo $art[1] ?><br><small><?php echo $art[2] ?>, <?php echo $art[3] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../">Home</a></li>
        <li><a href="index.php">Artists</a></li>
        <li><a href="profile.php?id=<?php echo $art[0]; ?>"><?php echo $art[1]; ?></a></li>
        <li>Upload Cover Photo</li>
    </ul>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="block full">
                <div class="block-title">
                    <h2><small>Upload Photo</small></h2>
                </div>
                <form action="exe/upload.php?id=<?php echo $id ?>" enctype="multipart/form-data" method="post" class="form-inline" >
                    <div>
                        <label class="sr-only" for="file_upload">Upload a file</label>
                        <input id="file_upload"  type="file" name="file_upload" />
                     <br>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="example-if-password">Enter a name</label>
                        <input class="form-control" type="text" name="file_name" placeholder="Document name (Required)" required />
                    </div>
                    <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-primary"><i class="hi hi-folder-open"></i> Upload</button>
                        <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include '../tours/inc/page_footer.php'; ?>
<?php include '../tours/inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/formsGeneral.js"></script>
<script>$(function(){ FormsGeneral.init(); });</script>

<?php include '../tours/inc/template_end.php'; ?>