<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET["id"];
    $userid = $_SESSION['userid'];


$results = mysqli_query($connection,"SELECT COUNT(id) FROM history WHERE campaignid = {$id}");
$get_total_rows = mysqli_fetch_array($results); //total records

//break total records into pages
$item_per_page = 10;
$total_pages = ceil($get_total_rows[0]/$item_per_page); 
    
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

    if ($m01s04 == 1) {

        $sql = "SELECT companyid, routing_promoters.date_id, routing_promoters.campaign_id\n"
        . "FROM users \n"
        . "JOIN routing_promoters on users.companyid = routing_promoters.promoter_id \n"
        . "WHERE users.id = {$userid}\n"
        . "LIMIT 1";

        $data = mysqli_query($connection, $sql);
        $pro = mysqli_fetch_row($data);
        $pro[1] = rtrim($pro[1], ',');

        $sql = "SELECT DISTINCT routing.id, routing.city, countries.name, routing.date, routing.flexibility FROM routing_promoters, routing INNER JOIN countries on countries.code = routing.country WHERE promoter_id = {$pro[0]} AND routing.id IN ($pro[1]) AND routing.recordstatus = 1 AND routing_promoters.campaign_id = {$id} ";
        
//        echo '<br>' . $sql;

    } else {
        $sql = "SELECT routing.id, routing.city, countries.name, routing.date, routing.flexibility\n"
        . "FROM routing\n"
        . "INNER JOIN `countries` on countries.code = routing.country\n"
        . "WHERE campaign_id = {$id} AND recordstatus = 1 ORDER BY date ASC LIMIT 5";
    }    

    $dates = mysqli_query($connection, $sql) ;

    $sql = "SELECT COUNT(id) FROM documents WHERE campaign_id = {$id}";
                $val = mysqli_query($connection, $sql) or die();
                $doc_count = mysqli_fetch_row($val);

    $sql = "SELECT id, name FROM documents WHERE campaign_id = {$id}";
                $docs = mysqli_query($connection, $sql) or die();

?>

