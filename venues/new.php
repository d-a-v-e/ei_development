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

if (isset($_POST['submit'])) {

    if (isset($_POST["greenroom"])) {
        $greenroom = $_POST["greenroom"];
    } else {
        $greenroom = 0;
    } 
    if (isset($_POST["loadingbay"])) {
        $loadingbay = $_POST["loadingbay"];
    } else {
        $loadingbay = 0;
    }
    if (isset($_POST["reserved_seating"])) {
        $reserved_seating = $_POST["reserved_seating"];
    } else {
        $reserved_seating = 0;
    }

    $name = $_POST["name"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $lat = $_POST["lat"];
    $long = $_POST["long"];
    $postzip = $_POST["postzip"];
    $description = $_POST["description"];
    $Website = $_POST['website'];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];

    if ($country === 'UK') {
        $country = 'GB';
    }

    $sql = "SELECT name FROM venue WHERE name LIKE '%{$_POST['name']}'";
    $result = mysqli_query($connection, $sql);
    $d = mysqli_fetch_row($result);
    if ($result && mysqli_affected_rows($connection) > 0){
            $_SESSION['message'] = 'Venue already exists - ' . $d[0];
            $_SESSION['alert'] = 'warning';
            $_SESSION['msgicon'] = 'exclamation';
            $_SESSION['pop'] = $d[0];
    } else {
        $sql = "INSERT INTO venue SET ";
        $sql .= " creator_id = {$userid}, name = '{$name}', location = '{$city}', country = '{$country}', lattitude = '{$lat}', longitude = '{$long}', postzip = '{$postzip}', greenroom = '{$greenroom}', loadingbay = '{$loadingbay}', reserved_seating = '{$reserved_seating}', website = '{$website}', recordstatus = 1, datecreated = NOW()";
        if (!empty($description)) {
            $sql .= " description = '{$description}' ";
        }

         //create company record for venue
            $sql2 = "INSERT INTO company SET name = '{$name}', companytypeid = 5, description = '{$description}', recordstatus = 1, datecreated = NOW() ";
            mysqli_query($connection, $sql2);
            $companyid = mysqli_insert_id($connection);
            $sql2 = "INSERT INTO office SET companyid = {$companyid}, office_name = '{$name}', town = '{$city}', country = '{$country}', address3 = '{$postzip}', recordstatus = 1, datecreated = NOW() ";
            mysqli_query($connection, $sql2);
            $officeid = mysqli_insert_id($connection);
            $sql2 = "INSERT INTO users SET companyid = {$companyid}, officeid = {$officeid}, firstname = '{$firstname}', lastname = '{$lastname}', email = '{$email}', recordstatus = 1, datecreated = NOW() ";
            mysqli_query($connection, $sql2);

        $result = mysqli_query($connection, $sql);
        $insert = mysqli_insert_id($connection);
        
        if ($result && mysqli_affected_rows($connection) >= 0) {
            if (isset($_SERVER['QUERY_STRING'])) {
                header("Location: ../tours/quick_add.php?id={$id}&in={$insert}");
            } else {
                header("Location: ../index.php");
            }
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
        <li>New</li>

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
                    <h2><strong>Add</strong> Venue</h2>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label" > Contact Name </label>
                        <div class="col-md-4">
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email" > Contact Email </label>
                        <div class="col-md-9">
                                <input type="text" id="email" name="email" class="form-control" placeholder="someone@example.com" required>
                        </div>
                    </div>
                    <legend></legend>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name" > Name</label>
                        <div class="col-md-9">
                            <input type="text" id="name" name="name" class="form-control" value="<?php if (isset($_SESSION['pop'])) { echo $_SESSION['pop']; } ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="city">Location</label>
                        <div class="col-md-9">
                            <input type="text" id="autoc" title="type &quot;a&quot;" class="form-control" >
                        </div>
                        <input id="geobytescity" name="city" type="hidden">
                        <input id="geobytesinternet" name="country" type="hidden">
                        <input id="geobyteslatitude" name="lat" type="hidden">
                        <input id="geobyteslongitude" name="long" type="hidden">
                        <input id="geobytestimezone" name="time_zone" type="hidden">
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="country">Country</label>
                        <div class="col-md-9">
                            <input type="text" id="geobytescountry" class="form-control" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="postzip">Post/Zip Code</label>
                        <div class="col-md-9">
                            <input type="text" id="postzip" name="postzip" class="form-control" required>
                        </div>
                    </div>
                     <div class="form-group">
                     <label class="col-md-3 control-label" for="postzip">Venue Specifics</label>
                        <div class="col-md-9">
                            <label class="checkbox-inline" for="greenroom">
                                <input type="checkbox" id="greenroom" name="greenroom" value="1"> Green Room
                            </label>
                            <label class="checkbox-inline" for="loadingbay">
                                <input type="checkbox" id="loadingbay" name="loadingbay" value="1"> Loading Bay
                            </label>
                            <label class="checkbox-inline" for="reserved_seating">
                                <input type="checkbox" id="reserved_seating" name="reserved_seating" value="1"> reserved Seating
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="website">Website</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" id="website" name="website" class="form-control" value="http://">
                                <span class="input-group-addon"><i class="gi gi-globe"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">Description (Optional)</label>
                        <div class="col-md-9">
                            <input type="text" id="description" name="description" class="form-control">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="gi gi-bank"></i> Add</button>
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