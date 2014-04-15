<?php
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Configuration file. It contains variables used in the template as well as the primary navigation array from which the navigation is created
 *
 */

/* Template variables */
$template = array(
    'name'          => 'Entertainment Intelligence',
    'version'       => '',
    'author'        => 'Biota Labs',
    'robots'        => 'noindex, nofollow',
    'title'         => 'Entertainment Intelligence',
    'description'   => 'Entertainment Intelligence - a collaborative campaign management platform for the entertainment business',
    // 'navbar-default'         for a light header
    // 'navbar-inverse'         for a dark header
    'header_navbar' => 'navbar-default',
    // ''                       empty for a static header
    // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
    // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
    'header'        => '',
    // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
    // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
    // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
    // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
    // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
    // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
    // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
    'sidebar'       => 'sidebar-partial sidebar-visible-lg sidebar-no-animations',
    // ''                       empty for a static footer
    // 'footer-fixed'           for a fixed footer
    'footer'       => '',
    // ''                       empty for default style
    // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
    'main_style'    => '',
    // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire' or '' leave empty for the Default Blue theme
    'theme'         => '',
    // ''                       for default content in header
    // 'horizontal-menu'        for a horizontal menu in header
    // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php
    'header_content'=> '',
    'active_page'   => basename($_SERVER['PHP_SELF'])
);
    
/* Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 levels deep) */
$primary_nav = array(
    array(
        'name'  => 'Dashboard',
        'url'   => 'index.php',
        'icon'  => 'gi gi-stopwatch'
    ),
    array(
        'name'  => '',
        'opt'   => '',
        'url'   => 'header',
    ),
    array(
        'name'  => 'Calendar',
        'url'   => '#',
        'icon'  => 'gi gi-calendar'
    ),
    array(
        'name'  => 'Users',
        'opt'   => '<i class="gi gi-user"></i>',
        'url'   => 'header',
    ),
    array(
        'name'  => 'Artists',
        'url'   => 'artists/index.php',
        'icon'  => 'fa fa-star'
    ),
    array(
        'name'  => 'Promoters',
        'url'   => 'promoters/index.php',
        'icon'  => 'fa fa-ticket'
    ),
    array(
        'name'  => 'Venues',
        'url'   => 'venues/index.php',
        'icon'  => 'gi gi-bank'
    ),
    array(
        'name'  => 'Tour Planning',
        'opt'   => '<i class="gi gi-airplane"></i>',
        'url'   => 'header',
    ),
    array(
        'name'  => 'Home',
        'url'   => 'tours/index.php',
        'icon'  => 'gi gi-home'
    ),
    array(
        'name'  => 'Tours',
        'icon'  => 'gi gi-suitcase',
        'sub'   => array(
            array(
                'name'  => 'My Tours',
                'url'   => 'tours/index.php'
            ),
            array(
                'name'  => 'Discussions',
                'url'   => 'discussions.php'
            ),
            array(
                'name'  => '<i class="gi gi-circle_plus"></i> Add',
                'url'   => 'tnew.php'
            ),
        )
    ),
    array(
        'name'  => 'Updates',
        'url'   => '#', // 'updates.php'
        'icon'  => 'gi gi-roundabout'
    ),
    array(
        'name'  => 'Campaign Planning',
        'opt'   => '<i class="gi gi-airplane"></i>',
        'url'   => 'header',
    ),
    array(
        'name'  => 'Campaigns',
        'url'   => 'campaigns/index.php',
        'icon'  => 'hi hi-bullhorn'
    ),
    array(
        'name'  => 'Reporting',
        'opt'   => '<i class="gi gi-stats"></i>',
        'url'   => 'header',
    ),
    array(
        'name'  => 'Reports',
        'url'   => 'reports/index.php',
        'icon'  => 'gi gi-charts'
    ),
);