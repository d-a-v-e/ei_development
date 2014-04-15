<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 
    
    $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT name, artist, company FROM campaigns WHERE id = {$id}";
                $data = mysqli_query($connection, $sql) or die();
                $info = mysqli_fetch_row($data);

    $sql = "SELECT id, name FROM documents WHERE campaign_id = {$id}";
                $docs = mysqli_query($connection, $sql) or die();

?>

<!-- Page content -->
<div id="page-content">
    <!-- Forms General Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Documents</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>"> Tour</a></li>
        <li>Upload Documents</li>
    </ul>
    <!-- END Forms General Header -->

    <div class="row">
        <div class="col-md-6">
            <div class="block full">
                <div class="block-title">
                    <h2><small>Upload Documens</small></h2>
                </div>
                <!-- Dropzone.js, You can check out https://github.com/enyo/dropzone/wiki for usage examples -->
                <form action="upload.php?id=<?php echo $id ?>" class="dropzone">
                <input type="hidden">
                </form>
                <br>
                <form action="upload.php?id=<?php echo $id ?>" enctype="multipart/form-data" method="post" class="form-inline" >
                    or
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
        <div class="col-md-6">
            <!-- Lightbox Gallery with Options Block -->
            <div class="block">
                <!-- Lightbox Gallery with Options Title -->
                <div class="block-title">
                    <h2><strong>Docs Gallery</strong></h2>
                </div>
                <!-- END Lightbox Gallery with Options Title -->

                <!-- Lightbox Gallery with Options Content -->
                <div class="gallery" data-toggle="lightbox-gallery">
                    <div class="row">

                    <?php 
                        while ($d = mysqli_fetch_row($docs)) {
                            // if file ends with .jpg, .jpeg, .gif or .png do image else do paperclip glyph...
                            $ext = pathinfo($d[1], PATHINFO_EXTENSION);
                            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'  || $ext == 'bmp') {
                                    echo 
                                    '<div class="col-sm-4 gallery-image">
                                        <img src="../img/tours/' . $id . '/' . $d[1] . '" alt="image">
                                        <div class="gallery-image-options text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="../img/tours/' . $id . '/' . $d[1] . '" class="gallery-link btn btn-sm btn-alt btn-default" title="Image Info">View</a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </div>
                                    </div>';
                            } else {
                                echo 
                                    '<div class="col-sm-4 gallery-image">
                                    <img src="../img/placeholders/avatars/avatar.jpg" alt="image">
                                        <div class="gallery-image-options text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                    ?>
                    </div>
                </div>
                <!-- END Lightbox Gallery with Options Content -->
            </div>
            <!-- END Lightbox Gallery with Options Block -->

        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/formsGeneral.js"></script>
<script>$(function(){ FormsGeneral.init(); });</script>

<?php include 'inc/template_end.php'; ?>