<!-- BEGIN: Footer-->

<footer class="footer footer-static footer-light">
    <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date('Y') ?><a
                    class="text-bold-800 grey darken-2" href="http://www.aku.edu"
                    target="_blank"><?php echo PROJECT_NAME ?>,</a>All rights Reserved</span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>
<!-- END: Footer-->

<?php if (isset($permission[0]->menuClass) && $permission[0]->menuClass != '') {
    $menuactive = $permission[0]->menuClass;
} else {
    $menuactive = '';
} ?>
<input type="hidden" id="menuactive" value="<?php echo $menuactive ?>">

<script>
    $(document).ready(function () {
        getMenu();

        showFirstPwdModal();
        validatePwd('edit_newPassword');
        validatePwd('edit_newPasswordConfirm');
        validatePwd('first_newPassword');
        validatePwd('first_newPasswordConfirm');
        pickDate();
        setTimeout(function () {
            var men = $('#menuactive').val();
            if (men != '' && men != undefined) {
                $('.' + men).addClass('active').parents('li').addClass('sidebar-group-active open');
            }
        }, 500);

        checkSesstion();
    });

    function checkSesstion() {
        var s = 1;
        sessionStorage.setItem("activityTime", 1);
        $('body').on('scroll mousedown keydown', function (event) {
            CallAjax('<?php echo base_url('index.php/Check_Session/checkSession'); ?>', {}, 'POST', function (result) {
                if (result == 2) {
                    window.location.reload();
                }
            });
            s = 1;
            sessionStorage.setItem("activityTime", 1);
        });

        setInterval(function () {
            sessionStorage.setItem("activityTime", s++);
            if (sessionStorage.getItem("activityTime") >= 910) {
                window.location.reload();
            }
        }, 1000);
    }

    function changePassword() {
        var flag = 0;
        $('#edit_newPassword').css('border', '1px solid #babfc7');
        $('#edit_newPasswordConfirm').css('border', '1px solid red');
        var data = {};
        data['newpassword'] = $('#edit_newPassword').val();
        data['newpasswordconfirm'] = $('#edit_newPasswordConfirm').val();

        if (data['newpassword'] == '' || data['newpassword'] == undefined) {
            $('#edit_newPassword').css('border', '1px solid red');
            toastMsg('New Password', 'Invalid New Password', 'error');
            flag = 1;
            return false;
        }
        if (data['newpassword'].length < 8) {
            $('#edit_newPassword').css('border', '1px solid red');
            toastMsg('New Password', 'Password length must be greater than 8 digits', 'error');
            flag = 1;
            return false;
        }
        if (data['newpasswordconfirm'] == '' || data['newpasswordconfirm'] == undefined || data['newpassword'] != data['newpasswordconfirm']) {
            $('#edit_newPasswordConfirm').css('border', '1px solid red');
            toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
            flag = 1;
            return false;
        }
        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Users/changePassword'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#changePasswordModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500)
                } else if (result == 2) {
                    toastMsg('New Password', 'Invalid New Password', 'error');
                } else if (result == 3 || result == 4) {
                    toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
                } else if (result == 5) {
                    toastMsg('Password', 'Password length must be greater than 8 digits', 'error');
                }else if (result == 6) {
                    toastMsg('Password', 'Password must not be an old password', 'error');
                }  else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function showFirstPwdModal() {
        var isNewUser = $('#isNewUser').val();
        var pwdExpiry = $('#pwdExpiry').val();
        var label = '';
        if (isNewUser == 1) {
            label = 'First time login, Please change password';
            $('#myModalLabel_changeFirstPwd').text(label);
            $('#changeFirstPasswordModal').modal('show');
        } else if (pwdExpiry != '' && pwdExpiry != '0') {
            label = 'You did not change your password from +90 days, Please change your password';
            $('#myModalLabel_changeFirstPwd').text(label);
            $('#changeFirstPasswordModal').modal('show');
        }
    }

    function changeFirstPassword() {
        var flag = 0;
        $('#first_newPassword').css('border', '1px solid #babfc7');
        $('#first_newPasswordConfirm').css('border', '1px solid red');
        var data = {};
        data['newpassword'] = $('#first_newPassword').val();
        data['newpasswordconfirm'] = $('#first_newPasswordConfirm').val();
        if (data['newpassword'] == '' || data['newpassword'] == undefined) {
            $('#first_newPassword').css('border', '1px solid red');
            toastMsg('New Password', 'Invalid New Password', 'error');
            flag = 1;
            return false;
        }
        if (data['newpassword'].length < 8) {
            $('#first_newPassword').css('border', '1px solid red');
            toastMsg('New Password', 'Password length must be greater than 8 digits', 'error');
            flag = 1;
            return false;
        }
        if (data['newpasswordconfirm'] == '' || data['newpasswordconfirm'] == undefined || data['newpassword'] != data['newpasswordconfirm']) {
            $('#first_newPasswordConfirm').css('border', '1px solid red');
            toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
            flag = 1;
            return false;
        }
        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Users/changefirstPassword'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#changeFirstPasswordModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500)
                } else if (result == 2) {
                    toastMsg('New Password', 'Invalid New Password', 'error');
                } else if (result == 3 || result == 4) {
                    toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
                } else if (result == 5) {
                    toastMsg('Password', 'Password length must be greater than 8 digits', 'error');
                }else if (result == 6) {
                    toastMsg('Password', 'Password must not be an old password', 'error');
                }  else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function logout() {
        CallAjax('<?php echo base_url('index.php/Login/getLogout')?>', {}, 'POST', function (res) {
            window.location.href = "<?php echo base_url() ?>";
        });
    }

    function getMenu() {
        CallAjax('<?php echo base_url('index.php/Dashboard/getMenuData') ?>', [], "POST", function (Result) {
            $('#main-menu-navigation').html(Result);
        });
    }

    function pickDate() {
        $('.pickadate-short-string').pickadate({
            selectYears: true,
            selectMonths: true,
            weekdaysShort: ['S', 'M', 'Tu', 'W', 'Th', 'F', 'S'],
            format: 'dd-mm-yyyy',
            showMonthsShort: true
        });
    }


    function changeDist() {
        var data = {};
        data['district'] = $('.district_select').val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getClustersByDistrict'  ?>', data, 'POST', function (res) {
                var uc = $('#hidden_slug_uc').val();
                var items = '<option value="0"   readonly disabled ' + (uc == '' || uc == undefined ? 'selected' : '') + '>UC</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ucCode + '" onclick="changeUC()" ' + (uc == v.ucCode ? 'selected' : '') + '>' + v.ucName + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.uc_select').html('').html(items);
                changeUC();
            });
        } else {
            $('.uc_select').html('');
        }
    }

    function changeUC() {
        var data = {};
        data['ucs'] = $('.uc_select').val();
        if (data['ucs'] != '' && data['ucs'] != undefined && data['ucs'] != '0' && data['ucs'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getClustersByUCs'  ?>', data, 'POST', function (res) {
                var cluster = $('#hidden_slug_cluster').val();
                var items = '<option value="0"   readonly disabled  ' + (cluster == '' || cluster == undefined ? 'selected' : '') + '>Cluster</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.cluster_no + '" ' + (cluster == v.cluster_no ? 'selected' : '') + '>' + v.cluster_no + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.clusters_select').html('').html(items);
            });
        } else {
            $('.clusters_select').html('');
        }
    }
</script>


<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url() ?>assets/js/core/app.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/extensions/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/core/app-menu.js"></script>

<script src="<?php echo base_url() ?>assets/js/scripts/components.js"></script>


<script src="<?php echo base_url() ?>assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/pickers/pickadate/legacy.js"></script>


<script src="<?php echo base_url() ?>assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/scripts/forms/select/form-select2.js"></script>
<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/modal/components-modal.js"></script>-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
</body>
<!-- END: Body-->
</html>