<!-- Page content -->
<div id="page-content">
    <!-- User Profile Header -->
    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong><?php echo $info[1] ?></strong><br><?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <!-- END User Profile Header -->

    <!-- User Profile Content -->
    <div class="row">
        <!-- First Column -->
        <div class="col-md-6 col-lg-7">
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
            </div>
            <!-- Advanced Specific Theme Color Widget -->
            <div class="widget">
                <div class="widget-advanced animation-fadeIn">
                    <!-- Widget Header -->
                    <div class="widget-header text-center themed-background-dark">
                        <h3 class="widget-content-light clearfix">
                            <strong>Routing</strong><br>
                        </h3>
                    </div>
                    <!-- END Widget Header -->
                    <!-- Widget Main -->
                    <div class="widget-main">
                        <a href="routing.php?id=<?php echo $id; ?>" class="widget-image-container animation-bigEntrance">
                            <span class="widget-icon themed-background"><i class="hi hi-map-marker"></i></span>
                        </a>
                        <table class="table table-borderless table-striped table-condensed table-vcenter">
                            <tbody>
                                <?php 
                                    if ($dates) { 
                                        while ($d = mysqli_fetch_row($dates)) {
                                        $val = mysqli_query($connection, "SELECT COUNT(id) FROM quotes WHERE date_id = {$d[0]} AND recordstatus = 1");
                                        $quote_number= mysqli_fetch_row($val);
                                            $d[3] = date("d/m/Y", strtotime($d[3]));
                                                    switch ($d[4]) {
                                                        case "0":
                                                            $d[4] = "None" ;
                                                            break;
                                                        case "1":
                                                            $d[4] = "1 Day" ;
                                                            break;
                                                        case "2":
                                                            $d[4] = "3 Days" ;
                                                            break;
                                                        case "3":
                                                            $d[4] = "1 Week" ;
                                                            break;
                                                        case "4":
                                                            $d[4] = "2 Weeks" ;
                                                            break;
                                                        default:
                                                            $d[4] = "None" ;
                                                            break;
                                                    }
                                            echo '<tr>
                                                    <td><a href="quotes.php?id=' . $id . '&did=' . $d[0] . '"><strong>' . $d[1] . '</strong></a></td>
                                                    <td class="text-left">' . $d[2] . '</td>
                                                    <td class="text-left">' . $d[3] . '</td>
                                                    <td class="text-left">+/- ' . $d[4] . '</td>
                                                    <td class="text-center" style="width: 50px;">
                                                        <div class="btn-group btn-group-xs">
                                                            <a href="quotes.php?id=' . $id . '&did=' . $d[0] . '" class="btn btn-default" data-toggle="tooltip" title="Quotes"><i class="fa fa-quote-left"></i>(' . $quote_number[0] . ')</a>
                                                        </div>
                                                    </td>
                                                </tr>';
                                        }
                                    } else {
                                        echo
                                        '(No dates)';
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                        <div class="text-center"><a href="routing.php?id=<?php echo $id; ?>">Show all..</a></div>
                    </div>
                    <!-- END Widget Main -->
                </div>
            </div>
            <!-- END Advanced Specific Theme Color Widget -->
            <!-- Terrain Map Block -->
            <div class="block full">
                <!-- Terrain Map Title -->
                <div class="block-title">
                    <h4><strong>Terrain</strong> Map</h4>
                </div>
                <!-- END Terrain Map Title -->

                <!-- Terrain Map Content -->
                <!-- Gmaps.js (initialized in js/pages/compMaps.js), for more examples you can check out http://hpneo.github.io/gmaps/examples.html -->
                <div id="gmap-terrain" class="gmap"></div>
                <!-- END Terrain Map Content -->
            </div>
            <!-- END Terrain Map Block -->

            <!-- Docs Block -->
            <div class="widget">
                <div class="widget-advanced">
                <!-- Widget Header -->
                    <div class="widget-header text-center themed-background-dark">
                        <h3 class="widget-content-light clearfix">
                            <strong>Documents</strong><br>
                            <small><?php echo "(" . $doc_count[0] . " Items)"; ?></small>
                        </h3>
                    </div>
                    <!-- END Widget Header -->
                    <div class="widget-main">
                    <a href="documents.php?id=<?php echo $id; ?>" class="widget-image-container">
                            <span class="widget-icon themed-background"><i class="hi hi-folder-open"></i></span>
                        </a>
                <!-- Photos Content -->
                    <div class="gallery" data-toggle="lightbox-gallery">
                        <div class="row">
                          <?php 
                            while ($d = mysqli_fetch_row($docs)) {
                                // if file ends with .jpg, .jpeg, .gif or .png do image else do paperclip glyph...
                                $ext = pathinfo($d[1], PATHINFO_EXTENSION);
                                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'  || $ext == 'bmp') {
                                    echo 
                                        '<div class="col-xs-6 col-sm-3">
                                            <a href="../img/tours/' . $id . '/' . $d[1] . '" class="gallery-link" title="Image Info">
                                                <img src="../img/tours/' . $id . '/' . $d[1] . '" alt="image">
                                            </a>
                                        </div>';
                                } else {
                                    echo 
                                        '<div class="col-xs-6 col-sm-3">
                                            <a href="../img/placeholders/avatars/avatar.jpg" class="gallery-link" title="Image Info">
                                                <img src="../img/placeholders/avatars/avatar.jpg" alt="image">
                                            </a>
                                        </div>';
                                }
                            }
                        ?>
                        </div>
                    </div>
                </div>
                <!-- END Photos Content -->
            </div>
            </div>
            <!-- END Photos widget -->
        </div>
        <!-- END First Column -->

        <!-- Second Column -->
        <div class="col-md-6 col-lg-5">
        <div class="widget">
                <div class="widget-simple themed-background-dark">
                    <a href="discussions.php?id=<?php echo $id; ?>" class="widget-icon pull-left animation-fadeIn themed-background">
                        <i class="gi gi-chat"></i>
                    </a>
                    <h4 class="widget-content widget-content-light text-right">
                        <a href="discussions.php?id=<?php echo $id; ?>"><strong>Discussions</strong></a>
                    </h4>
                </div>
            </div>
            <div class="widget">
                <div class="widget-extra themed-background-dark">
                    <h3 class="widget-content-light">
                        Latest <strong>News</strong>
                    </h3>
                </div>
                <div class="widget-extra">
                    <!-- Timeline Content -->
                    <div class="timeline">
                        <ul class="timeline-list">
                            <div id="results"></div>
                            <li class="text-center">
                                <button class="load_more btn btn-xs btn-default" id="load_more_button">View More...</button>
                            <div class="animation_image" style="display:none;"><i class="fa fa-spinner fa-2x fa-spin"></i></div>
                            </li>
                        </ul>
                    </div>
                    <!-- END Timeline Content -->
                </div>
            </div>
            <!-- END Newsfeed Block -->
        </div>
        <!-- END Second Column -->
    </div>
    <!-- END User Profile Content -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<script type="text/javascript">
    $(document).ready(function() {

    var track_click = 0; //track user click on "load more" button, righ now it is 0 click
    
    var total_pages = <?php echo $total_pages; ?>;
    var items = <?php echo $item_per_page; ?>;
    var id = <?php echo $id; ?>;
    
$('#results').load("exe/fetch_pages.php", {'page':track_click, 'items':items, 'id':id}, function() {track_click++;}); //initial data to load

    $(".load_more").click(function (e) { //user clicks on button
    
        $(this).hide(); //hide load more button on click
        $('.animation_image').show(); //show loading image

        if(track_click <= total_pages) //user click number is still less than total pages
        {
            //post page number and load returned data into result element
            $.post('exe/fetch_pages.php',{'page':track_click, 'items':items, 'id':id}, function(data) {
            
                $(".load_more").show(); //bring back load more button
                
                $("#results").append(data); //append data received from server
                
                //scroll page smoothly to button id
                //$("html, body").animate({scrollTop: $("#load_more_button").offset().top}, 500);
                
                //hide loading image
                $('.animation_image').hide(); //hide loading image once data is received
    
                track_click++; //user click increment on load button
            
            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                alert(thrownError); //alert with HTTP error
                $(".load_more").show(); //bring back load more button
                $('.animation_image').hide(); //hide loading image once data is received
            });
            
            
            if(track_click >= total_pages-1) //compare user click with page number
            {
                //reached end of the page yet? disable load button
                $(".load_more").attr("disabled", "disabled");
            }
         }
          
        });
});
</script>
<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyProfile.js"></script>
<script>$(function(){ ReadyProfile.init(); });</script>

<?php include 'inc/template_end.php'; ?>