<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Recover Password - Dictionary Portal">
    <meta name="keywords" content="Recover Password - Dictionary Portal">
    <title>Recover Password - <?php echo  PROJECT_NAME?></title>
    <meta name="referrer" content="no-referrer">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"
          rel="stylesheet"  integrity="sha384-+/M6kredJcxdsqkczBUjMLvqyHb1K/JThDXWsBVxMEeZHEaMKEOEct339VItX1zB"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/components.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>assets/css/core/colors/palette-gradient.min.css">
    <style>
        .error {
            border-color: #e53935;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 1-column  bg-full-screen-image blank-page blank-page"
      data-open="click" data-menu="vertical-menu-modern" data-color="bg-gradient-x-purple-red" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                            <div class="card-header border-0">
                                <!--<div class="text-center mb-1">
                        <img src="<?php /*echo base_url(); */ ?>assets/images/logo/logo.png" alt="branding logo">
                    </div>-->
                                <div class="font-large-1  text-center">
                                    Recover Password
                                </div>

                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-title font-small-3  text-danger">
                                        We will send you the Old Password on your email.
                                    </div>
                                    <div>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="email" class="form-control round inpSubmit" id="user-email"
                                                   placeholder="Your Email Address" required name="email">
                                            <div class="form-control-position">
                                                <i class="ft-mail"></i>
                                            </div>
                                        </fieldset>
                                        <div id="msg" style="display: none;" class="uk-alert" data-uk-alert>
                                            <a href="javascript:void(0)" class="uk-alert-close uk-close"></a>
                                            <p id="msgText"></p>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="button" onclick="forgetPwd()"
                                                    class="btn mybtn round btn-block btn-glow btn-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-center mt-2">
                                        <a href="<?php echo base_url() ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-chevron-left">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                            Back to login </a>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->


<script src="<?php echo base_url(); ?>assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN: Page Vendor JS-->

<script src="<?php echo base_url() ?>assets/js/core.js"></script>


<script>
    $('.inpSubmit').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            forgetPwd()
        }
    });

    function forgetPwd() {
        var data = {};
        data['email'] = $('#user-email').val();
        $('#user-email').removeClass('error');
        if (data['email'] != '' && data['email'] != undefined) {
            $('.mybtn').attr('disabled', 'disabled');
            showloader();
            $('#msg').css('display', 'none');
            CallAjax("<?php echo base_url('index.php/Login/forgetPwd_SendEmail') ?>", data, 'POST', function (res) {
                hideloader();
                $('#msg').css('display', 'block');
                $('.mybtn').removeAttr('disabled', 'disabled');
                if (res == 1) {
                    setTimeout(function () {
                        window.location.href = "<?php echo base_url() ?>";
                    }, 500);
                    $('#msgText').text('Success').css('color', 'green');
                } else if (res == 2) {
                    $('#user-email').addClass('error');
                    $('#msgText').text('Email not send').css('color', 'red');
                } else if (res == 3) {
                    $('#user-email').addClass('error');

                    $('#msgText').text('Email not found').css('color', 'red');
                } else {
                    $('#user-email').addClass('error');
                    $('#msgText').text('Invalid Email').css('color', 'red');
                }
                setTimeout(function () {
                    $('#msg').css('display', 'none');
                }, 1500);
            });
        } else {
            $('#user-email').addClass('error');
            returnMsg('msgText', 'Invalid Email', 'uk-alert-danger', 'msg');
        }
    }
</script>
</body>
</html>