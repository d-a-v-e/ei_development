<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php
    $sql = "SELECT users.id, users.firstname, users.lastname, company.name, company.description, users.email FROM users \n"
    . "JOIN company ON company.id = users.companyid\n"
    . "WHERE companytypeid = 2\n"
    . "ORDER BY id ASC";
    $data = mysqli_query($connection, $sql) or die();
 ?>

<!-- Page content -->
<div id="page-content">
    <!-- Datatables Header -->
        <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Promoters</strong></h1><br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../">Home</a></li>
        <li>Promoters</li>
    </ul>
    <!-- END Datatables Header -->
    <div class="block full">
        <div class="block-title">
            <div class="block-options pull-right">
                 <a href="new.php" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="New Promoter" data-original-title="New Promoter"><i class="gi gi-circle_plus"></i></a>
            </div>
            <h2>Lookup <strong>Promoters</strong></h2>
        </div>
        <div class="table-responsive">
            <table id="datatable" class="table table-vcenter table-condensed table-borderless">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th>Client</th>
                        <th>Company</th>
                        <th>Description</th>
                        <th>Email</th>
                        <th class="text-center">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($info = mysqli_fetch_row($data)) { ?>
                    <tr>
                        <td></td>
                        <td><?php echo $info[1] . ' ' . $info[2]; ?></td>
                        <td><?php echo $info[3]; ?></td>
                        <td><?php echo $info[4]; ?></td>
                        <td><?php echo $info[5]; ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?php echo $info[0]; ?>" class="btn btn-xs btn-info"><i class="hi hi-pencil"></i></a>
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