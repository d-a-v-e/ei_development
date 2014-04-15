<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>

<!-- Page content -->
<div id="page-content">
    <!-- Dashboard Header -->
    <!-- For an image header add the class 'content-header-media' and an image as in the following example -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <div class="row">
                <!-- Main Title (hidden on small devices for the statistics to fit) -->
                <div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
                    <h1>Welcome <strong><?php echo $_SESSION['firstname'] ; ?></strong></h1>
                </div>
                <!-- END Main Title -->

                <!-- Top Stats -->
                <div class="col-md-8 col-lg-6">
                    <div class="row text-center">
                        <div class="col-xs-4 col-sm-3">
                            <h2 class="animation-hatch">
                                <strong></strong><br>
                                <small><i class=""></i></small>
                            </h2>
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <h2 class="animation-hatch">
                                <strong> 3 </strong><br>
                                <small><i class="fa fa-suitcase"></i> Live</small>
                            </h2>
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <h2 class="animation-hatch">
                                <strong> 4 </strong><br>
                                <small><i class="gi gi-chat"></i> Open</small>
                            </h2>
                        </div>
                        <!-- We hide the last stat to fit the other 3 on small devices -->
                        <div class="col-sm-3 hidden-xs">
                            <h2 class="animation-hatch">
                                <strong> 5 </strong><br>
                                <small><i class="fa fa-calendar-o"></i> Upcoming</small>
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- END Top Stats -->
            </div>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="img/placeholders/headers/dashboard_header.jpg" alt="header image" class="animation-pulseSlow">
    </div>
    <!-- END Dashboard Header -->

    <!-- Mini Top Stats Row -->
    <div class="row">
        <div class="col-sm-6 col-lg-4">
            <!-- Widget -->
            <div class="widget">
                <div class="widget-simple">
                    <a href="tours/index.php" class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                        <i class="fa fa-suitcase"></i>
                    </a>
                    <h3 class="widget-content text-right animation-pullDown">
                        <strong>Tours</strong><br>
                        <a href="#"><small>+ New</small></a>
                    </h3>
                </div>
            </div>
            <!-- END Widget -->
        </div>
        <div class="col-sm-6 col-lg-4">
            <!-- Widget -->
            <div class="widget">
                <div class="widget-simple">
                    <a href="campaigns/index.php" class="widget-icon pull-left themed-background-spring animation-fadeIn">
                        <i class="gi gi-chat"></i>
                    </a>
                    <h3 class="widget-content text-right animation-pullDown">
                        <strong>Campaigns</strong><br>
                        <a href=""><small>+ New</small></a>
                    </h3>
                </div>
            </div>
            <!-- END Widget -->
        </div>
       
        <div class="col-sm-6 col-lg-4">
            <!-- Widget -->
            <div class="widget">
                <div class="widget-simple">
                    <a href="faq.php" class="widget-icon pull-left themed-background-amethyst animation-fadeIn">
                        <i class="gi gi-circle_question_mark"></i>
                    </a>
                    <h3 class="widget-content text-right animation-pullDown">
                        <strong>FAQ</strong>
                        <small>Terms, privacy etc</small>
                    </h3>
                </div>
            </div>
            <!-- END Widget -->
        </div>

        <div class="col-sm-6">
            <!-- Widget -->
            <div class="widget">
                <div class="widget-simple">
                    <a href="page_widgets_stats.php" class="widget-icon pull-left themed-background animation-fadeIn">
                        <i class="gi gi-circle_plus"></i>
                    </a>
                    <h2 class="widget-content text-right animation-pullDown">
                        <strong> Reports</strong>
                        <a href="#"><small>+ New</small></a>
                    </h2>
                </div>
            </div>
            <!-- END Widget -->
        </div>

        <div class="col-sm-6 col-lg-6">
            <!-- Calender Widget -->
            <div class="widget">
                <div class="widget-simple">
                    <a href="javascript:void(0)" class="widget-icon pull-left animation-fadeIn themed-background">
                        <i class="fa fa-calendar"></i>
                    </a>
                    <h2 class="widget-content animation-pullDown text-right">
                        View <strong>Calendar</strong>
                    </h2>
                </div>
            </div>
            <!-- END Widget -->
        </div>
    </div>

    <!-- Widgets Row -->
    <div class="row">
        <div class="col-md-6">
            <!-- Timeline Widget -->
            <div class="widget">
                <div class="widget-extra themed-background-dark">
                    <div class="widget-options">
                        <div class="btn-group btn-group-xs">
                            <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Edit Widget"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Quick Settings"><i class="fa fa-cog"></i></a>
                        </div>
                    </div>
                    <h3 class="widget-content-light">
                        Latest <strong>Updates</strong>
                        <small><a href="page_ready_timeline.php"><strong>View all</strong></a></small>
                    </h3>
                </div>
                <div class="widget-extra">
                    <!-- Timeline Content -->
                    <div class="timeline">
                        <ul class="timeline-list">
                            <li class="active">
                                <div class="timeline-icon"><i class="fa fa-file-text"></i></div>
                                <div class="timeline-time"><small>just now</small></div>
                                <div class="timeline-content">
                                    <p class="push-bit"><a href="page_ready_user_profile.php"><strong>Mitch Mitchells</strong></a></p>
                                    <p class="push-bit"><strong>New Docs Added: </strong>Blood Orange tour</p>
                                    <p class="push-bit"><a href="page_ready_article.php" class="btn btn-xs btn-primary"><i class="fa fa-file"></i> View Campaign</a></p>
                                    <div class="row push">
                                        <div class="col-sm-6 col-md-4">
                                            <a href="img/placeholders/photos/photo1.jpg" data-toggle="lightbox-image">
                                                <img src="img/placeholders/photos/photo1.jpg" alt="image">
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <a href="img/placeholders/photos/photo22.jpg" data-toggle="lightbox-image">
                                                <img src="img/placeholders/photos/photo22.jpg" alt="image">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="active">
                                <div class="timeline-icon themed-background-fire themed-border-fire"><i class="hi hi-cog"></i></div>
                                <div class="timeline-time"><small>5 min ago</small></div>
                                <div class="timeline-content">
                                    <p class="push-bit"><a href="page_ready_user_profile.php"><strong>Administrator</strong></a></p>
                                    <strong>New Users Added: </strong> Tony Wilson
                                    <p class="push-bit"><a href="page_ready_user_profile.php"></a></p>
                                    <strong>New Users Added: </strong> Martin Hannett
                                </div>
                            </li>
                            <li class="active">
                                <div class="timeline-icon"><i class="gi gi-bank"></i></div>
                                <div class="timeline-time"><small>3 hours ago</small></div>
                                <div class="timeline-content">
                                    <p class="push-bit"><a href="page_ready_user_profile.php"><strong>Charlie Watts</strong></a></p>
                                    <p class="push-bit"><strong>New Venue Added: </strong> The Gasometer</p>
                                    <div id="gmap-timeline" class="gmap"></div>
                                </div>
                            </li>
                            <li class="active">
                                <div class="timeline-icon themed-background-fire themed-border-fire"><i class="hi hi-cog"></i></div>
                                <div class="timeline-time"><small>2 days ago</small></div>
                                <div class="timeline-content">
                                    <p class="push-bit"><a href="page_ready_user_profile.php"><strong>Administrator</strong></a></p>
                                    To thank you all for your support we would like to let you know that you will receive free feature updates for life! You are awesome!
                                </div>
                            </li>
                            <li class="active">
                                <div class="timeline-icon"><i class="hi hi-map-marker"></i></div>
                                <div class="timeline-time"><small>1 week ago</small></div>
                                <div class="timeline-content">
                                    <p class="push-bit"><a href="page_ready_user_profile.php"><strong>Nikki Sixx</strong></a></p>
                                    <strong>New Dates Added to: </strong> Blood Orange 2014 Summer Tour
                                    <p class="push-bit"><a href="page_ready_article.php" class="btn btn-xs btn-primary"><i class="fa fa-file"></i> View Campaign</a></p>
                                </div>
                            </li>
                            <li class="text-center">
                                <a href="javascript:void(0)" class="btn btn-xs btn-default">View more..</a>
                            </li>
                        </ul>
                    </div>
                    <!-- END Timeline Content -->
                </div>
            </div>
            <!-- END Timeline Widget -->
        </div>
        <div class="col-md-6">
            

        <!-- How it works widget -->
            <div class="widget">
                <div class="widget-simple themed-background-dark">
                    <a href="javascript:void(0)" class="widget-icon pull-right themed-background">
                        <i class="gi gi-airplane animation-floating"></i>
                    </a>
                    <h4 class="widget-content widget-content-light">
                        Ei <strong>Tour Planning:</strong>
                        <small><a href="faq.php">How it works...</a></small>
                    </h4>
                </div>
                
                <div class="widget-extra">
                    <h4 class="sub-header">Summary</h4>
                    <p>Entertainment Intelligence is a platform independent consultancy providing unique solutions for the industry we love. From artist campaigns to brand engagement, tour planning to payment services, we evaluate requirements and work with suppliers to deliver the best possible result for our clients and their customers.</p> <p>If you want to know more get in touch at <a href='mailto:info@entertainment-intelligence.com' >info@entertainment-intelligence.com</a>, we look forward to hearing from you.</p>
                </div>
            </div>
            <!-- END Active Theme Color Widget with Extra Content -->

            <!-- Advanced Gallery Widget -->
            <div class="widget">
                <div class="widget-advanced">
                    <!-- Widget Header -->
                    <div class="widget-header text-center themed-background-dark">
                        <h3 class="widget-content-light clearfix">
                            <strong>Documents</strong><br>
                            <small>4 Items</small>
                        </h3>
                    </div>
                    <!-- END Widget Header -->

                    <!-- Widget Main -->
                    <div class="widget-main">
                        <a href="page_comp_gallery.php" class="widget-image-container">
                            <span class="widget-icon themed-background"><i class="gi gi-picture"></i></span>
                        </a>
                        <div class="gallery gallery-widget" data-toggle="lightbox-gallery">
                            <div class="row">
                                <div class="col-xs-6 col-sm-3">
                                    <a href="img/placeholders/photos/photo15.jpg" class="gallery-link" title="Image Info">
                                        <img src="img/placeholders/photos/photo15.jpg" alt="image">
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <a href="img/placeholders/photos/photo5.jpg" class="gallery-link" title="Image Info">
                                        <img src="img/placeholders/photos/photo5.jpg" alt="image">
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <a href="img/placeholders/photos/photo6.jpg" class="gallery-link" title="Image Info">
                                        <img src="img/placeholders/photos/photo6.jpg" alt="image">
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <a href="img/placeholders/photos/photo13.jpg" class="gallery-link" title="Image Info">
                                        <img src="img/placeholders/photos/photo13.jpg" alt="image">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Widget Main -->
                </div>
            </div>
            <!-- END Advanced Gallery Widget -->
        </div>
    </div>
    <!-- END Widgets Row -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include 'inc/template_scripts.php'; ?>

<!-- Google Maps API + Gmaps Plugin, must be loaded in the page you would like to use maps (Remove 'http:' if you have SSL) -->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="js/helpers/gmaps.min.js"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/index.js"></script>
<script>$(function(){ Index.init(); });</script>
<script type="text/javascript">
    (function($) {
            var url = 'http://www.biota-labs.com/ei/sales/ei_return_sales_campaigns.php?clientid=1';

            $.ajax({
               type: 'GET',
                url: url,
                async: false,
                jsonpCallback: 'jsonCallback',
                contentType: "application/json",
                dataType: 'jsonp',
                success: function(json) {
                   console.dir(json.sites);
                },
                error: function(e) {
                   console.log(e.message);
                }
            });

            })(jQuery);
</script>

<?php include 'inc/template_end.php'; ?>