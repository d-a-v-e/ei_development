<?php
/**
 * page_head.php
 *
 * Author: pixelcave
 *
 * Header and Sidebar of each page
 *
 */
?>

<!-- Page Container -->
<!-- In the PHP version you can set the following options from inc/config.php file -->
<!--
    Available #page-container classes:

    '' (None)                                       for a full main and alternative sidebar hidden by default (> 991px)

    'sidebar-visible-lg'                            for a full main sidebar visible by default (> 991px)
    'sidebar-partial'                               for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
    'sidebar-partial sidebar-visible-lg'            for a partial main sidebar which opens on mouse hover, visible by default (> 991px)

    'sidebar-alt-visible-lg'                        for a full alternative sidebar visible by default (> 991px)
    'sidebar-alt-partial'                           for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
    'sidebar-alt-partial sidebar-alt-visible-lg'    for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)

    'sidebar-partial sidebar-alt-partial'           for both sidebars partial which open on mouse hover, hidden by default (> 991px)

    'sidebar-no-animations'                         add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!

    'style-alt'                                     for an alternative main style (without it: the default style)
    'footer-fixed'                                  for a fixed footer (without it: a static footer)

    'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
    'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar
-->
<?php
$page_classes = '';

if ($template['header'] == 'navbar-fixed-top') {
    $page_classes = 'header-fixed-top';
} else if ($template['header'] == 'navbar-fixed-bottom') {
    $page_classes = 'header-fixed-bottom';
}

if ($template['sidebar']) {
    $page_classes .= (($page_classes == '') ? '' : ' ') . $template['sidebar'];
}

if ($template['main_style'] == 'style-alt')  {
    $page_classes .= (($page_classes == '') ? '' : ' ') . 'style-alt';
}

