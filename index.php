<?php
// Install:
// composer require automattic/woocommerce

// Setup:
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'https://baahstore.com/', // Your store URL
    'ck_75c5a8eb107c144e23bef0842d132fbbbce3b69e', // Your consumer key
    'cs_ad6b6ef056c6317ef50632f142498473c3f3fe20', // Your consumer secret
    [
        'wp_api' => true, // Enable the WP REST API integration
        'version' => 'wc/v3' // WooCommerce WP REST API version
    ]
);
$ordersData = $woocommerce->get('orders');
$sales = $woocommerce->get('reports/sales?period=month');
$lastMonthSales = $woocommerce->get('reports/sales?period=last_month');
$copon =  $woocommerce->get('coupons');
$net_sale = $sales[0]->net_sales;
$total_sale = $sales[0]->total_sales;
$average_sale = $sales[0]->average_sales;
$lastMonthAverageSale = $lastMonthSales[0]->average_sales;
$lastMonthNetSale = $lastMonthSales[0]->net_sales;
$lastMonthTotalSale = $lastMonthSales[0]->total_sales;


//pie chart
$pietotalSales = number_format(($total_sale*100)/($total_sale+$net_sale) , 2);
$pienetSales = number_format( 100 - $pietotalSales ,2);

// Monthly Earning Progression
$earningProgression;
$thisMonthEarning = $total_sale;
$lastMonthEarning = $lastMonthTotalSale;
/*
$thisMonthFirstDate = date("Y-m-d", strtotime("first day of this month"))."T00:00:00";
$thisMonthLastDate   = date("Y-m-d", strtotime("last day of this month"))."T00:00:00";
$lastMonthFirstDate = date("Y-m-d", strtotime("first day of last month"))."T00:00:00";
$lastMonthLastDate =  date("Y-m-d", strtotime("last day of last month"))."T00:00:00";

foreach($ordersData as $row)
{
    if((string)$row->date_created >= $thisMonthFirstDate and (string)$row->date_created <= $thisMonthLastDate and $row->status =='completed'){
        $thisMonthEarning = $thisMonthEarning + (int)$row->total;
    }
    if((string)$row->date_created >= $lastMonthFirstDate and (string)$row->date_created <= $lastMonthLastDate and $row->status == 'completed'){
        $lastMonthEarning = $lastMonthEarning + (int)$row->total;
    }
}*/
//$lastMonthEarning = 500000;


if($lastMonthEarning == 0)
{
    $earningProgression = "Infinity";
}
else{
    $earningProgression = round((($thisMonthEarning - $lastMonthEarning) / $lastMonthEarning)*100 , 2);
} 



//print_r($woocommerce->get('orders')->status ==);

//order processing count

// print_r( $orders->status);


?>
<script> var arr =  <?=json_encode($totalProducts);?> </script>

<!doctype html>
<html lang="en">

<!-- Mirrored from themesbrand.com/skote/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Aug 2022 17:54:30 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>Dashboard | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Net Sale',  <?= $pienetSales ?>],
          ['Total Sale',  <?= $pietotalSales?>]
        ]);

        var options = {
          title: 'Sales Comparison',
          is3D: true,
          colors:['aqua', 'mediumaquamarine'],
          height: 'auto',
          width : 'auto'
        };

        var chart = new google.visualization.PieChart(document.getElementById('dashpiechart'));

        chart.draw(data, options);
      }
    </script>
    <style>
        #chart_wrap {
    position: relative;
    padding-bottom: 100%;
    height: 0;
    overflow:hidden;
}

#piechart {
    position: absolute;
    top: 0;
    left: 0;
    width:100%;
    height:500px;
}
    </style>    

