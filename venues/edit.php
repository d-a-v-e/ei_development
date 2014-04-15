<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php 

    $_SESSION['message'] = '';
    $_SESSION['alert'] = '';
    $_SESSION['msgicon'] = '';
    $_SESSION['pop'] = '';
    $userid = $_SESSION['userid'];
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = '';
    }

$sql = "SELECT v.name, v.location, c.name, v.postzip, v.greenroom, v.loadingbay, v.reserved_seating, v.description, v.website FROM venue AS v JOIN currencies AS c ON v.country = c.iso_alpha2 WHERE id = {$id}";
$data = mysqli_query($connection, $sql);
$ven = mysqli_fetch_row($data);

if (isset($_POST['submit'])) {

    if (isset($_POST['country']) && $_POST['country'] === 'UK') {
        $_POST['country'] = 'GB';
    }

    $sql = "SELECT name, id FROM venue WHERE name LIKE '%{$_POST['name']}'";
    $result = mysqli_query($connection, $sql);
    $d = mysqli_fetch_row($result);
    if ($result && mysqli_affected_rows($connection) > 0 && $d[1] !== $id){
            $_SESSION['message'] = 'Venue already exists - ' . $d[0];
            $_SESSION['alert'] = 'warning';
            $_SESSION['msgicon'] = 'exclamation';
            $_SESSION['pop'] = $d[0];
    } else {

        $sql = "UPDATE venue SET ";
        foreach ($_POST as $key => $value) {
            if (!empty($value)) {
                $sql .= " $key = '{$value}', ";
            }
        }
            if (!isset($_POST['greenroom'])) {
                $sql .= " greenroom = '0', ";   
            }
            if (!isset($_POST['loadingbay'])) {
                $sql .= " loadingbay = '0', ";   
            }
            if (!isset($_POST['reserved_seating'])) {
                $sql .= " reserved_seating = '0', ";   
            }

        $sql .= "datechanged = NOW() WHERE id = {$id}";
        echo $sql;
        $result = mysqli_query($connection, $sql);
        $insert = mysqli_insert_id($connection);
        
        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION['message'] = 'Artist updated';
            $_SESSION['alert'] = 'success';
            $_SESSION['msgicon'] = 'check';
            header("Location: venue.php?id=$id");
        } else {
            $_SESSION['message'] = 'Artist could not be crated';
            $_SESSION['alert'] = 'danger';
            $_SESSION['msgicon'] = 'times';
        }
    }
}
?>
<!-- Page content -->
<div id="page-content">
    <!-- Forms General Header -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1>Add <strong>Artist</strong></h1><br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php?id=<?php echo $id; ?>">Venues</a></li>
        <li><a href="venue.php?id=<?php echo $id; ?>"><?php echo $ven[0]; ?></a></li>
        <li>Edit</li>
    </ul>
    <!-- END Forms General Header -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <?php if (!empty($_SESSION['message'])) {
                            echo
                            '<div class="alert alert-' . $_SESSION['alert'] . ' alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="fa fa-' . $_SESSION['msgicon'] . '-circle"></i><p>' . $_SESSION['message'] . '</p>
                            </div>';
                            } 
                ?>
            <!-- Horizontal Form Block -->
            <div class="block">
                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2><strong>Edit</strong> Venue</h2>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name" > Name</label>
                        <div class="col-md-9">
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $ven[0]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="city">Location</label>
                        <div class="col-md-9">
                            <input type="text" id="autoc" title="type &quot;a&quot;" class="form-control" value="<?php echo $ven[1]; ?>">
                        </div>
                        <input id="geobytescity" name="location" type="hidden">
                        <input id="geobytesinternet" name="country" type="hidden">
                        <input id="geobyteslatitude" name="lat" type="hidden">
                        <input id="geobyteslongitude" name="long" type="hidden">
                        <input id="geobytestimezone" name="time_zone" type="hidden">
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="country">Country</label>
                        <div class="col-md-9">
                            <input type="text" id="geobytescountry" class="form-control" value="<?php echo $ven[2]; ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="postzip">Post/Zip Code</label>
                        <div class="col-md-9">
                            <input type="text" id="postzip" name="postzip" class="form-control" value="<?php echo $ven[3]; ?>" required>
                        </div>
                    </div>
                     <div class="form-group">
                     <label class="col-md-3 control-label" for="postzip">Venue Specifics</label>
                        <div class="col-md-9">
                            <label class="checkbox-inline" for="greenroom"> 
                                <input type="checkbox" id="greenroom" name="greenroom" value="1" <?php if ($ven[4] === '1') { echo 'checked'; }  ?> > Green Room
                            </label>
                            <label class="checkbox-inline" for="loadingbay">
                                <input type="checkbox" id="loadingbay" name="loadingbay" value="1" <?php if ($ven[5] === '1') { echo "checked"; }  ?> > Loading Bay
                            </label>
                            <label class="checkbox-inline" for="reserved_seating">
                                <input type="checkbox" id="reserved_seating" name="reserved_seating" value="1" <?php if ($ven[6] === '1') { echo "checked"; }  ?> > Reserved Seating
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="website">Website</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" id="website" name="website" class="form-control" value="<?php if (!empty($ven[8])) { echo $ven[8]; } else { echo "http://"; } ?>">
                                <span class="input-group-addon"><i class="gi gi-globe"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">Description (Optional)</label>
                        <div class="col-md-9">
                            <textarea type="text" rows="2" id="description" name="description" class="form-control"><?php echo $ven[7]; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="gi gi-piano"></i> Update</button>
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
<?php include '../inc/template_end.php'; ?>