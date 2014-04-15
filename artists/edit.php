<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php

    $artist_id = $_GET['id'];

    $_SESSION['message'] = '';
    $_SESSION['alert'] = '';
    $_SESSION['msgicon'] = '';
    $_SESSION['pop'] = '';

    $sql = "SELECT a.id, a.name, a.label, a.city, a.genre, a.country, a.description FROM artist AS a WHERE id = {$artist_id}";
    $data = mysqli_query($connection, $sql) or die();
    $art = mysqli_fetch_row($data);
    if (substr($art[1], strlen($art[1]) - 5, strlen($art[1])) === ", The") {
        $art[1] = "The " . substr($art[1], 0, strlen($art[1]) - 5);
    }

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = strtolower($name);
    $subname = substr($name, 0, 4 - strlen($name));

    if ($subname === 'the ') {
        // Band starts with "The "
        $searchname = substr($name, 4, strlen($name) - 4);
        $dbname = ucfirst($searchname) . ", The";
    } else {
        // Band doesnt start with "The "
        echo "No Match";
        $dbname = ucfirst($name);
        $searchname = $dbname;
    }

    $sql = "SELECT name, id FROM artist WHERE (name LIKE '%{$searchname}' OR name LIKE '%{$dbname}')";
    $result = mysqli_query($connection, $sql);
    $d = mysqli_fetch_row($result);

    if ($result && mysqli_affected_rows($connection) > 0 && $d[1] !== $artist_id){
            $_SESSION['message'] = 'Artist already exists - ' . $d[0];
            $_SESSION['alert'] = 'warning';
            $_SESSION['msgicon'] = 'exclamation';
            $_SESSION['pop'] = $d[0];
    } else {
        $sql = "UPDATE artist SET ";
        $counter = sizeof($_POST);
        echo $counter . "<br>";
        foreach ($_POST as $key => $value) {
            if (!empty($value)) {
            $sql .= "$key = '{$value}', ";
            }
        }
        $sql .= "datechanged = NOW() WHERE id = {$artist_id}";
        $result = mysqli_query($connection, $sql);
        
        if ($result && mysqli_affected_rows($connection) >= 0) {
                header("Location: edit.php?id=$artist_id");
        } else {
            $_SESSION['message'] = 'Artist could not be updated';
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
            <h1><strong><?php echo $art[1]; ?></strong></h1> Edit <br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php">Artists</a></li>
        <li><a href="profile.php?id=<?php echo $art[0]; ?>"><?php echo $art[1]; ?></a></li>
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
            <div class="block">
                <div class="block-title">
                    <h2><strong>Edit</strong> Artist</h2>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name" >Artist Name</label>
                        <div class="col-md-9">
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $art[1]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="country">Country</label>
                        <div class="col-md-9">
                            <select name="country" class="select-chosen">
                                    <option value="">Select a Country...</option>
                                    <?php 
                                        $in = mysqli_query($connection, "SELECT iso_alpha2, name FROM currencies AS c ORDER BY name");
                                        while ($venue = mysqli_fetch_row($in)) {
                                        if ($venue[0] === $art[5]) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="' . $venue[0] . '" ' . $selected . ' >' . $venue[1] . ' </option>';
                                        }
                                    ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="city">Hometown</label>
                        <div class="col-md-9">
                            <input type="text" id="city" name="city" class="form-control" value="<?php echo $art[3]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="label">Label</label>
                        <div class="col-md-9">
                            <input type="text" id="label" name="label" class="form-control" value="<?php echo $art[2]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="genre">Genre</label>
                        <div class="col-md-9">
                            <input type="text" id="genre" name="genre" class="form-control" value="<?php echo $art[4]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">Description</label>
                        <div class="col-md-9">
                            <textarea type="text" rows="3" id="description" name="description" class="form-control"><?php echo $art[6]; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="gi gi-star"></i> Update</button>
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