</head>

    <body data-sidebar="dark" data-layout-mode="light">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-light.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="19">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="bx bx-search-alt"></span>
                            </div>
                        </form>

                        <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <span key="t-megamenu">Mega Menu</span>
                                <i class="mdi mdi-chevron-down"></i> 
                            </button>
                            <div class="dropdown-menu dropdown-megamenu">
                                <div class="row">
                                    <div class="col-sm-8">
    
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5 class="font-size-14" key="t-ui-components">UI Components</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-lightbox">Lightbox</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-range-slider">Range Slider</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-sweet-alert">Sweet Alert</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-rating">Rating</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-forms">Forms</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-tables">Tables</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-charts">Charts</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-4">
                                                <h5 class="font-size-14" key="t-applications">Applications</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-ecommerce">Ecommerce</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-calendar">Calendar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-email">Email</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-projects">Projects</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-tasks">Tasks</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-contacts">Contacts</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-4">
                                                <h5 class="font-size-14" key="t-extra-pages">Extra Pages</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-light-sidebar">Light Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-compact-sidebar">Compact Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-horizontal">Horizontal layout</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-maintenance">Maintenance</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-coming-soon">Coming Soon</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-timeline">Timeline</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-faqs">FAQs</a>
                                                    </li>
                            
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h5 class="font-size-14" key="t-ui-components">UI Components</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-lightbox">Lightbox</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-range-slider">Range Slider</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-sweet-alert">Sweet Alert</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-rating">Rating</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-forms">Forms</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-tables">Tables</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" key="t-charts">Charts</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-sm-5">
                                                <div>
                                                    <img src="assets/images/megamenu-img.png" alt="" class="img-fluid mx-auto d-block">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
        
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="header-lang-img" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="en">
                                    <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                                </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp">
                                    <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr">
                                    <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it">
                                    <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru">
                                    <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                                </a>
                            </div>
                        </div>

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-customize"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <div class="px-lg-2">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/github.png" alt="Github">
                                                <span>GitHub</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                                <span>Bitbucket</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                                <span>Dribbble</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                                <span>Dropbox</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                                <span>Mail Chimp</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/slack.png" alt="slack">
                                                <span>Slack</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-bell bx-tada"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small" key="t-view-all"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="bx bx-cart"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="assets/images/users/avatar-3.jpg"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-simplified">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="assets/images/users/avatar-4.jpg"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-occidental">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span> 
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key="t-henry">Henry</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
                                <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
                                <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="bx bx-cog bx-spin"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboards</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="index.html" key="t-default">Default</a></li>
                                    <li><a href="dashboard-saas.html" key="t-saas">Saas</a></li>
                                    <li><a href="dashboard-crypto.html" key="t-crypto">Crypto</a></li>
                                    <li><a href="dashboard-blog.html" key="t-blog">Blog</a></li>
                                    <li><a href="dashboard-job.html"><span class="badge rounded-pill text-bg-success float-end" key="t-new">New</span> <span key="t-jobs">Jobs</span></a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-layout"></i>
                                    <span key="t-layouts">Layouts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" key="t-vertical">Vertical</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="layouts-light-sidebar.html" key="t-light-sidebar">Light Sidebar</a></li>
                                            <li><a href="layouts-compact-sidebar.html" key="t-compact-sidebar">Compact Sidebar</a></li>
                                            <li><a href="layouts-icon-sidebar.html" key="t-icon-sidebar">Icon Sidebar</a></li>
                                            <li><a href="layouts-boxed.html" key="t-boxed-width">Boxed Width</a></li>
                                            <li><a href="layouts-preloader.html" key="t-preloader">Preloader</a></li>
                                            <li><a href="layouts-colored-sidebar.html" key="t-colored-sidebar">Colored Sidebar</a></li>
                                            <li><a href="layouts-scrollable.html" key="t-scrollable">Scrollable</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" key="t-horizontal">Horizontal</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="layouts-horizontal.html" key="t-horizontal">Horizontal</a></li>
                                            <li><a href="layouts-hori-topbar-light.html" key="t-topbar-light">Topbar light</a></li>
                                            <li><a href="layouts-hori-boxed-width.html" key="t-boxed-width">Boxed width</a></li>
                                            <li><a href="layouts-hori-preloader.html" key="t-preloader">Preloader</a></li>
                                            <li><a href="layouts-hori-colored-header.html" key="t-colored-topbar">Colored Header</a></li>
                                            <li><a href="layouts-hori-scrollable.html" key="t-scrollable">Scrollable</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-title" key="t-apps">Apps</li>

                

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-calendar"></i>
                                    <span key="t-dashboards">Calendars</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="calendar.html" key="t-tui-calendar">TUI Calendar</a></li>
                                    <li><a href="calendar-full.html" key="t-full-calendar">Full Calendar</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="chat.html" class="waves-effect">
                                    <i class="bx bx-chat"></i>
                                    <span key="t-chat">Chat</span>
                                </a>
                            </li>

                            <li>
                                <a href="apps-filemanager.html" class="waves-effect">
                                    <i class="bx bx-file"></i>
                                    <span key="t-file-manager">File Manager</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-store"></i>
                                    <span key="t-ecommerce">Ecommerce</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="ecommerce-products.html" key="t-products">Products</a></li>
                                    <li><a href="ecommerce-product-detail.html" key="t-product-detail">Product Detail</a></li>
                                    <li><a href="ecommerce-orders.html" key="t-orders">Orders</a></li>
                                    <li><a href="ecommerce-customers.html" key="t-customers">Customers</a></li>
                                    <li><a href="ecommerce-cart.html" key="t-cart">Cart</a></li>
                                    <li><a href="ecommerce-checkout.html" key="t-checkout">Checkout</a></li>
                                    <li><a href="ecommerce-shops.html" key="t-shops">Shops</a></li>
                                    <li><a href="ecommerce-add-product.html" key="t-add-product">Add Product</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-bitcoin"></i>
                                    <span key="t-crypto">Crypto</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="crypto-wallet.html" key="t-wallet">Wallet</a></li>
                                    <li><a href="crypto-buy-sell.html" key="t-buy">Buy/Sell</a></li>
                                    <li><a href="crypto-exchange.html" key="t-exchange">Exchange</a></li>
                                    <li><a href="crypto-lending.html" key="t-lending">Lending</a></li>
                                    <li><a href="crypto-orders.html" key="t-orders">Orders</a></li>
                                    <li><a href="crypto-kyc-application.html" key="t-kyc">KYC Application</a></li>
                                    <li><a href="crypto-ico-landing.html" key="t-ico">ICO Landing</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-envelope"></i>
                                    <span key="t-email">Email</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="email-inbox.html" key="t-inbox">Inbox</a></li>
                                    <li><a href="email-read.html" key="t-read-email">Read Email</a></li>
                                    <li>
                                        <a href="javascript: void(0);">
                                            <span key="t-email-templates">Templates</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="email-template-basic.html" key="t-basic-action">Basic Action</a></li>
                                            <li><a href="email-template-alert.html" key="t-alert-email">Alert Email</a></li>
                                            <li><a href="email-template-billing.html" key="t-bill-email">Billing Email</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-receipt"></i>
                                    <span key="t-invoices">Invoices</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="invoices-list.html" key="t-invoice-list">Invoice List</a></li>
                                    <li><a href="invoices-detail.html" key="t-invoice-detail">Invoice Detail</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-briefcase-alt-2"></i>
                                    <span key="t-projects">Projects</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="projects-grid.html" key="t-p-grid">Projects Grid</a></li>
                                    <li><a href="projects-list.html" key="t-p-list">Projects List</a></li>
                                    <li><a href="projects-overview.html" key="t-p-overview">Project Overview</a></li>
                                    <li><a href="projects-create.html" key="t-create-new">Create New</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-task"></i>
                                    <span key="t-tasks">Tasks</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="tasks-list.html" key="t-task-list">Task List</a></li>
                                    <li><a href="tasks-kanban.html" key="t-kanban-board">Kanban Board</a></li>
                                    <li><a href="tasks-create.html" key="t-create-task">Create Task</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-user-detail"></i>
                                    <span key="t-contacts">Contacts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="contacts-grid.html" key="t-user-grid">Users Grid</a></li>
                                    <li><a href="contacts-list.html" key="t-user-list">Users List</a></li>
                                    <li><a href="contacts-profile.html" key="t-profile">Profile</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-detail"></i>
                                    <span key="t-blog">Blog</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="blog-list.html" key="t-blog-list">Blog List</a></li>
                                    <li><a href="blog-grid.html" key="t-blog-grid">Blog Grid</a></li>
                                    <li><a href="blog-details.html" key="t-blog-details">Blog Details</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <span class="badge rounded-pill bg-success float-end" key="t-new">New</span>
                                    <i class="bx bx-briefcase-alt"></i>
                                    <span key="t-jobs">Jobs</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="job-list.html" key="t-job-list">Job List</a></li>
                                    <li><a href="job-grid.html" key="t-job-grid">Job Grid</a></li>
                                    <li><a href="job-apply.html" key="t-apply-job">Apply Job</a></li>
                                    <li><a href="job-details.html" key="t-job-details">Job Details</a></li>
                                    <li><a href="job-categories.html" key="t-Jobs-categories">Jobs Categories</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" key="t-candidate">Candidate</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="candidate-list.html" key="t-list">List</a></li>
                                            <li><a href="candidate-overview.html" key="t-overview">Overview</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-title" key="t-pages">Pages</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user-circle"></i>
                                    <span key="t-authentication">Authentication</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="auth-login.html" key="t-login">Login</a></li>
                                    <li><a href="auth-login-2.html" key="t-login-2">Login 2</a></li>
                                    <li><a href="auth-register.html" key="t-register">Register</a></li>
                                    <li><a href="auth-register-2.html" key="t-register-2">Register 2</a></li>
                                    <li><a href="auth-recoverpw.html" key="t-recover-password">Recover Password</a></li>
                                    <li><a href="auth-recoverpw-2.html" key="t-recover-password-2">Recover Password 2</a></li>
                                    <li><a href="auth-lock-screen.html" key="t-lock-screen">Lock Screen</a></li>
                                    <li><a href="auth-lock-screen-2.html" key="t-lock-screen-2">Lock Screen 2</a></li>
                                    <li><a href="auth-confirm-mail.html" key="t-confirm-mail">Confirm Email</a></li>
                                    <li><a href="auth-confirm-mail-2.html" key="t-confirm-mail-2">Confirm Email 2</a></li>
                                    <li><a href="auth-email-verification.html" key="t-email-verification">Email verification</a></li>
                                    <li><a href="auth-email-verification-2.html" key="t-email-verification-2">Email Verification 2</a></li>
                                    <li><a href="auth-two-step-verification.html" key="t-two-step-verification">Two Step Verification</a></li>
                                    <li><a href="auth-two-step-verification-2.html" key="t-two-step-verification-2">Two Step Verification 2</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-file"></i>
                                    <span key="t-utility">Utility</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pages-starter.html" key="t-starter-page">Starter Page</a></li>
                                    <li><a href="pages-maintenance.html" key="t-maintenance">Maintenance</a></li>
                                    <li><a href="pages-comingsoon.html" key="t-coming-soon">Coming Soon</a></li>
                                    <li><a href="pages-timeline.html" key="t-timeline">Timeline</a></li>
                                    <li><a href="pages-faqs.html" key="t-faqs">FAQs</a></li>
                                    <li><a href="pages-pricing.html" key="t-pricing">Pricing</a></li>
                                    <li><a href="pages-404.html" key="t-error-404">Error 404</a></li>
                                    <li><a href="pages-500.html" key="t-error-500">Error 500</a></li>
                                </ul>
                            </li>

                            <li class="menu-title" key="t-components">Components</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-tone"></i>
                                    <span key="t-ui-elements">UI Elements</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="ui-alerts.html" key="t-alerts">Alerts</a></li>
                                    <li><a href="ui-buttons.html" key="t-buttons">Buttons</a></li>
                                    <li><a href="ui-cards.html" key="t-cards">Cards</a></li>
                                    <li><a href="ui-carousel.html" key="t-carousel">Carousel</a></li>
                                    <li><a href="ui-dropdowns.html" key="t-dropdowns">Dropdowns</a></li>
                                    <li><a href="ui-grid.html" key="t-grid">Grid</a></li>
                                    <li><a href="ui-images.html" key="t-images">Images</a></li>
                                    <li><a href="ui-lightbox.html" key="t-lightbox">Lightbox</a></li>
                                    <li><a href="ui-modals.html" key="t-modals">Modals</a></li>
                                    <li><a href="ui-offcanvas.html" key="t-offcanvas">Offcanvas</a></li>
                                    <li><a href="ui-rangeslider.html" key="t-range-slider">Range Slider</a></li>
                                    <li><a href="ui-session-timeout.html" key="t-session-timeout">Session Timeout</a></li>
                                    <li><a href="ui-progressbars.html" key="t-progress-bars">Progress Bars</a></li>
                                    <li><a href="ui-placeholders.html" key="t-placeholders">Placeholders</a></li>
                                    <li><a href="ui-sweet-alert.html" key="t-sweet-alert">Sweet-Alert</a></li>
                                    <li><a href="ui-tabs-accordions.html" key="t-tabs-accordions">Tabs & Accordions</a></li>
                                    <li><a href="ui-typography.html" key="t-typography">Typography</a></li>
                                    <li><a href="ui-toasts.html" key="t-toasts">Toasts</a></li>
                                    <li><a href="ui-video.html" key="t-video">Video</a></li>
                                    <li><a href="ui-general.html" key="t-general">General</a></li>
                                    <li><a href="ui-colors.html" key="t-colors">Colors</a></li>
                                    <li><a href="ui-rating.html" key="t-rating">Rating</a></li>
                                    <li><a href="ui-notifications.html" key="t-notifications">Notifications</a></li>
                                    <li><a href="ui-utilities.html"><span key="t-utilities">Utilities</span> <span class="badge rounded-pill bg-success float-end" key="t-new">New</span></a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <i class="bx bxs-eraser"></i>
                                    <span class="badge rounded-pill bg-danger float-end">10</span>
                                    <span key="t-forms">Forms</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="form-elements.html" key="t-form-elements">Form Elements</a></li>
                                    <li><a href="form-layouts.html" key="t-form-layouts">Form Layouts</a></li>
                                    <li><a href="form-validation.html" key="t-form-validation">Form Validation</a></li>
                                    <li><a href="form-advanced.html" key="t-form-advanced">Form Advanced</a></li>
                                    <li><a href="form-editors.html" key="t-form-editors">Form Editors</a></li>
                                    <li><a href="form-uploads.html" key="t-form-upload">Form File Upload</a></li>
                                    <li><a href="form-xeditable.html" key="t-form-xeditable">Form Xeditable</a></li>
                                    <li><a href="form-repeater.html" key="t-form-repeater">Form Repeater</a></li>
                                    <li><a href="form-wizard.html" key="t-form-wizard">Form Wizard</a></li>
                                    <li><a href="form-mask.html" key="t-form-mask">Form Mask</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-list-ul"></i>
                                    <span key="t-tables">Tables</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="tables-basic.html" key="t-basic-tables">Basic Tables</a></li>
                                    <li><a href="tables-datatable.html" key="t-data-tables">Data Tables</a></li>
                                    <li><a href="tables-responsive.html" key="t-responsive-table">Responsive Table</a></li>
                                    <li><a href="tables-editable.html" key="t-editable-table">Editable Table</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-bar-chart-alt-2"></i>
                                    <span key="t-charts">Charts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="charts-apex.html" key="t-apex-charts">Apex Charts</a></li>
                                    <li><a href="charts-echart.html" key="t-e-charts">E Charts</a></li>
                                    <li><a href="charts-chartjs.html" key="t-chartjs-charts">Chartjs Charts</a></li>
                                    <li><a href="charts-flot.html" key="t-flot-charts">Flot Charts</a></li>
                                    <li><a href="charts-tui.html" key="t-ui-charts">Toast UI Charts</a></li>
                                    <li><a href="charts-knob.html" key="t-knob-charts">Jquery Knob Charts</a></li>
                                    <li><a href="charts-sparkline.html" key="t-sparkline-charts">Sparkline Charts</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-aperture"></i>
                                    <span key="t-icons">Icons</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="icons-boxicons.html" key="t-boxicons">Boxicons</a></li>
                                    <li><a href="icons-materialdesign.html" key="t-material-design">Material Design</a></li>
                                    <li><a href="icons-dripicons.html" key="t-dripicons">Dripicons</a></li>
                                    <li><a href="icons-fontawesome.html" key="t-font-awesome">Font Awesome</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-map"></i>
                                    <span key="t-maps">Maps</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="maps-google.html" key="t-g-maps">Google Maps</a></li>
                                    <li><a href="maps-vector.html" key="t-v-maps">Vector Maps</a></li>
                                    <li><a href="maps-leaflet.html" key="t-l-maps">Leaflet Maps</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-share-alt"></i>
                                    <span key="t-multi-level">Multi Level</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="javascript: void(0);" key="t-level-1-1">Level 1.1</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Level 1.2</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="javascript: void(0);" key="t-level-2-1">Level 2.1</a></li>
                                            <li><a href="javascript: void(0);" key="t-level-2-2">Level 2.2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card overflow-hidden">
                                    <div class="bg-primary bg-soft">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="text-primary p-3">
                                                    <h5 class="text-primary">Welcome Back !</h5>
                                                    <p>Skote Dashboard</p>
                                                </div>
                                            </div>
                                            <div class="col-5 align-self-end">
                                                <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="avatar-md profile-user-wid mb-4">
                                                    <img src="assets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                                <h5 class="font-size-15 text-truncate">Henry Price</h5>
                                                <p class="text-muted mb-0 text-truncate">UI/UX Designer</p>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="pt-4">

                                                    <div class="row">
                                                    <!-- 
                                                     <div class="col-6">
                                                            <h5 class="font-size-15"><?= $totalProducts?></h5>
                                                            <p class="text-muted mb-0">Products</p>
                                                        </div> 
                                                    -->
                                                        <div class="col-6">
                                                            <h5 class="font-size-15">৳<?= $net_sale?></h5>
                                                            <p class="text-muted mb-0">Net Sale</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <a href="CheckOrderList.php" class="btn btn-primary waves-effect waves-light btn-sm">View Orders<i class="mdi mdi-arrow-right ms-1"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Monthly Earning</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="text-muted">This month</p>
                                                <h3>$<?= $total_sale ?></h3>
                                                <p class="text-muted">
                                                    <span class="text-success me-2"> 
                                                        <?php 
                                                            if($earningProgression != "Infinity" )
                                                                {
                                                                    if($earningProgression > 0 ){
                                                                        echo $earningProgression . "% &#8593;";
                                                                    }
                                                                    else{
                                                                        echo abs($earningProgression) . "% &#8595;";
                                                                    }
                                                                }
                                                            else{
                                                                echo $earningProgression;
                                                            }
                                                        ?>
                                                     </span> From previous period
                                                </p>

                                                <div class="mt-4">
                                                    <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mt-4 mt-sm-0">
                                                    <div id="radialBar-chart" data-colors='["--bs-primary"]' class="apex-charts"></div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <p class="text-muted mb-0">We craft digital, graphic and dimensional thinking.</p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium"> Total Sale(this month)</p>
                                                        
                                                        <h4 class="mb-0">৳<?=  $total_sale?></h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center ">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Average Sale</p>
                                                        <h4 class="mb-0">৳<?=$average_sale?></h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium"> Total Sale(last month)</p>
                                                        
                                                        <h4 class="mb-0">৳<?=  $lastMonthTotalSale?></h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center ">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium">Net Sale(last month)</p>
                                                        <h4 class="mb-0">৳<?=$lastMonthNetSale?></h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                            <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row">
                                <div id="dashpiechart" style="position:relative"></div>
                                </div>                                    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Orders</h4>
                                        <div class="table-responsive">
                                            <table id ="orderList" class="table align-middle table-nowrap mb-0 table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Order Number</th>
                                                            <th scope="col">Order</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Total</th> 
                                                            <th scope="col">View Details</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <?php for ($i = 0; $i<count($ordersData);  $i++){?>
                                                        <tr> 
                                                            <td> <?= $ordersData[$i]->id ;?></td>
                                                            <td><?= $ordersData[$i]->billing->first_name;?></td>
                                                            <td ><?=  $ordersData[$i]->date_created;?> </td >
                                                            <td>
                                                                <button class="btn
                                                                <?php 
                                                                    if($ordersData[$i]->status == 'completed') 
                                                                        echo'btn-success'; 
                                                                    elseif ($ordersData[$i]->status =='pending' ) {
                                                                        echo'btn-info';
                                                                    }
                                                                    elseif ($ordersData[$i]->status =='processing' ) {
                                                                        echo'btn-primary';
                                                                    }
                                                                    elseif($ordersData[$i]->status == 'cancelled'){
                                                                        echo'btn-danger';
                                                                    }
                                                                    ?> " style="cursor:text" >
                                                                    
                                                                    <?=  $ordersData[$i]->status;?></button>
                                                            </td>
                                                            <td ><?=  $ordersData[$i]->total;?> </td >
                                                            <td >
                                                            <a class="btn btn-outline-primary"  href="viewDetails.php?varname=<?=  $ordersData[$i]->id ;?>">ViewDetails</a>
                                                            </td>
                                                        </tr> 
                                                        <?php }; ?>
                                                    
                                                    </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Orders</h4>
                                        <div class="table-responsive">
                                            <table id ="orderList" class="table align-middle table-nowrap mb-0 table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Discount Type</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Date expires</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <?php for ($i = 0; $i<count($copon);  $i++){?>
                                                        <tr> 
                                                            <td> <?= $copon[$i]->code ;?></td>
                                                            <td><?= $copon[$i]->discount_type;?></td>
                                                            <td ><?=  $copon[$i]->amount;?> </td >
                                                            <td><?=  $copon[$i]->date_expires;?> </td>
                                                        </tr> 
                                                        <?php }; ?>
                                                    
                                                    </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <!-- Transaction Modal -->
                <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transaction-detailModalLabel">Order Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-2">Product id: <span class="text-primary">#SK2540</span></p>
                                <p class="mb-4">Billing Name: <span class="text-primary">Neal Matthews</span></p>

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <div>
                                                        <img src="assets/images/product/img-7.png" alt="" class="avatar-sm">
                                                    </div>
                                                </th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14">Wireless Headphone (Black)</h5>
                                                        <p class="text-muted mb-0">$ 225 x 1</p>
                                                    </div>
                                                </td>
                                                <td>$ 255</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <div>
                                                        <img src="assets/images/product/img-4.png" alt="" class="avatar-sm">
                                                    </div>
                                                </th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14">Phone patterned cases</h5>
                                                        <p class="text-muted mb-0">$ 145 x 1</p>
                                                    </div>
                                                </td>
                                                <td>$ 145</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="m-0 text-right">Sub Total:</h6>
                                                </td>
                                                <td>
                                                    $ 400
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="m-0 text-right">Shipping:</h6>
                                                </td>
                                                <td>
                                                    Free
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="m-0 text-right">Total:</h6>
                                                </td>
                                                <td>
                                                    $ 400
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal -->

                <!-- subscribeModal -
                <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <div class="avatar-md mx-auto mb-4">
                                        <div class="avatar-title bg-light rounded-circle text-primary h1">
                                            <i class="mdi mdi-email-open"></i>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-xl-10">
                                            <h4 class="text-primary">Subscribe !</h4>
                                            <p class="text-muted font-size-14 mb-4">Subscribe our newletter and get notification to stay update.</p>

                                            <div class="input-group bg-light rounded">
                                                <input type="email" class="form-control bg-transparent border-0" placeholder="Enter Email address" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                
                                                <button class="btn btn-primary" type="button" id="button-addon2">
                                                    <i class="bx bxs-paper-plane"></i>
                                                </button>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!-- end modal -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- dashboard init -->
        <script src="assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script type="text/javascript" src = "https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src = "https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src = "https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
            $('#orderList').DataTable();
        } );
        </script>
    </body>


<!-- Mirrored from themesbrand.com/skote/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Aug 2022 17:55:12 GMT -->
</html>