<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php

    $id = $_GET['id'];

    $_SESSION['message'] = '';
    $_SESSION['alert'] = '';
    $_SESSION['msgicon'] = '';
    $_SESSION['pop'] = '';

    $sql = "SELECT a.id, a.name, a.city, c.name, a.label, a.genre, a.description, a.mainpicture FROM artist AS a JOIN currencies AS c ON a.country = c.iso_alpha2 WHERE id = {$id}";
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
            <h1><strong><?php echo $art[1]; ?></strong></h1><br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/widget4_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../">Home</a></li>
        <li><a href="index.php">Artists</a></li>
        <li><?php echo $art[1]; ?></li>

    </ul>
    <!-- END Forms General Header -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="block">
                <div class="block-advanced block-advanced-alt">
                    <div class="block-title">
                        <div class="block-options pull-right">
                                <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="photo.php?id=<?php echo $id; ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Upload Photo"><i class="fa fa-camera"></i></a>
                        </div>
                <?php 
                    if (!empty($art[7])) {
                        echo '<img src="../img/artists/'.$id.'/'.$art[7].'" alt="background" width="100%">';
                    }
                ?>
                </div>
                    <div class="block-main">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Hometown </strong></td>
                            <td><span class="pull-right"><?php echo $art[2] . ', ' . $art[3];  ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Label </strong></td>
                            <td><span class="pull-right"><?php echo $art[4] ; ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Genre </strong></td>
                            <td><span class="pull-right"><?php echo $art[5] ; ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Description </strong></td>
                            <td><span class="pull-right"><?php echo $art[6] ; ?></span></td>
                        </tr>
                    </tbody>
                </table>
                    </div>
                    <!-- END Widget Main -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include '../tours/inc/page_footer.php'; ?>
<?php include '../tours/inc/template_scripts.php'; ?>
<?php include '../inc/template_end.php'; ?>