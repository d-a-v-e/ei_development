<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $userid = $_SESSION['userid'];

    $sql = "SELECT b.promoidentifier, b.promoname, b.startdate, b.enddate, l.name, a.name, a.barcode, b.affiliatecode, b.promooutletids, a.description, b.redemptionsubject, b.campaigncode AS rafffiliatecode, m.name, b.redemptionoutletids, b.redemptionlink FROM products AS a\n"
    . "JOIN promotions AS b ON b.productid = a.id\n"
    . "JOIN lists as l ON b.promotype = l.id\n"
    . "JOIN lists AS m ON b.redemptiontypeid = m.id\n"
    . "WHERE b.id = {$id} AND l.listid = 4 AND m.listid = 5 LIMIT 1";
    echo $sql;
        $data = mysqli_query($connection, $sql) ;
        $info = mysqli_fetch_row($data);
        $info[2] = date("d/m/Y", strtotime($info[2]));
        $info[3] = date("d/m/Y", strtotime($info[2]));
        $info[8] = explode(',', $info[8]);
        $info[13] = explode(',', $info[13]);

?>
<div id="page-content">
   <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong><?php echo $info[0] ?></strong><br><?php echo $info[1] . ' (' . $info[4] . ')'; ?><br><small><?php echo $info[2] . ' to ' . $info[3] ; ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php"> Campaigns</a></li>
        <li><?php echo $info[1] . ' (' . $info[4] . ')'; ?></li>
    </ul>
    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Promotion</strong></h2>
                </div>
                <form action="page_forms_general.php" method="post" enctype="multipart/form-data" class="form-horizontal form-borderless">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Product Name</label>
                        <div class="col-md-9">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" value="<?php echo $info[5]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Product ID</label>
                        <div class="col-md-9">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" value="<?php echo $info[6]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Affiliate Ref.</label>
                        <div class="col-md-4">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" value="<?php echo $info[7]; ?>">
                        </div>
                       <div class="col-md-3">
                            <label class="checkbox-inline" for="example-inline-checkbox1">
                                <input type="checkbox" id="example-inline-checkbox1" name="example-inline-checkbox1" value="1"> Validate
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Promo Outlets</label>
                        <div class="col-md-9">
                            <?php 
                                foreach ($info[8] as $key => $value) {
                                    $result = mysqli_query($connection, "SELECT name FROM promooutlets WHERE id = {$value}");
                                    $inf = mysqli_fetch_row($result);
                                    echo '<input type="text" id="example-text-input" name="' . $value . '" class="form-control" value="' . $inf[0] . '">';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-textarea-input">Offer Details</label>
                        <div class="col-md-9">
                            <textarea id="example-textarea-input" name="example-textarea-input" rows="5" class="form-control"><?php echo $info[9]; ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <h2><strong>Redemption</strong></h2>
                </div>
                <form action="page_forms_general.php" method="post" enctype="multipart/form-data" class="form-horizontal form-borderless">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Redemption</label>
                        <div class="col-md-9">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" value="<?php echo $info[10]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Redeem Type</label>
                        <div class="col-md-9">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" value="<?php echo $info[12]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Affiliate Ref.</label>
                        <div class="col-md-4">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" value="<?php echo $info[11]; ?>">
                        </div>
                       <div class="col-md-3">
                            <label class="checkbox-inline" for="example-inline-checkbox1">
                                <input type="checkbox" id="example-inline-checkbox1" name="example-inline-checkbox1" value="1"> Validate
                            </label>
                        </div>
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="example-daterange1">Offer Open</label>
                            <div class="col-md-9">
                                <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                    <input type="text" id="example-daterange1" name="example-daterange1" class="form-control text-center" placeholder="From" value="<?php echo $info[2]; ?>">
                                    <span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
                                    <input type="text" id="example-daterange2" name="example-daterange2" class="form-control text-center" placeholder="To" value="<?php echo $info[3]; ?>">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Redemption Outlets</label>
                        <div class="col-md-9">
                        <?php 
                                foreach ($info[13] as $key => $value) {
                                    echo $value;
                                    $result = mysqli_query($connection, "SELECT name FROM redeemoutlets WHERE id = {$value}");
                                    $inf = mysqli_fetch_row($result);
                                    echo '<input name="' . $value . '" class="form-control" value="' . $inf[0] . '">';
                                }
                        ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-textarea-input">Destination</label>
                        <div class="col-md-9">
                            <textarea id="example-textarea-input" name="example-textarea-input" rows="2" class="form-control" placeholder="Content.."><?php echo $info[14]; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
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
<?php include '../tours/inc/template_end.php'; ?>