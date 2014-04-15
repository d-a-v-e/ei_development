<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company, requirements.* \n"
    . "FROM campaigns\n"
    . "JOIN requirements \n"
    . "ON campaigns.id = requirements.campaign_id WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);

    if (!empty($info)) {
        switch ($info[6]) {
            case "":
                $info[6] = " - " ;
                break;
            case "0000-00-00":
                $info[6] = " - " ;
                break;
            default:
                $date = strtotime($info[6]);
                $info[6] = date('d/m/Y', $date);
                break;
        }
        switch ($info[7]) {
            case "":
                $info[7] = " - " ;
                break;
            case "0000-00-00":
                $info[7] = " - " ;
                break;
            default:
                $date = strtotime($info[7]);
                $info[7] = date('d/m/Y', $date);
                break;
        }
    }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Forms General Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Add</strong> Date</h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>">Tour</a></li>
        <li>Quick Add</li>
    </ul>
    <!-- END Forms General Header -->
    <div class="row">
        <div class="col-md-6">
            <!-- Horizontal Form Block -->
            <div class="block">
                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2><strong>Quick</strong> Date</h2>
                </div>
                <!-- END Horizontal Form Title -->

                <!-- Horizontal Form Content -->
                <form action="exe/quick_add.php?id=<?php echo $id; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="venue">Venue</label>
                        <div class="col-md-9">
                            <select name="venue" class="select-chosen">
                                    <option value="">Select a Venue...</option>
                                    <?php 
                                        $in = mysqli_query($connection, "SELECT v.id, v.name, v.location, c.name FROM venue AS v JOIN currencies AS c ON v.country = c.iso_alpha2 ORDER BY v.name");
                                        while ($venue = mysqli_fetch_row($in))
                                        echo '<option value="' . $venue[0] . '">' . $venue[1] . ' (' . $venue[2] . ', ' . $venue[3] . ')</option>';
                                    ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                        Not listed?
                            <a href="../venues/new.php?id=<?php echo $id; ?>&ref=1" class="btn btn-xs btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="promoter">Promoter</label>
                            <div class="col-md-9">
                                <select name="promoter" class="select-chosen">
                                <option value="0">Select a Promoter...</option>
                                            <?php 
                                                $sq = "SELECT u.id, u.firstname, u.lastname, c.name, c.id FROM users AS u
                                                        JOIN company AS c ON u.companyid = c.id
                                                        WHERE companytypeid = 2";
                                                $in = mysqli_query($connection, $sq);
                                                while ($prom = mysqli_fetch_row($in))
                                                echo '<option value="' . $prom[0] . '">' . $prom[1] . ' ' . $prom[2] . ' (' . $prom[3] . ')</option>';
                                            ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                    <label class="col-md-3 control-label" for="date">Date</label>
                        <div class="col-md-9">
                            <input type="text" id="date" name="date" class="form-control input-datepicker" data-date-format="dd/mm/yy" placeholder="dd/mm/yy">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="promoter">Ticket Outlet<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="outlet" class="select-chosen">
                                            <?php 
                                                $sq = "SELECT id, name FROM redeemoutlets WHERE companytypeid = 1";
                                                $in = mysqli_query($connection, $sq);
                                                while ($prom = mysqli_fetch_row($in))
                                                echo '<option value="' . $prom[0] . '">' . $prom[1] . '</option>';
                                            ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="link">Default Link <small>(optional)</small></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" id="link" name="link" class="form-control" value="http://">
                                    <span class="input-group-addon"><i class="gi gi-globe"></i></span>
                                </div>
                            </div>
                        </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="hi hi-map-marker"></i> Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
                        <div class="block">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="tedit.php?id=<?php echo $id ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </div>
                    <h2><strong>Requirements</strong> <small>&bull; <a href="javascript:void(0)" data-toggle="tooltip" title="Download requirements PDF"> <i class="fa fa-file-text text-primary"></i> PDF</a></small></h2>
                </div>
                <!-- END Info Title -->

                <!-- Info Content -->
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Timeframe: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[6] ?></strong> to <strong><?php echo $info[7] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Avg. Capacity: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[8] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Region: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[9] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Base Currency: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[10] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Avg. Face Value: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[11] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Seating: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[13] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Guarantee: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[12] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"><strong>Notes</strong></td>
                            <td><?php echo $info[14] ?></td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Requirements Content -->
            </div>
            <!-- END Requirements Block -->
        </div>
    </div>
    <!-- END Form Example with Blocks in the Grid -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/formsGeneral.js"></script>
<script>$(function(){ FormsGeneral.init(); });</script>
<?php include 'inc/template_end.php'; ?>