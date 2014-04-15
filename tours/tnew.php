<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $userid = $_SESSION["userid"];

   
    if (isset($_POST["submit"])) {
        $personnel = explode(", ", $_POST['personnel']);
        if(filter_var($personnel, FILTER_VALIDATE_EMAIL)) {
            foreach ($personnel as $value) {
            $sql = "SELECT id FROM users WHERE email IN ('{$value}') ";
            $data = mysqli_query($connection, $sql);
            $newids[] = implode ("", mysqli_fetch_row($data));
            }
            $personnel_id = implode(", ", $newids) . ", " . $userid;
        }

        $query  = "INSERT INTO campaigns SET ";
        $query .= " creatorid = {$userid}, ";
        if (!empty($_POST['name'])){
            $query .= "name = '{$_POST['name']}', ";
        }
        if (!empty($_POST['artist'])){
            $query .= "artist = '{$_POST['artist']}', ";
        }
        if (!empty($_POST['company'])){
            $query .= "company = '{$_POST['company']}', ";
        }
        if (!empty($personnel_id)){
            $query .= "personnel = '{$personnel_id}', ";
        } else {
            $query .= "personnel = '{$userid}', ";
        }
        if (!empty($_POST['description'])){
            $query .= "description = '{$_POST['description']}', ";
        }
        $query .= " recordstatus = 1, datecreated = NOW() ";

        mysqli_query($connection, $query) or die("Nope");

        $campaign_id =  mysqli_insert_id($connection);
        $query = "INSERT INTO history SET campaignid = {$campaign_id}, actiondate = NOW(), action = 'Created', actionid = 1, identifier = '{$_POST['name']}', identifierid = {$campaign_id}, recordstatus = 1, datecreated = NOW()";
        mysqli_query($connection, $query);
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : "";
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : "";
        $capacity = isset($_POST['capacity']) ? $_POST['capacity'] : "";
        $region = isset($_POST['region']) ? $_POST['region'] : "";
        $face_value = isset($_POST['face_value']) ? $_POST['face_value'] : "";
        $currency = isset($_POST['currency']) ? $_POST['currency'] : "";
        $seating = isset($_POST['seating']) ? $_POST['seating'] : "";
        $notes = isset($_POST['notes']) ? $_POST['notes'] : "";
        $guarantee = isset($_POST['guarantee']) ? $_POST['guarantee'] : "";

        $time = date_parse_from_format("n-j-Y", $start_date);
        $start_date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
        $time = date_parse_from_format("n-j-Y", $end_date);
        $end_date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;


        // Create new table entry
        $recordstatus = 1;
        $datecreated = "NOW()";
        $reqs = "";

        $query = "INSERT INTO requirements (campaign_id, creator_id, " ;
            if (!empty($_POST['start_date'])){
                $query .= "start_date, ";
            }
            if (!empty($_POST['end_date'])){
                $query .= "end_date, ";
            }
            if (!empty($_POST['capacity'])){
                $query .= "capacity, ";
            }
            if (!empty($_POST['region'])){
                $query .= "region, ";
            }
            if (!empty($_POST['face_value'])){
                $query .= "face_value, ";
            }
            if (!empty($_POST['currency'])){
                $query .= "currency, ";
            }
            if (!empty($_POST['seating'])){
                $query .= "seating, ";
            }
            if (!empty($_POST['guarantee'])){
                $query .= "guarantee, ";
            }
            if (!empty($_POST['notes'])){
            $query .= "notes, ";
            }

           $query .= "recordstatus, datecreated) VALUES ('$campaign_id', '$userid',";

            if (!empty($_POST['start_date'])){
                $query .= "'$start_date', ";
                $reqs .= "Start Date, ";
            }
            if (!empty($_POST['end_date'])){
                $query .= "'$end_date', ";
                $reqs .= "End Date, ";
            }
            if (!empty($_POST['capacity'])){
                $query .= "'$capacity', ";
                $reqs .= "Capacity, ";
            }
            if (!empty($_POST['region'])){
                $query .= "'$region', ";
                $reqs .= "Region, ";
            }
            if (!empty($_POST['face_value'])){
                $query .= "'$face_value', ";
                $reqs .= "Face Value, ";
            }
            if (!empty($_POST['currency'])){
                $query .= "'$currency', ";
                $reqs .= "Currency, ";
            }
            if (!empty($_POST['seating'])){
                $query .= "'$seating', ";
                $reqs .= "Seating, ";
            }
            if (!empty($_POST['guarantee'])){
                $query .= "'$guarantee', ";
                $reqs .= "Guarantee, ";
            }
            if (!empty($_POST['notes'])){
            $query .= "'$notes', ";
            $reqs .= "Notes, ";
            }
            $query .= "'$recordstatus', {$datecreated} )";
        mysqli_query($connection, $query) or die();

        $qu = "INSERT INTO history SET campaignid = {$campaign_id}, actiondate = DATE_SUB(NOW(), INTERVAL -30 second), action = 'Added', actionid = 2, identifier = '{$reqs}', identifierid = {$campaign_id}, recordstatus = 1, datecreated = NOW()";
        mysqli_query($connection, $qu);
        
        header("Location: index.php");
    }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Wizard Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-suitcase"></i>New Tour
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php">Tours</a></li>
        <li>New</li>
    </ul>
    <!-- END Wizard Header -->

    <!-- Wizards Row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Basic Wizard Block -->
            <div class="block">
                <!-- Basic Wizard Title -->
                <div class="block-title">
                    <h2><strong>New</strong> Tour</h2>
                </div>
                <!-- END Basic Wizard Title -->

                <!-- Basic Wizard Content -->
                <form id="basic-wizard" action="tnew.php" method="post" class="form-horizontal form-bordered">
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
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="artist">Artist*</label>
                            <div class="col-md-6">
                                <select name="artist" class="select-chosen">
                                <option value="0">Select an Artist...</option>
                                            <?php 
                                                $sq = "SELECT id, name, label FROM artist WHERE recordstatus = 1";
                                                $in = mysqli_query($connection, $sq);
                                                while ($artist = mysqli_fetch_row($in))
                                                echo '<option value="' . $artist[1] . '">' . $artist[1] . ' (' . $artist[2] . ')</option>';
                                            ?>
                                </select>
                                <span class="help-block">Not listed? <a href="../artists/new.php?ref=1" class="btn btn-xs btn-primary">Add New</a></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="company">Company*</label>
                            <div class="col-md-6">
                                <input type="text" id="company" name="company" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="description">Brief Description</label>
                            <div class="col-md-6">
                                <input type="text" id="description" name="description" class="form-control">
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
                                    <input type="text" id="start_date" name="start_date" class="form-control text-center" placeholder="From">
                                    <span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
                                    <input type="text" id="end_date" name="end_date" class="form-control text-center" placeholder="To">
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
                                        $info = mysqli_query($connection, "SELECT currency_code, name, currency_name   FROM currencies");
                                        while ($curr = mysqli_fetch_row($info))
                                        echo '<option value="' . $curr[0] . '">' . $curr[1] . ' ' . $curr[2] . ' (' . $curr[0] . ')</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="face_value">Avg. Face Value</label>
                            <div class="col-md-6">
                                <input type="text" id="face_value" name="face_value" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="region">Region</label>
                            <div class="col-md-6">
                                <input type="text" id="region" name="region" class="form-control" placeholder="eg Europe, North America">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="capacity">Avg. Capacity</label>
                            <div class="col-md-6">
                                <input type="text" id="capacity" name="capacity" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-3 control-label">Seat Plan</label>
                        <div class="col-md-9">
                            <label class="radio radio-inline" for="0">Seated</label>
                            <input type="radio" name="seating" id="0" value="Seating" checked="checked" required="required">
                            <label class="radio radio-inline" for="1">Standing</label>
                            <input type="radio" name="seating" id="1" value="Standing" required="required">
                            <label class="radio radio-inline" for="2">Both</label>
                            <input type="radio" name="seating" id="2" value="Both" required="required">
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
                                <textarea id="guarantee" name="guarantee" rows="5" class="form-control" placeholder="eg 60% of face and £10000"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="notes">Notes</label>
                            <div class="col-md-8">
                                <textarea id="notes" name="notes" rows="5" class="form-control"></textarea>
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