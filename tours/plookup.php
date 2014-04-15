<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php
    $id = $_GET["id"];
    
    $sql = "SELECT company.id, users.firstname, users.lastname, company.name, company.description, users.email FROM users \n"
    . "JOIN company ON company.id = users.companyid\n"
    . "WHERE companytypeid = 2\n"
    . "ORDER BY id ASC";
    $data = mysqli_query($connection, $sql) or die();

 ?>

<!-- Page content -->
<div id="page-content">
    <!-- Datatables Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-ticket"></i>Add<br><small> Promoter</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php?id=<?php echo $id; ?>">Tour</a></li>
        <li><a href="routing.php?id=<?php echo $id; ?>">Routing</a></li>
        <li><a href="promoters.php?id=<?php echo $id; ?>">Promoters</a></li>
        <li>Lookup</li>
    </ul>
    <!-- END Datatables Header -->
 <form action="exe/add_promoter.php?id=<?php echo $id; ?>" method="post" >
    <div class="block full">
        <div class="block-title">
            <h2><strong>Promoters</strong> Lookup</h2>
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
                        <th class="text-center">Select</th>
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
                            <input type="checkbox" id="<?php echo $info[0]; ?>" name="<?php echo $info[0]; ?>" value="<?php echo $info[0]; ?>">
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
         <div class="col-md-3">
                <div class="btn-group btn-group-sm">
                <button type="submit" name="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Add Selected"><i class="fa fa-check"></i></button>
                <a href="pnew.php?id=<?php echo $id; ?>" name="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create New"><i class="hi hi-plus"></i></a>
                </div>
            </div>
        </form>
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script>

<?php include 'inc/template_end.php'; ?>