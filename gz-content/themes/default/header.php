<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang="en">
    <!-- BEGIN head -->
    <head>
        <title><?php echo get_settings('nama'); ?></title>
        <!-- Meta Tags -->
        <meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="robots" content="index, follow" />
        <meta name="description" content="<?php echo get_settings('desc'); ?>" />
        <meta name="keywords" content="<?php echo get_settings('content'); ?>" />
        <meta http-equiv="Copyright" content="Bagas Topati from Mastahweb.com" />
        <meta name="author" content="Bagas Topati" />
        <meta http-equiv="imagetoolbar" content="no" />
        <meta name="language" content="Indonesia" />
        <meta name="revisit-after" content="7" />
        <meta name="webcrawlers" content="all" />
        <meta name="rating" content="general" />
        <meta name="spiders" content="all" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon 
            <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />-->
        <!-- Stylesheets -->
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/main-stylesheet.css" />
    	<link type="text/css" rel="stylesheet" href="" id="styleCss"/>
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/shortcode.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/fonts.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/retina.css" />
        <!-- <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/foundation2.css" /> -->
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/dzscalendar.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/dzstooltip.css" />
        <link rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/jquery.ad-gallery.css" type="text/css" />
        <link href="<?php echo $template->get_directory_uri(); ?>/css/screen.css" rel="stylesheet" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/owl.carousel.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/owl.theme.default.css'; ?>">
        <link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/bootstrap.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo ASSETS_URL . 'css/dataTables.bootstrap.css' ?>">
        <link href="<?php echo $template->get_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet"/>
        <!--[if lte IE 8]>
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/ie-transparecy.css" />
        <![endif]-->
        <link type="text/css" id="style-responsive" rel="stylesheet" media="screen" href="<?php echo $template->get_directory_uri(); ?>/css/desktop.css" />
        <!-- Scripts -->
        <!-- <link href="//fonts.googleapis.com/css?family=Lato:100italic,100,300italic,300,400italic,400,700italic,700,900italic,900" rel="stylesheet" type="text/css"> -->
        <script type="text/javascript">
            /*var iPhoneVertical = Array(null, 320, "<?php echo $template->get_directory_uri(); ?>/css/phonevertical.css?" + Date());
            var iPhoneHorizontal = Array(321, 767, "<?php echo $template->get_directory_uri(); ?>/css/phonehorizontal.css?" + Date());
            var iPad = Array(768, 1000, "<?php echo $template->get_directory_uri(); ?>/css/responsive/ipad.css?" + Date());
            var dekstop = Array(1001, null, "<?php echo $template->get_directory_uri(); ?>/css/desktop.css?" + Date());*/
            
            // Legatus Slider Options
            //  var _legatus_slider_autostart = true; // Autostart Slider (false / true)
            //var _legatus_slider_interval = 5000; // Autoslide Interval (Def = 5000)
            //var _legatus_slider_loading = true; // Autoslide With Loading Bar (false / true)
        </script>
        <link type="text/css" rel="stylesheet" href="<?php echo $template->get_directory_uri(); ?>/css/demo-settings.css" />
        <!-- <link rel="shortcut icon" href="favicon.png" /> -->
        <!-- <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="terasconfig/rss.xml" />
         -->

        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_URL . 'fullcalendar/fullcalendar.min.css'; ?>">
        <script src="<?php echo ASSETS_URL . 'fullcalendar/moment.min.js'; ?>"></script>
        <script src="<?php echo ASSETS_URL; ?>js/jquery.min.js" type="text/javascript"></script>

        <!-- FullCalendar -->
        <script src="<?php echo ASSETS_URL . 'fullcalendar/fullcalendar.min.js'; ?>"></script> 
        <!-- END head -->
    </head>
    <!-- BEGIN body -->
    <body>
        <!-- <div class="page-loader" id="pageLoader">
            <div class="loader-wrapper">
                <div class="loader"></div>
                <p>Loading . . .</p>
            </div>
            
            </div> -->
        <!-- BEGIN .boxed -->
        <!-- <div class="boxed active"> -->
        <div class="boxed active">
            <!-- BEGIN .header -->
            <div class="header" style="background-image: url('<?php echo get_settings('banner'); ?>')">
                <!-- BEGIN .header-very-top -->
                <div class="header-very-top">
                    <div class="wrapper">
                        <div class="left">
                            <?php echo get_menu('1', 'very-top-menu'); ?>
                        </div>
                        <div class="right">
                            <div class="weather-report">
                                <div class="kalender" style="color:#fff !important;">
                                    <span class="style2"></span>&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="clear-float"></div>
                    </div>
                    <div class="double-split"></div>
                    <!-- END .header-very-top -->
                </div>
                <!-- BEGIN .header-middle -->
                <div class="header-middle">
                    <div class="wrapper">
         
                        <div class="logo-image">
                            <?php echo get_settings('logo'); ?>
                        </div>
						
                        <div class="banner">
                            <div class="banner-block">
                                <div class="banner-info">
                                </div>
                            </div>
                        </div>
                        <div class="clear-float"></div>
                    </div>
                    <!-- END .header-middle -->
                </div>
                <!-- BEGIN .header-menu -->
                <div class="header-menu thisisfixed">
                    <div class="wrapper">
                        <?php echo get_menu('2', 'main-menu', 'sub-menu', ''); ?>
                        <div class="right menu-search">
                            <form action="<?php echo BASE_URL . 'search/1/' ?>" method="GET">
                                <input type="text" placeholder="Cari" name="s" style="width:200px;" />
                                <input type="submit" class="search-button" value="&nbsp;" />
                            </form>
                        </div>
                        <div class="clear-float"></div>
                    </div>
                    <!-- END .header-menu -->
                </div>
                <!-- BEGIN .header-undermenu -->
                <div class="header-undermenu">
                    <div class="wrapper">
                        <?php echo get_menu('3', 'secondary-menu'); ?>
                        <div class="clear-float"></div>
                    </div>
                    <!-- END .header-undermenu -->
                </div>
                <!-- END .header -->
            </div>

            <div class="content">
            <!-- BEGIN .wrapper -->
            <div class="wrapper">
                <!-- BEGIN .breaking-news -->
                <!-- BEGIN .main-content-left -->
                <!-- BEGIN .main-content-split -->
                <!-- BEGIN .main-split-left -->
                <!--========= KONTEN ========================-->
              <div class="">