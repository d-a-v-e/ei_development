<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $date_id = $_GET["did"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company, requirements.* \n"
    . "FROM campaigns\n"
    . "JOIN requirements \n"
    . "ON campaigns.id = requirements.campaign_id WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql);
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

    $sql = "SELECT city, c.name, date, flexibility FROM routing as r\n"
    . "JOIN currencies AS c ON c.iso_alpha2 = country\n"
    . "WHERE r.id = {$date_id} ";
    $dat = mysqli_query($connection, $sql);
    $in = mysqli_fetch_row($dat);
    $in[2] = date('d/m/Y', strtotime($in[2]));

    if (isset($_POST['submit'])) {

        $query  = "UPDATE routing SET  ";
        $query .= "datechanged = NOW(), "; 
        if (!empty($_POST['city'])) {
            $query .= "city = '{$_POST['city']}', ";}
        if (!empty($_POST['country'])) {
          if ($_POST['country'] == 'UK') { $_POST['country'] = 'GB' ;}
          $query .= "country = '{$_POST['country']}', ";}
               if (!empty($_POST['date'])) {
            $time = date_parse_from_format("n-j-Y", $_POST['date']);
                $date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
                $query .= "date = '{$date}', ";
        }
        if (!empty($_POST['flexibility'])) {
          $query .= "flexibility = '{$_POST['flexibility']}', ";}
          $query = substr($query, 0, -2) ;
        $query .= " WHERE id = {$date_id} ";
        $query .= "LIMIT 1";
          $result = mysqli_query($connection, $query) or die ("nope");
        if ($result && mysqli_affected_rows($connection) >= 0) {
            
            $nam = mysqli_query($connection, "SELECT city FROM routing WHERE id = {$date_id}");
            $na = mysqli_fetch_row($nam);
            $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Date Updated', actionid = 3, identifier = '{$na[0]}', identifierid = {$date_id}, recordstatus = 1, datecreated = NOW()";
            
            mysqli_query($connection, $query);
            header("Location: routing.php?id=$id");
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
        <li>Forms</li>
        <li><a href="">General</a></li>
    </ul>
    <!-- END Forms General Header -->
    <div class="row">
        <div class="col-md-6">
            <!-- Horizontal Form Block -->
            <div class="block">
                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2><strong>New</strong> Date</h2>
                </div>
                <!-- END Horizontal Form Title -->

                <!-- Horizontal Form Content -->
                <form action="edate.php?id=<?php echo $id . '&did=' . $date_id ; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="city">Location</label>
                        <div class="col-md-9">
                            <input type="text" id="autoc" class="form-control" value="<?php echo $in[0]; ?>">
                        </div>
                    </div>
                        <input id="geobytescity" name="city" type="hidden">
                        <input id="geobytesinternet" name="country" type="hidden">
                        <input id="geobyteslatitude" name="lat" type="hidden">
                        <input id="geobyteslongitude" name="long" type="hidden">
                        <input id="geobytestimezone" name="time_zone" type="hidden">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="country">Country</label>
                        <div class="col-md-9">
                            <input type="text" id="geobytescountry" class="form-control" readonly="readonly"  value="<?php echo $in[1]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="date">Timeframe</label>
                        <div class="col-md-9">
                            <input type="text" id="date" name="date" class="form-control" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" value="<?php echo $in[2]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="flexibility">Flexibility</label>
                        <div class="col-md-9">
                            <select id="flexibility" name="flexibility" class="form-control" size="1">
                                <option <?php if ($in[3] == 0) { echo 'selected="selected"'; } ?> value="0">None</option>
                                <option <?php if ($in[3] == 1) { echo 'selected="selected"'; } ?> value="1">1 day</option>
                                <option <?php if ($in[3] == 2) { echo 'selected="selected"'; } ?> value="2">3 days</option>
                                <option <?php if ($in[3] == 3) { echo 'selected="selected"'; } ?> value="3">1 week</option>
                                <option <?php if ($in[3] == 4) { echo 'selected="selected"'; } ?> value="4">2 weeks</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Update</button>
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
<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/flick/jquery-ui.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
        $( "#date" ).datepicker({
            inline: true,
            dateFormat: 'dd/mm/yy'
        });
    });
</script>
<script type="text/javascript">
jQuery(function () 
    {
        jQuery("#autoc").autocomplete({
            source: function (request, response) {
                jQuery.getJSON(
                    "http://gd.geobytes.com/AutoCompleteCity?callback=?&q="+request.term,
                        function (data) {
                        response(data);
                    }
                );
            },
            minLength: 3,
            select: function (event, ui) {
                var selectedObj = ui.item;
                jQuery("#autoc").val(selectedObj.value);
                getcitydetails(selectedObj.value);
                return false;
            },
            open: function () {
                jQuery(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                jQuery(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            },
            change: function( event, ui ) {
                    if (ui.item == null || ui.item == "") {
                    $("#sendstuff").attr("disabled", true);
                        $("#sendstuff").removeClass( "btn-primary" );
                        $("#sendstuff").addClass( "btn-disabled" );
                        $('#autoc').attr('placeholder', 'Record not found. Please search again');
                        $('#autoc').val('');
                        $('#autoc').click(function() {
                            $("#sendstuff").attr("disabled", false);
                            $("#sendstuff").addClass( "btn-primary" );
                            $('#autoc').attr('placeholder', '');
                        });
                    }   
            }
        });
        jQuery("#autoc").autocomplete("option", "delay", 100);
    });
</script>
<script type="text/javascript">
function getcitydetails(fqcn) {

    if (typeof fqcn == "undefined") fqcn = jQuery("#f_elem_city").val();

    cityfqcn = fqcn;

    if (cityfqcn) {

     jQuery.getJSON(
            "http://gd.geobytes.com/GetCityDetails?callback=?&fqcn="+cityfqcn,
         function (data) {
         jQuery("#geobytescity").val(data.geobytescity);
         jQuery("#geobytesinternet").val(data.geobytesinternet);
         jQuery("#geobytescountry").val(data.geobytescountry);
         jQuery("#geobyteslatitude").val(data.geobyteslatitude);
         jQuery("#geobyteslongitude").val(data.geobyteslongitude);
         jQuery("#geobytestimezone").val(data.geobytestimezone);
         jQuery("#geobytescountry").val(data.geobytescountry);
         }
     );
    }
}
</script>
<?php include 'inc/template_end.php'; ?>