if ($template['footer'] == 'footer-fixed')  {
    $page_classes .= (($page_classes == '') ? '' : ' ') . 'footer-fixed';
}
?>
<div id="page-container"<?php if ($page_classes) { echo ' class="' . $page_classes . '"'; } ?>>
    <!-- Main Sidebar -->
    <div id="sidebar">
        <!-- Wrapper for scrolling functionality -->
        <div class="sidebar-scroll">
            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <!-- Brand -->
                <a href="index.php" class="sidebar-brand">
                        <img src="img/eiimg/ei-logo-sidebar.png" alt="ei-logo" width="150px" />
                </a>
                <!-- END Brand -->

                <!-- User Info -->
                <div class="sidebar-section sidebar-user clearfix">
                    <div class="sidebar-user-avatar">
                        <a href="page_ready_user_profile.php">
                            <img src="img/placeholders/avatars/avatar2.jpg" alt="avatar">
                        </a>
                    </div>
                    <div class="sidebar-user-name"><?php echo $_SESSION['fullname']; ?></div>
                    <div class="sidebar-user-links">
                        <a href="#modal-user-settings" data-toggle="modal" class="enable-tooltip" data-placement="bottom" title="Settings"><i class="gi gi-cogwheel"></i></a>
                        <a href="login.php" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="gi gi-exit"></i></a>
                    </div>
                </div>
                <!-- END User Info -->
                <?php if ($primary_nav) { ?>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <?php foreach( $primary_nav as $key => $link ) {
                        $link_class = '';
                        $li_active  = '';
                        $menu_link  = '';

                        // Get 1st level link's vital info
                        $url        = (isset($link['url']) && $link['url']) ? $link['url'] : '#';
                        $active     = (isset($link['url']) && ($template['active_page'] == $link['url'])) ? ' active' : '';
                        $icon       = (isset($link['icon']) && $link['icon']) ? '<i class="' . $link['icon'] . ' sidebar-nav-icon"></i>' : '';

                        // Check if the link has a submenu
                        if (isset($link['sub']) && $link['sub']) {
                            // Since it has a submenu, we need to check if we have to add the class active
                            // to its parent li element (only if a 2nd or 3rd level link is active)
                            foreach ($link['sub'] as $sub_link) {
                                if (in_array($template['active_page'], $sub_link)) {
                                    $li_active = ' class="active"';
                                    break;
                                }

                                // 3rd level links
                                if (isset($sub_link['sub']) && $sub_link['sub']) {
                                    foreach ($sub_link['sub'] as $sub2_link) {
                                        if (in_array($template['active_page'], $sub2_link)) {
                                            $li_active = ' class="active"';
                                            break;
                                        }
                                    }
                                }
                            }

                            $menu_link = 'sidebar-nav-menu';
                        }

                        // Create the class attribute for our link
                        if ($menu_link || $active) {
                            $link_class = ' class="'. $menu_link . $active .'"';
                        }
                        ?>
                        <?php if ($url == 'header') { // if it is a header and not a link ?>
                        <li class="sidebar-header">
                            <?php if (isset($link['opt']) && $link['opt']) { // If the header has options set ?>
                            <span class="sidebar-header-options clearfix"><?php echo $link['opt']; ?></span>
                            <?php } ?>
                            <span class="sidebar-header-title"><?php echo $link['name']; ?></span>
                        </li>
                        <?php } else { // If it is a link ?>
                        <li<?php echo $li_active; ?>>
                        <a href="<?php echo $url; ?>"<?php echo $link_class; ?>><?php if (isset($link['sub']) && $link['sub']) { // if the link has a submenu ?><i class="fa fa-angle-left sidebar-nav-indicator"></i><?php } echo $icon . $link['name']; ?></a>
                        <?php if (isset($link['sub']) && $link['sub']) { // if the link has a submenu ?>
                        <ul>
                            <?php foreach ($link['sub'] as $sub_link) {
                                $link_class = '';
                                $li_active = '';
                                $submenu_link = '';

                                // Get 2nd level link's vital info
                                $url        = (isset($sub_link['url']) && $sub_link['url']) ? $sub_link['url'] : '#';
                                $active     = (isset($sub_link['url']) && ($template['active_page'] == $sub_link['url'])) ? ' active' : '';

                                // Check if the link has a submenu
                                if (isset($sub_link['sub']) && $sub_link['sub']) {
                                    // Since it has a submenu, we need to check if we have to add the class active
                                    // to its parent li element (only if a 3rd level link is active)
                                    foreach ($sub_link['sub'] as $sub2_link) {
                                        if (in_array($template['active_page'], $sub2_link)) {
                                            $li_active = ' class="active"';
                                            break;
                                        }
                                    }

                                    $submenu_link = 'sidebar-nav-submenu';
                                }

                                if ($submenu_link || $active) {
                                    $link_class = ' class="'. $submenu_link . $active .'"';
                                }
                                ?>
                                <li<?php echo $li_active; ?>>
                                <a href="<?php echo $url; ?>"<?php echo $link_class; ?>><?php if (isset($sub_link['sub']) && $sub_link['sub']) { ?><i class="fa fa-angle-left sidebar-nav-indicator"></i><?php } echo $sub_link['name']; ?></a>
                                <?php if (isset($sub_link['sub']) && $sub_link['sub']) { ?>
                                <ul>
                                    <?php foreach ($sub_link['sub'] as $sub2_link) {
                                            // Get 3rd level link's vital info
                                        $url    = (isset($sub2_link['url']) && $sub2_link['url']) ? $sub2_link['url'] : '#';
                                        $active = (isset($sub2_link['url']) && ($template['active_page'] == $sub2_link['url'])) ? ' class="active"' : '';
                                        ?>
                                        <li>
                                            <a href="<?php echo $url; ?>"<?php echo $active ?>><?php echo $sub2_link['name']; ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                    <!-- END Sidebar Navigation -->
                    <?php } ?>
                </div>
                <!-- END Sidebar Content -->
            </div>
            <!-- END Wrapper for scrolling functionality -->
        </div>
        <!-- END Main Sidebar -->

        <!-- Main Container -->
        <div id="main-container">
            <!-- Header -->
            <!-- In the PHP version you can set the following options from inc/config.php file -->
        <!--
            Available header.navbar classes:

            'navbar-default'            for the default light header
            'navbar-inverse'            for an alternative dark header

            'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

            'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
            -->
            <header class="navbar<?php if ($template['header_navbar']) { echo ' ' . $template['header_navbar']; } ?><?php if ($template['header']) { echo ' '. $template['header']; } ?>">
                <?php if ( $template['header_content'] == 'horizontal-menu' ) { // Horizontal Menu Header Content ?>
                <!-- Navbar Header -->
                <div class="navbar-header">
                    <!-- Main Sidebar Toggle Button -->
                    <ul class="nav navbar-nav-custom">
                        <li>
                            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                                <i class="fa fa-bars fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- END Main Sidebar Toggle Button -->
                </div>
                <!-- END Navbar Header -->

                <!-- END Alternative Sidebar Toggle Button -->

                <!-- Horizontal Menu + Search -->
                <div id="horizontal-menu-collapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="javascript:void(0)">Home</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">Profile</a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Settings <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)"><i class="fa fa-asterisk fa-fw pull-right"></i> General</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-lock fa-fw pull-right"></i> Security</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-user fa-fw pull-right"></i> Account</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-magnet fa-fw pull-right"></i> Subscription</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0)" tabindex="-1"><i class="fa fa-chevron-right fa-fw pull-right"></i> More Settings</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)" tabindex="-1">Second level</a></li>
                                        <li><a href="javascript:void(0)">Second level</a></li>
                                        <li><a href="javascript:void(0)">Second level</a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0)" tabindex="-1"><i class="fa fa-chevron-right fa-fw pull-right"></i> More Settings</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0)">Third level</a></li>
                                                <li><a href="javascript:void(0)">Third level</a></li>
                                                <li><a href="javascript:void(0)">Third level</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Contact <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)"><i class="fa fa-envelope-o fa-fw pull-right"></i> By Email</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-phone fa-fw pull-right"></i> By Phone</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form action="page_ready_search_results.php" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search..">
                        </div>
                    </form>
                </div>
                <!-- END Horizontal Menu + Search -->
                <?php } else { // Default Header Content  ?>
                <!-- Left Header Navigation -->
                <ul class="nav navbar-nav-custom">
                    <!-- Main Sidebar Toggle Button -->
                    <li>
                        <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                            <i class="fa fa-bars fa-fw"></i>
                        </a>
                    </li>
                </ul>
                <!-- END Left Header Navigation -->

                <!-- Search Form -->
                <form action="#" method="post" class="navbar-form-custom" role="search">
                    <div class="form-group">
                        <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">
                    </div>
                </form>
                <!-- END Search Form -->

                <!-- Right Header Navigation -->
                <ul class="nav navbar-nav-custom pull-right">
                    <!-- User Dropdown -->
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="img/placeholders/avatars/avatar2.jpg" alt="avatar"> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                            <li class="dropdown-header text-center">Account</li>
                            <li>
                                <a href="campaigns/index.php">
                                    <i class="fa fa-bullhorn fa-fw pull-right"></i>
                                    <span class="badge pull-right">10</span>
                                    Campaigns
                                </a>
                                <a href="tours/index.php">
                                    <i class="fa fa-suitcase fa-fw pull-right"></i>
                                    <span class="badge pull-right">5</span>
                                    Tours
                                </a>
                                <a href="javascript:void()"> <i class="gi gi-charts fa-fw pull-right"> </i> 
                                    <span class="badge pull-right">3 </span>
                                    Reports
                                </a>
                                <a href="javascript:void()"><i class="fa fa-comment fa-fw pull-right"></i>
                                    <span class="badge pull-right">11</span>
                                    Discussions
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user fa-fw pull-right"></i>
                                    Profile
                                </a>
                                <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.php in PHP version) -->
                                <a href="#modal-user-settings" data-toggle="modal">
                                    <i class="fa fa-cog fa-fw pull-right"></i>
                                    Settings
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="login.php"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                    <!-- END User Dropdown -->
                </ul>
                <!-- END Right Header Navigation -->
                <?php } ?>
            </header>
            <!-- END Header -->
