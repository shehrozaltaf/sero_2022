<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Staff Online Data Repository COE / Department of Paeds & Child Health">
    <meta name="keywords" content="Staff Online Data Repository COE / Department of Paeds & Child Health">
    <meta name="author" content="PIXINVENT">
    <title>Staff Online Data Repository COE / Department of Paeds & Child Health</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/vendors.min.css">
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        .myimg-fluid {
            width: 100%;
            /* width: 100px;
             height: 80px;
             padding: 5px;*/
        }

        .card .card-header {
            display: block;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body onload="gotFocus();" class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image
 blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column"
      data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-8 col-11 d-flex justify-content-center">
                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="row m-0">
                            <div class="col-lg-12 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h3 class=" text-center">Staff Online Data Repository COE / DWCH</h3>
                                        </div>
                                    </div>
                                    <p class="px-2">Welcome, please login to your account.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <div>
                                                <div id="msg" style="display: none;" class="alert  mb-2"
                                                     role="alert"></div>
                                                <fieldset
                                                        class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control inpSubmit"
                                                           id="login_username" name="login_username"
                                                           placeholder="Username" required>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="login_username">Username</label>
                                                </fieldset>

                                                <fieldset class="form-label-group position-relative has-icon-left">
                                                    <input type="password" class="form-control myPwdInput inpSubmit"
                                                           id="login_password" name="login_password"
                                                           placeholder="Password" required>
                                                    <div class="form-control-position toggle-password">
                                                        <i class="feather icon-eye-off pwdIcon"></i>
                                                    </div>
                                                    <label for="login_password">Password</label>
                                                </fieldset>
                                                <div class="form-group d-flex justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox">
                                                                <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                <span class="">Remember me</span>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <input type="hidden" id="g-recaptcha-response"
                                                           name="g-recaptcha-response">
                                                    <input type="hidden" name="action" value="validate_captcha">

                                                </div>

                                                <a href="javascript:void(0)" onClick="login()"
                                                   class="btn btn-outline-primary float-left btn-inline">Login</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="login-footer">
                                        <div class="divider">
                                            <div class="divider-text">OR</div>
                                        </div>
                                        <div class="footer-btn">
                                            <div class="text-right"><a
                                                        href="<?php echo base_url('index.php/Login/recover_password') ?>"
                                                        class="card-link">Forgot Password?</a></div>
                                        </div>
                                    </div>
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
<!-- BEGIN: Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url() ?>assets/js/core/app-menu.js"></script>
<script src="<?php echo base_url() ?>assets/js/core/app.js"></script>
<script src="<?php echo base_url() ?>assets/js/scripts/components.js"></script>
<!-- END: Theme JS-->


<script src="<?php echo base_url() ?>assets/js/core.js"></script>

<script src="https://www.google.com/recaptcha/api.js?render=6LfNqIwaAAAAAIiXHDw1aseLt5ZGbh-Qok-zBbCc"></script>
<script>
    $('.inpSubmit').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            login();
        }
    });

    function login() {
        var errorFlag = 0;
        $('#login_username').removeClass('error');
        $('#login_password').removeClass('error');
        var data = {};
        data['login_username'] = $('#login_username').val();
        data['login_password'] = $('#login_password').val();

        if (data['login_username'] == '' || data['login_username'] == undefined) {
            $('#login_username').addClass('error');
            returnMsg('msg', 'Invalid User Name', 'alert-danger', 'msg');
            errorFlag = 1;
            return false;
        }
        if (data['login_password'] == '' || data['login_password'] == undefined) {
            $('#login_password').addClass('error');
            returnMsg('msg', 'Invalid Password 1', 'alert-danger', 'msg');
            errorFlag = 1;
            return false;
        }
        if (errorFlag === 0) {
            grecaptcha.ready(function () {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('6LfNqIwaAAAAAIiXHDw1aseLt5ZGbh-Qok-zBbCc', {action: 'validate_captcha'})
                    .then(function (token) {
                        data['g-recaptcha-response'] = token;
                        CallAjax('<?php echo base_url('index.php/Login/getLogin')?>', data, 'POST', function (res) {
                            try {
                                var response = JSON.parse(res);
                                if (response[0] == 'Success') {
                                    returnMsg('msg', response[1], 'alert-success');
                                    setTimeout(function () {
                                        window.location.href = "<?php echo base_url() . 'index.php/Dashboard' ?>";
                                    }, 500)
                                } else {
                                    returnMsg('msg', response[1], 'alert-danger');
                                }
                            } catch (e) {
                            }

                        });
                    });
            });
        }
    }

    function gotFocus() {
        $("#login_username").focus();
    }
</script>

</body>
<!-- END: Body-->
</html>