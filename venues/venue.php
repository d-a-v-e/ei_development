<?php include '../tours/inc/config.php'; ?>
<?php include '../inc/db_connection.php'; ?>
<?php include '../tours/inc/permissions.php'; ?>
<?php include '../tours/inc/template_start.php'; ?>
<?php include '../tours/inc/page_head.php'; ?>
<?php
    $id = $_GET['id'];
    $sql = "SELECT v.name, v.location, c.name, v.postzip, v.website, v.greenroom, v.loadingbay, v.reserved_seating, v.description, v.box_office_phone, v.box_office_email, v.bookings_phone, v.bookings_email, v.mainpicture FROM venue AS v JOIN currencies AS c ON v.country = c.iso_alpha2 WHERE id = {$id}";
    $data = mysqli_query($connection, $sql);
    $ven = mysqli_fetch_row($data);

    $sql = "SELECT name, seating, standing, mixed_seating, mixed_standing FROM venue_levels WHERE venueid = {$id} AND recordstatus = 1";
    $result = mysqli_query($connection, $sql);
 ?>
<div id="page-content">
<div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong><?php echo $ven[0]; ?></strong></h1><br>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../">Home</a></li>
        <li><a href="index.php">Venues</a></li>
        <li><?php echo $ven[0]; ?></li>
    </ul>
    <div class="row">
        <div class="col-md-6">
        <div class="block">
                <div class="block-advanced block-advanced-alt">
                    <div class="block-title">
                        <div class="block-options pull-right">
                                <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="photo.php?id=<?php echo $id; ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Upload Photo"><i class="fa fa-camera"></i></a>
                        </div>
                <?php 
                    if (!empty($ven[13])) {
                        echo '<img src="../img/venues/'.$id.'/'.$ven[13].'" alt="background" width="100%">';
                    }
                ?>
                </div>
                    <div class="block-main">
                        <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Location </strong></td>
                            <td><span class="pull-right"><?php echo $ven[1] . ', ' . $ven[2] . '<br>' . $ven[3];  ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Website </strong></td>
                            <td><span class="pull-right"><?php echo '<a href="' . $ven[4] . '">' . $ven[4] . '</a>'; ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Access</strong></td>
                            <td><span class="pull-right">
                            <?php 
                                if ($ven[5]) { echo '<span class="label label-info">Green Room</span> '; }
                                if ($ven[6]) { echo '<span class="label label-info">Loading Bay</span> '; }
                                if ($ven[7]) { echo '<span class="label label-info">Reserved Seating</span> '; } 
                            ?>
                            </span></td>
                        </tr>
                        <tr>
                            <td><strong>Description </strong></td>
                            <td><span class="pull-right"><?php echo $ven[8] ?></span></td>
                        </tr>
                    </tbody>
                </table>
                    </div>
                    <!-- END Widget Main -->
                </div>
            </div>
            <div class="block">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </div>
                    <h2><strong>Contact Info</strong></h2>
                </div>
                <table class="table table-borderless table-striped">
                    <thead>
                        <tr  align="center">
                            <td><strong></strong></td>
                            <td><strong>Tel</strong></td>
                            <td><strong>Email</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Box Office</strong></td>
                            <td align="center"><span><?php if ($ven[9]) { echo $ven[9]; } else{ echo "No info"; } ?></span></td>
                            <td align="center"><span><?php if ($ven[10]) { echo $ven[10]; } else{ echo "No info"; } ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Bookings</strong></td>
                            <td align="center"><span><?php if ($ven[11]) { echo $ven[11]; } else{ echo "No info"; } ?></span></td>
                            <td align="center"><span><?php if ($ven[12]) { echo $ven[12]; } else{ echo "No info"; } ?></span></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Block with Options Left -->
            <div class="block">
                <!-- Block with Options Left Title -->
                <div class="block-title clearfix">
                    <div class="block-options pull-left">
                        <div class="btn-group btn-group-sm">
                            <a href="levels.php?id=<?php echo $id; ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                    <h2 class="pull-right"><strong>Capacity</strong></h2>
                </div>
                <table class="table table-borderless table-striped">
                <?php 
                if (!empty($result)) {
                        echo '
                                <thead>
                                    <tr  align="right">
                                        <td  align="left"><strong>Level</strong></td>
                                        <td><strong>Seated</strong></td>
                                        <td><strong>Standing</strong></td>
                                        <td><strong>Mixed <small>(Seats/Stand)</small></strong></td>
                                    </tr>
                                </thead>
                            <tbody>';

                        while ($levels = mysqli_fetch_row($result)) {
                            echo 
                                '
                                <tr>
                                    <td><strong>' . $levels[0] . '</strong></td>
                                    <td  align="right">' . $levels[1] . '</td>
                                    <td  align="right">' . $levels[2] . '</td>
                                    <td  align="center">' . $levels[3] . '/' . $levels[4] . '</td>
                                </tr>
                                ';
                        }
                    } else {
                        echo
                        '<h4>No Level Information</h4>
                        <strong><a href="new_level.php?id=' . $id . '"> + Add</a></strong>';
                    }
                    ?>
                </table>
            </div>
            <div class="block full">
                <!-- Geolocation Title -->
                <div class="block-title">
                    <h4><strong>Geolocation</strong> Map</h4>
                </div>
                <div id="gmap" class="gmap"></div>
        </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
<?php include '../inc/page_footer.php'; ?>
<?php include '../inc/template_scripts.php'; ?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="../js/helpers/gmaps.min.js"></script>

<!-- Load and execute javascript code used only in this page -->
<script>$(function(){ CompMaps.init(); });</script>
<script type="text/javascript">
    var CompMaps = function() {
    return {
        init: function() {
            $('.gmap').css('height', '350px');
            new GMaps({
                div: '#gmap',
                lat: 0,
                lng: 0,
                zoom: 3,
                scrollwheel: false
            })
        }
    };
}();
</script>
<?php include '../inc/template_end.php'; ?>