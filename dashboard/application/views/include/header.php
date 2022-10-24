<?php error_reporting(0); ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?php echo PROJECT_NAME ?>">
    <meta name="keywords" content="<?php echo PROJECT_NAME ?>">
    <title>Dashboard - <?php echo PROJECT_NAME ?></title>
    <meta name="referrer" content="no-referrer">
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>assets/images/ico/favicon.ico">
<!--    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/fonts/fonts.css">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/extensions/toastr.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/themes/semi-dark-layout.css">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/extensions/toastr.css">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css">
    <!-- END: Custom CSS-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo base_url() ?>assets/vendors/js/vendors.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/core.js" type="text/javascript"></script>
    <!-- BEGIN Vendor JS-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/pickers/pickadate/pickadate.css">
    <style>
        /* Center the loader */
        #loader {
            width: 20%;
            height: 10%;
            margin: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            position: fixed;
        }

        .mygreen, .myred,.myorange{
            color: white;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

<button class="btn btn-primary hide"  id="loader">
    <span class="spinner-border spinner-border-sm"></span>
    Loading..
</button>

