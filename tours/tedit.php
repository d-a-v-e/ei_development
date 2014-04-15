<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    var_dump($_POST);

    $id = $_GET['id'];
    $userid = $_SESSION["userid"];

    $sql = "SELECT campaigns.*, requirements.* FROM campaigns \n"
    . "JOIN requirements ON campaigns.id = requirements.campaign_id\n"
    . "WHERE campaigns.id = {$id}";
    $data = mysqli_query($connection, $sql);
    $info = mysqli_fetch_row($data);
    $check = $info[20];
    if (!empty($info)) {
        switch ($info[16]) {
            case "":
                $info[16] = " - " ;
                break;
            case "0000-00-00":
                $info[16] = " - " ;
                break;
            default:
                $date = strtotime($info[16]);
                $info[16] = date('d/m/Y', $date);
                break;
        }
        switch ($info[17]) {
            case "":
                $info[17] = " - " ;
                break;
            case "0000-00-00":
                $info[17] = " - " ;
                break;
            default:
                $date = strtotime($info[17]);
                $info[17] = date('d/m/Y', $date);
                break;
        }
    }

    // if (isset($_POST["submit"])) {
    //     $personnel = explode(", ", $_POST['personnel']);
    //     if(filter_var($personnel, FILTER_VALIDATE_EMAIL)) {
    //         foreach ($personnel as $value) {
    //         $sql = "SELECT id FROM users WHERE email IN ('{$value}') ";
    //         $data = mysqli_query($connection, $sql);
    //         $newids[] = implode ("", mysqli_fetch_row($data));
    //         }
    //         $personnel_id = implode(", ", $newids) . ", " . $userid;
    //     }

    //     $query  = "UPDATE campaigns SET ";
    //     $query .= " creatorid = {$userid}, ";
    //     if (!empty($_POST['name'])){
    //         $query .= "name = '{$_POST['name']}', ";
    //     }
    //     if (!empty($_POST['artist'])){
    //         $query .= "artist = '{$_POST['artist']}', ";
    //     }
    //     if (!empty($_POST['company'])){
    //         $query .= "company = '{$_POST['company']}', ";
    //     }
    //     if (!empty($personnel_id)){
    //         $query .= "personnel = '{$personnel_id}', ";
    //     } else {
    //         $query .= "personnel = '{$userid}', ";
    //     }
    //     if (!empty($_POST['description'])){
    //         $query .= "description = '{$_POST['description']}', ";
    //     }
    //     $query .= " recordstatus = 1, datecreated = NOW() WHERE id = {$id} LIMIT 1";

    //     mysqli_query($connection, $query) or die("Nope");

    //     $query = "UPDATE requirements SET ";
    //     $query .= " datechanged = NOW(), ";
    //     if (!empty($_POST['start_date'])) {

    //         $time = date_parse_from_format("n-j-Y", $_POST['start_date']);
    //         $start = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
    //         $query .= " start_date = '" . $start . "', "; 

    //     } if (!empty($_POST['end_date'])) {
    //         $time = date_parse_from_format("n-j-Y", $_POST['end_date']);
    //         $end = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
    //         $query .= " end_date = '" . $end . "', " ; 
    //     }
        
    //     if (!empty($_POST['capacity'])) {
    //         $query .= "capacity = '" . $_POST['capacity'] . "', " ;
    //     }

    //     if (!empty($_POST['region'])) {
    //         $query .= "region = '" . $_POST['region'] . "', " ;
    //     }

    //     if (!empty($_POST['face_value'])) {
    //         $query .= "face_value = '" . $_POST['face_value'] . "', " ;
    //     }

    //     if (!empty($_POST['currency'])) {
    //         $query .= "currency = '" . $_POST['currency'] . "', " ;
    //     }

    //     if (!empty($_POST['seating'])) {
    //         $query .= "seating = '" . $_POST['seating'] . "', " ;
    //     }

    //     if (!empty($_POST['notes'])) {
    //         $query .= "notes = '" . $_POST['notes'] . "', " ;
    //     }

    //     if (!empty($_POST['guarantee'])) {
    //         $query .= "guarantee = '" . $_POST['guarantee'] . "', " ;
    //     }

    // $query = substr($query, 0, -2) ;
    // $query .= ", datechanged = NOW() WHERE campaign_id = {$id}";
    //     mysqli_query($connection, $query) or die("Nope 3");
    //    header("Location: tedit.php?id={$id}");
    // }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Wizard Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-suitcase"></i>Edit Tour
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>">Tour</a></li>
        <li>Edit</li>
    </ul>
    <!-- END Wizard Header -->

    <!-- Wizards Row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Basic Wizard Block -->
            <div class="block">
                <!-- Basic Wizard Title -->
                <div class="block-title">
                    <h2><strong>Edit</strong> Tour</h2>
                </div>
                <!-- END Basic Wizard Title -->

                <!-- Basic Wizard Content -->
                <form id="basic-wizard" action="tedit.php?id=<?php echo $id ; ?>" method="post" class="form-horizontal form-bordered">
                    <!-- First Step -->
                    <div id="first" class="step">
                        <!-- Step Info -->
                        <div class="wizard-steps">
                            <div class="row">
                                <div class="col-xs-4 active">
                                    <span>1. Overview</span>
                                </div>
                                <div class="col-xs-4">
                                    <span>2. Reqs</span>
                                </div>
                                <div class="col-xs-4">
                                    <span>3. Extras</span>
                                </div>
                            </div>
                        </div>
                        <!-- END Step Info -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Tour Name*</label>
                            <div class="col-md-6">
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $info[2] ; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="artinst">Artist*</label>
                            <div class="col-md-6">
                                <select name="artist" class="select-chosen">
                                <option value="0">Select an Artist...</option>
                                            <?php 
                                                $sq = "SELECT id, name, label FROM artist WHERE recordstatus = 1";
                                                $in = mysqli_query($connection, $sq);
                                                while ($artist = mysqli_fetch_row($in))
                                                echo '<option value="' . $artist[1] . '"';
                                                if ($info[3] == $artist[1]) { echo " selected " ; }
                                                echo '>' . $artist[1] . ' (' . $artist[2] . ')</option>';
                                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="company">Company*</label>
                            <div class="col-md-6">
                                <input type="text" id="company" name="company" class="form-control" value="<?php echo $info[4] ; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="description">Brief Description</label>
                            <div class="col-md-6">
                                <input type="text" id="description" name="description" class="form-control" value="<?php echo $info[5] ; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="personnel">Invite Participants</label>
                            <div class="col-md-6">
                                <textarea type="text" id="personnel" name="personnel" class="form-control" placeholder="Insert email addresses separated by commas"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- END First Step -->

                    <!-- Second Step -->
                    <div id="second" class="step">
                        <!-- Step Info -->
                        <div class="wizard-steps">
                            <div class="row">
                                <div class="col-xs-4 done">
                                    <span><i class="fa fa-check"></i></span>
                                </div>
                                <div class="col-xs-4 active">
                                    <span>2. Reqs</span>
                                </div>
                                <div class="col-xs-4">
                                    <span>3. Extras</span>
                                </div>
                            </div>
                        </div>
                        <!-- END Step Info -->
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="start_date end_date">Timeframe*</label>
                            <div class="col-md-8">
                                <div class="input-group input-daterange" data-date-format="mm/dd/yyyy">
                                    <input type="text" id="start_date" name="start_date" class="form-control text-center" placeholder="From" value="<?php echo $info[16] ; ?>">
                                    <span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
                                    <input type="text" id="end_date" name="end_date" class="form-control text-center" placeholder="To" value="<?php echo $info[17] ; ?>">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                            <label class="col-md-4 control-label" for="currency">Base Currency</label>
                            <div class="col-md-6">
                                <select id="currency" name="currency" class="select-chosen" data-placeholder="Choose a Currency..." style="width: 250px; height: 50px;">
                                    <option value="">Choose a Currency...</option>
                                    <?php 
                                        $inf = mysqli_query($connection, "SELECT currency_code, name, currency_name   FROM currencies");
                                        while ($curr = mysqli_fetch_row($inf)) {
                                        echo '<option value="' . $curr[0] . '" ' ;
                                        if ($curr[0] == $check) { echo " selected"; }
                                        echo '>' . $curr[1] . ' ' . $curr[2] . ' (' . $curr[0] . ')</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="face_value">Avg. Face Value</label>
                            <div class="col-md-6">
                                <input type="text" id="face_value" name="face_value" class="form-control" value="<?php echo $info[21] ; ?>"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="region">Region</label>
                            <div class="col-md-6">
                                <input type="text" id="region" name="region" class="form-control" value="<?php echo $info[19] ; ?>" placeholder="eg Europe, North America">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="capacity">Avg. Capacity</label>
                            <div class="col-md-6">
                                <input type="text" id="capacity" name="capacity" class="form-control" value="<?php echo $info[18] ; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-3 control-label">Seat Plan</label>
                        <div class="col-md-9">
                            <label class="radio radio-inline" for="0">Seated</label>
                            <input type="radio" name="seating" id="0" value="Seating" <?php if ($info[23] == "Seated") { echo ' checked="checked" '; } ?> required="required">
                            <label class="radio radio-inline" for="1">Standing</label>
                            <input type="radio" name="seating" id="1" value="Standing" <?php if ($info[23] == "Standing") { echo ' checked="checked" '; } ?> required="required">
                            <label class="radio radio-inline" for="2">Both</label>
                            <input type="radio" name="seating" id="2" value="Mixed" <?php if ($info[23] == "Mixed") { echo ' checked="checked" '; } ?> required="required">
                        </div>
                    </div>
                    </div>
                    <!-- END Second Step -->

                    <!-- Third Step -->
                    <div id="third" class="step">
                        <!-- Step Info -->
                        <div class="wizard-steps">
                            <div class="row">
                                <div class="col-xs-4 done">
                                    <span><i class="fa fa-check"></i></span>
                                </div>
                                <div class="col-xs-4 done">
                                    <span><i class="fa fa-check"></i></span>
                                </div>
                                <div class="col-xs-4 active">
                                    <span>3. Extras</span>
                                </div>
                            </div>
                        </div>
                        <!-- END Step Info -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="guarantee">Guarantee</label>
                            <div class="col-md-8">
                                <textarea id="guarantee" name="guarantee" rows="3" class="form-control" placeholder="eg 60% of face and £10000"><?php echo $info[22] ; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="notes">Notes</label>
                            <div class="col-md-8">
                                <textarea id="notes" name="notes" rows="3" class="form-control"><?php echo $info[24] ; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"><a href="#modal-terms" data-toggle="modal">Terms</a></label>
                            <div class="col-md-6">
                                <label class="switch switch-primary" for="example-terms">
                                    <input type="checkbox" id="example-terms" name="example-terms" value="1">
                                    <span data-toggle="tooltip" title="I agree to the terms!"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- END Third Step -->

                    <!-- Form Buttons -->
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <p><small>(* = required field)</small></p>
                            <input type="reset" class="btn btn-sm btn-warning" id="back" value="Back">
                            <input name="submit" type="submit" class="btn btn-sm btn-primary" id="next" value="Next">
                        </div>
                    </div>
                    <!-- END Form Buttons -->
                </form>
                <!-- END Basic Wizard Content -->
            </div>
            <!-- END Basic Wizard Block -->
        </div>
    </div>
    <!-- END Wizards Row -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/formsWizard.js"></script>
<script>$(function(){ FormsWizard.init(); });</script>
<script>
        $('#start_date').datepicker({
            format: "dd/mm/yyyy"
        });
        $('#end_date').datepicker({
            format: "dd/mm/yyyy"
        });
</script>

<?php include 'inc/template_end.php'; ?>