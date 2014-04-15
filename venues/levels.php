<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php
ob_start();
    $id = $_GET['id'];
    $_SESSION['message'] = "";
    $sql = "SELECT v.name, v.location, c.name FROM venue AS v JOIN currencies AS c ON v.country = c.iso_alpha2 WHERE id = {$id}";
    $data = mysqli_query($connection, $sql);
    $ven = mysqli_fetch_row($data);

    $sql = "SELECT id, name, seating, standing, mixed_seating, mixed_standing FROM venue_levels WHERE venueid = {$id} AND recordstatus = 1";
    $result = mysqli_query($connection, $sql);

if (isset($_POST['submit'])) {
    $counter = (sizeof($_POST) - 1)/5; 
    $sql = "";
    for ($i=1; $i <= $counter ; $i++) { 

        if (isset($_POST['mixed_seating' . $i])) {
        $mixed_seating = $_POST['mixed_seating' . $i];
        } else {
            $mixed_seating = "0";
        }
        if (isset($_POST['mixed_standing' . $i])) {
        $mixed_standing = $_POST['mixed_standing' . $i];
        } else {
            $mixed_standing = "0";
        }

        $name = $_POST['name' . $i];
        $arr = array(
        $seating = $_POST['seated' . $i],
        $standing = $_POST['standing' . $i],
        $mixed_seating,
        $mixed_standing,
        );
        var_dump($arr);
    foreach ($arr as $key => $value) {
        if (!ctype_digit($value)) {
            $_SESSION['message'] = "Capacity values must be numeric";
            $_SESSION['alert'] = 'warning';
            $_SESSION['msgicon'] = 'exclamation';
            goto end;
        }
    }
    $sql = "INSERT INTO venue_levels SET venueid = {$id}, name = '{$name}', seating = '{$seating}', standing = '{$standing}', mixed_seating = '{$mixed_seating}', mixed_standing = '{$mixed_standing}', recordstatus = 1, datecreated = NOW()\n";
    echo $sql;
    mysqli_query($connection, $sql) or die("Database error: please try again later");
    header("Location: levels.php?id=$id");
    }
end:
}

ob_flush();

 ?>
<!-- Page content -->
<div id="page-content">
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong><?php echo $ven[0]; ?></strong></h1><h4><?php echo $ven[1] . ', ' . $ven[2]; ?></h4>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="index.php?id=<?php echo $id; ?>">Venues</a></li>
        <li><a href="venue.php?id=<?php echo $id; ?>"><?php echo $ven[0]; ?></a></li>
        <li>Edit Levels</li>
    </ul>
    <!-- END Datatables Header -->
    <div class="row">
        <div class="col-md-12">
        <?php if (!empty($_SESSION['message'])) {
                    echo
                    '<div class="alert alert-' . $_SESSION['alert'] . ' alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="fa fa-' . $_SESSION['msgicon'] . '-circle"></i><p>' . $_SESSION['message'] . '</p>
                    </div>';
                    } 
        ?>
            <div class="block full">
                    <div class="block-title">
                    <div class="block-options pull-right">
                         <a href="new.php" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="New Venue" data-original-title="New Venue"><i class="gi gi-circle_plus"></i></a>
                    </div>
                    <h2>Edit <strong>Levels</strong></h2>
                </div>
                <div class="table-responsive">
                <form action="levels.php?id=<?php echo $id; ?>" method="post">
                    <table class="table table-vcenter table-condensed table-borderless">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Seated</th>
                                <th>Standing</th>
                                <th>Mixed (Seats/Stand)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($info = mysqli_fetch_row($result)) { ?>
                            <tr>
                                <td><?php echo $info[1]; ?></td>
                                <td><?php echo $info[2]; ?></td>
                                <td><?php echo $info[3]; ?></td>
                                <td><?php echo $info[4]; ?>/<?php echo $info[5]; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="exe/remove_level.php?id=<?php echo $info[0] . '&vid=' . $id; ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            <div id="InputsWrapper"></div>
                        </tbody>
                    </table>
                    <p>
                    <div class="btn-group">
                        <button id="AddMoreFileBox" class="btn btn-sm btn-info" data-toggle="tooltip" title="Add Field"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="btn-group form-actions">
                        <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="gi gi-bank"></i> Update</button>
                        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                    </div>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include '../tours/inc/page_footer.php'; ?>
<?php include '../tours/inc/template_scripts.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {

var MaxInputs       = 8; //maximum input boxes allowed
var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
var AddButton       = $("#AddMoreFileBox"); //Add button ID

var x = InputsWrapper.length; //initlal text box count
var FieldCount=1; //to keep track of text box added

$(AddButton).click(function (e)  //on add input button click
{

    if (x === 1){
      $('table').append('<p id="requiredFields"><small>(* = required fields)</small></p>')  
    }
        if(x <= MaxInputs) //max input box allowed
        {
            FieldCount++; //text box added increment
            var fieldIndex = FieldCount - 1;
            $('tbody').append('<tr id="getRidOf" align="left"><td><input size="20" name="name'+fieldIndex+'" required>*</td><td><input size="10" name="seated'+fieldIndex+'" required>*<td><input size="10" name="standing'+fieldIndex+'" required>*</td><td><input size="5" name="mixed_seating'+fieldIndex+'"> <input size="5" name="mixed_standing'+fieldIndex+'"></td><td><button id="removeclass" class="btn btn-xs btn-default" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button></td></tr>');
            x++; //text box increment
        }
return false;
});
$("body").on("click","#removeclass", function(e){ //user click on remove text
        if( x > 1 ) {
                $('#getRidOf').remove(); //remove text box
                x--; //decrement textbox
        }
        if (x <= 1) {
            $('#requiredFields').remove();
        }
return false;
}) 

});
</script>
<?php include '../inc/template_end.php'; ?>