<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php
    $sql = "SELECT a.id, a.name, a.label, a.city, c.name, a.description FROM artist AS a JOIN currencies AS c ON a.country = c.iso_alpha2 ORDER BY a.name ASC";
    $data = mysqli_query($connection, $sql) or die();
 ?>

<!-- Page content -->
<div id="page-content">
    <!-- Datatables Header -->
        <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Artists</strong></h1><br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../">Home</a></li>
        <li>Artists</li>
    </ul>
    <div class="block full">
        <div class="block-title">
            <div class="block-options pull-right">
                 <a href="new.php" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="New Artist" data-original-title="New Artist"><i class="gi gi-circle_plus"></i></a>
            </div>
            <h2>Lookup <strong>Artists</strong></h2>
        </div>
        <div class="table-responsive">
            <table id="datatable" class="table table-vcenter table-condensed table-borderless">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th>Artist</th>
                        <th>Label</th>
                        <th>Hometown</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($info = mysqli_fetch_row($data)) { ?>
                    <tr>
                        <td></td>
                        <td><?php echo $info[1]; ?></td>
                        <td><?php echo $info[2]; ?></td>
                        <td><?php echo $info[3] . ', ' . $info[4]; ?></td>
                        <td><?php echo $info[5]; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                            <a href="edit.php?id=<?php echo $info[0]; ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="profile.php?id=<?php echo $info[0]; ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="View Profile"><i class="fa fa-user"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include '../tours/inc/page_footer.php'; ?>
<?php include '../tours/inc/template_scripts.php'; ?>
<script src="../js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script>

<?php include '../inc/template_end.php'; ?>