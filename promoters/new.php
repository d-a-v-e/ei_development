<?php include '../tours/inc/config.php'; ?>
<?php include '../tours/inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<!-- Page content -->
<div id="page-content">
    <!-- Forms General Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1>Add <strong>Promoter</strong></h1><br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php?rtn=1">Promoters</a></li>
        <li>New</li>

    </ul>
    <!-- END Forms General Header -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Horizontal Form Block -->
            <div class="block">
                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2><strong>Add</strong> Promoter</h2>
                </div>
                <!-- END Horizontal Form Title -->

                <!-- Horizontal Form Content -->
                <form action="../tours/exe/create_promoter.php?id=<?php echo $id; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="company">Company Name*</label>
                        <div class="col-md-9">
                            <input type="text" id="conpany" name="company" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nickname">Abbreviated Name</label>
                        <div class="col-md-9">
                            <input type="text" id="nickname" name="nickname" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">Description</label>
                        <div class="col-md-9">
                            <input type="text" id="description" name="description" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="office">Office*</label>
                        <div class="col-md-9">
                            <input type="text" id="office" name="office" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="state">State</label>
                        <div class="col-md-9">
                            <input type="text" id="state" name="state" class="form-control" >
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label" for="country">Country*</label>
                        <div class="col-md-9">
                            <input type="text" id="country" name="country" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name*</label>
                        <div class="col-md-4">
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email">Email*</label>
                        <div class="col-md-9">
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <p><small>(* = required field)</small></p>
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Add</button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
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