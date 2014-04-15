<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    $sql = "SELECT name, artist, company FROM campaigns WHERE id = {$id}";
                $data = mysqli_query($connection, $sql) or die();
                $info = mysqli_fetch_row($data);
    $sql = "SELECT city, date, lat, `long`, time_zone FROM routing WHERE campaign_id = {$id} AND recordstatus = 1 ORDER BY date ";
    $dates = mysqli_query($connection, $sql) or die();
    $number = mysqli_num_rows($dates);
    $c = 1;
    $coords = "";
    $path = "[";
        while ($i = mysqli_fetch_row($dates)) {
            $lat[] = $i[2];
            $long[] = $i[3];
            if ($c < $number) {
                if (!is_null($i[2]) && !is_null($i[3])) {
                $path .= "[" . $i[2] . ", " . $i[3] . "]," ;
                $coords .=  "{lat: ". $i[2] . ", lng: " . $i[3] . ", title: '" . $i[0] . ", " . $i[1] . "', animation: google.maps.Animation.DROP, infoWindow: {content: '<strong>" . $i[0] . ", " . $i[1] . "</strong>'}},\n";
                }
            } else {
                $path .= "[" . $i[2] . ", " . $i[3] . "]" ;
                $coords .=  "{lat: ". $i[2] . ", lng: " . $i[3] . ", title: '" . $i[0] . ", " . $i[1] . "', animation: google.maps.Animation.DROP, infoWindow: {content: '<strong>" . $i[0] . ", " . $i[1] . "</strong>'}}";
            }
        }
    $path .= "]";
    $lat = array_sum($lat)/count($lat);
    $long = array_sum($long)/count($long); 
?>
<div id="page-content">
    <!-- Maps Header -->
    <!-- For a map header add the class 'content-header-media' and init a map in a div as in the following example -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Routing</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>"> Tour</a></li>
        <li>Routing</li>
    </ul>
    <div class="block full">
        <div class="block-title">
            <h4><strong>Routing</strong> <small> &bull; <a href="routing.php?id=<?php echo $id ?>" > <i class="fa fa-map text-primary"></i>View List</a></small></h4>
        </div>
        <div id="gmap-markers" class="gmap"></div>
    </div>
</div>

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Google Maps API + Gmaps Plugin, must be loaded in the page you would like to use maps (Remove 'http:' if you have SSL) -->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="../js/helpers/gmaps.min.js"></script>

<!-- Load and execute javascript code used only in this page -->
<script>$(function(){ CompMaps.init(); });</script>
<script type="text/javascript">
    var CompMaps = function() {
    return {
        init: function() {
            var path = <?php echo $path ?>;
            $('.gmap').css('height', '350px');
            new GMaps({
                div: '#gmap-markers',
                lat: <?php echo $lat; ?>,
                lng: <?php echo $long; ?>,
                zoom: 3,
                scrollwheel: false
            }).drawPolyline({
                  path: path,
                  strokeColor: '#131540',
                  strokeOpacity: 0.8,
                  strokeWeight: 3
                });
            map.addMarkers([<?php echo $coords ?>]);
        }
    };
}();
</script>
<?php include 'inc/template_end.php'; ?>