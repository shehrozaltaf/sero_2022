<link rel="stylesheet" type="text/css"
      href="<?php echo base_url() ?>assets/vendors/css/tables/datatable/datatables.min.css">


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Dashboard Users</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Users
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Users</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Designation</th>
                                                <th>Contact</th>
                                                <th>Password Expiry</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($user) && $user != '') {
                                                foreach ($user as $k => $u) { ?>
                                                    <tr>
                                                        <td><?php echo $u->full_name ?></td>
                                                        <td><?php echo $u->username ?></td>
                                                        <td><?php echo $u->email ?></td>
                                                        <td><?php echo $u->designation ?></td>
                                                        <td><?php echo $u->contact ?></td>
                                                        <td><?php echo(isset($u->pwdExpiry) && $u->pwdExpiry != '' ? date('d-M-Y', strtotime($u->pwdExpiry)) : '-') ?></td>
                                                        <td><?php echo(isset($u->status) && $u->status == '0' ? '<button class="btn btn-danger btn-sm">Revoked/Deleted</button>' : '<button class="btn btn-primary btn-sm">Active</button>') ?></td>
                                                        <td data-id="<?php echo $u->id ?>"
                                                            data-fullname="<?php echo $u->full_name ?>"
                                                            data-username="<?php echo $u->username ?>" >
                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                <a href="<?php echo base_url('index.php/Users/log_reports?u='.$u->id) ?>" >
                                                                    <i class="feather icon-eye"></i> </a>
                                                            <?php } ?>

                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                <a href="javascript:void(0)" title="Reset Password"
                                                                   onclick="getResetPwd(this)"><i
                                                                            class="feather icon-settings"></i></a>
                                                            <?php } ?>
                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                <a href="javascript:void(0)" onclick="getEdit(this)"><i
                                                                            class="feather icon-edit"></i> </a>
                                                            <?php } ?>
                                                            <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
                                                                <a href="javascript:void(0)" onclick="getDelete(this)">
                                                                    <i class="feather icon-trash"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Designation</th>
                                                <th>Contact</th>
                                                <th>Password Expiry</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
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
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="md-fab-wrapper addbtn">
        <a class="md-fab md-fab-accent md-fab-wave-light waves-effect waves-button waves-light"
           href="javascript:void(0)" data-uk-modal="{target:'#addModal'}" id="add">
            <i class="feather icon-plus-circle"></i>
        </a>
    </div>
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullName">Full Name: </label>
                        <input type="text" class="form-control fullName" autocomplete="off"
                               id="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="userName">User Name: </label>
                        <input type="email" class="form-control userName" autocomplete="off"
                               id="userName" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email: </label>
                        <input type="text" class="form-control userEmail" autocomplete="off"
                               id="userEmail" required>
                    </div>

                    <label for="userPassword">Password</label>
                    <fieldset class="form-label-group position-relative has-icon-left">
                        <input type="password" class="form-control myPwdInput"
                               autocomplete="user_userPassword" id="userPassword" name="userPassword"
                               placeholder="Password" required>
                        <div class="form-control-position toggle-password">
                            <i class="feather icon-eye-off pwdIcon"></i>
                        </div>
                    </fieldset>


                    <div class="form-group">
                        <label for="designation">Designation: </label>
                        <input type="text" class="form-control" id="designation" required>
                    </div>
                    <div class="form-group">
                        <label for="contactNo">Contact No: </label>
                        <input type="text" class="form-control numericOnly" id="contactNo" required>
                    </div>
                    <div class="form-group">
                        <label for="userGroup">User Group: </label>
                        <select class="form-control" id="userGroup" required>
                            <option value="0">Select Group</option>
                            <?php if (isset($groups) && $groups != '') {
                                foreach ($groups as $g) {
                                    echo '<option value="' . $g->idGroup . '">' . $g->groupName . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary mybtn" onclick="addData()">Add
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_edit"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit User</h4>

                    <input type="hidden" id="edit_idUser" name="edit_idUser" autocomplete="user_contactNo">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_fullName">Full Name: </label>
                        <input type="text" class="form-control edit_fullName"
                               autocomplete="user_edit_fullName" id="edit_fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_userName">User Name: </label>
                        <input type="email" class="form-control edit_userName" disabled readonly
                               autocomplete="user_edit_userName" id="edit_userName" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_userEmail">Email: </label>
                        <input type="text" class="form-control edit_userEmail" disabled readonly
                               autocomplete="user_edit_userEmail" id="edit_userEmail" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_designation">Designation: </label>
                        <input type="text" class="form-control" id="edit_designation" required>
                    </div>
                    <div class="edit_form-group">
                        <label for="edit_contactNo">Contact No: </label>
                        <input type="text" class="form-control numericOnly" id="edit_contactNo" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_userGroup">User Group: </label>
                        <select class="form-control" id="edit_userGroup" required>
                            <option value="0">Select Group</option>
                            <?php if (isset($groups) && $groups != '') {
                                foreach ($groups as $g) {
                                    echo '<option value="' . $g->idGroup . '">' . $g->groupName . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_pwdExpiry">Password Expiry: </label>
                        <input type="text" class="form-control mypickadat" id="edit_pwdExpiry" name="edit_pwdExpiry"
                               autocomplete="edit_pwdExpiry" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="editData()">Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editPwdModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_editPwd"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_editPwd">Reset Password</h4>
                    <input type="hidden" id="editPwd_idUser" name="editPwd_idUser">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_fullNamePwd">Full Name: </label>
                        <input type="text" class="form-control edit_fullNamePwd"
                               id="edit_fullNamePwd" required readonly disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_userNamePwd">User: </label>
                        <input type="text" class="form-control edit_userNamePwd" id="edit_userNamePwd" readonly
                               disabled>
                    </div>

                    <label for="edit_userPassword">Password</label>
                    <fieldset class="form-label-group position-relative has-icon-left">
                        <input type="password" class="form-control myPwdInput"
                               id="edit_userPassword" name="edit_userPassword" autocomplete="off"
                               placeholder="Password" required>
                        <div class="form-control-position toggle-password">
                            <i class="feather icon-eye-off pwdIcon"></i>
                        </div>
                    </fieldset>

                    <label for="edit_userPasswordConfirm">Confirm Password</label>
                    <fieldset class="form-label-group position-relative has-icon-left">
                        <input type="password" class="form-control myPwdInput"
                               id="edit_userPasswordConfirm" name="edit_userPasswordConfirm" autocomplete="off"
                               placeholder="Confirm Password" required>
                        <div class="form-control-position toggle-password">
                            <i class="feather icon-eye-off pwdIcon"></i>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="resetPwd()">Reset Password
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete User</h4>
                    <input type="hidden" id="delete_idUser" name="delete_idUser">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<!-- BEGIN: User Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
<!-- END: User Vendor JS-->
<!-- BEGIN: User JS-->
<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/datatables/datatable.js"></script>-->
<!-- END: User JS-->
<script src="<?php echo base_url() ?>assets/js/scripts/jquery.inputmask.bundle.js"></script>
<script>
    $(document).ready(function () {
        mydate();
        validatePwd('userPassword');
        validatePwd('edit_userPassword');
        $(".numericOnly").ForceNumericOnly();
        $("#userEmail").inputmask("email");
        $('.addbtn').click(function () {
            $('#addModal').modal('show');
        });

        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
            "oSearch": {"sSearch": " "},
            autoFill: false,
            attr: {
                autocomplete: 'off'
            },
            initComplete: function () {
                $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
            },
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    text: 'JSON',
                    action: function (e, dt, button, config) {
                        var data = dt.buttons.exportData();

                        $.fn.dataTable.fileSave(
                            new Blob([JSON.stringify(data)]),
                            'Export.json'
                        );
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
    });

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: true,
            max: +90,
            clear: ' ',
            format: 'dd-mm-yyyy'
        });
    }

    function addData() {
        $('#fullName').css('border', '1px solid #babfc7');
        $('#userName').css('border', '1px solid #babfc7');
        $('#userEmail').css('border', '1px solid #babfc7');
        $('#userPassword').css('border', '1px solid #babfc7');
        $('#userGroup').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['fullName'] = $('#fullName').val();
        data['userName'] = $('#userName').val();
        data['userEmail'] = $('#userEmail').val();
        data['userPassword'] = $('#userPassword').val();
        data['designation'] = $('#designation').val();
        data['contactNo'] = $('#contactNo').val();
        data['userGroup'] = $('#userGroup').val();
        if (data['fullName'] == '' || data['fullName'] == undefined) {
            $('#fullName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Full Name', 'Invalid Full Name', 'error');
            return false;
        }
        if (data['userName'] == '' || data['userName'] == undefined) {
            $('#userName').css('border', '1px solid red');
            flag = 1;
            toastMsg('User Name', 'Invalid User Name', 'error');
            return false;
        }
        if (data['userEmail'] == '' || data['userEmail'] == undefined || !validateEmail(data['userEmail'])) {
            $('#userEmail').css('border', '1px solid red');
            flag = 1;
            toastMsg('Email', 'Invalid Email', 'error');
            return false;
        }
        if (data['userPassword'] == '' || data['userPassword'] == undefined) {
            $('#userPassword').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password', 'Invalid Password', 'error');
            return false;
        }
        if (data['userPassword'].length < 8) {
            $('#userPassword').css('border', '1px solid red');
            toastMsg('Password', 'Password length must be greater than 8 digits', 'error');
            flag = 1;
            return false;
        }
        if (data['userGroup'] == '' || data['userGroup'] == undefined || data['userGroup'] == 0 || data['userGroup'] == '0') {
            $('#userGroup').css('border', '1px solid red');
            flag = 1;
            toastMsg('Group', 'Invalid Group', 'error');
            return false;
        }
        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Users/addData'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (result == 3) {
                    $('#fullName').css('border', '1px solid red');
                    toastMsg('Full Name', 'Invalid Full Name', 'error');
                } else if (result == 4) {
                    $('#userName').css('border', '1px solid red');
                    toastMsg('User Name', 'Invalid User Name', 'error');
                } else if (result == 5) {
                    $('#userEmail').css('border', '1px solid red');
                    toastMsg('Email', 'Invalid Email', 'error');
                } else if (result == 6) {
                    $('#userPassword').css('border', '1px solid red');
                    toastMsg('Password', 'Invalid Password', 'error');
                } else if (result == 7) {
                    $('#userPassword').css('border', '1px solid red');
                    toastMsg('Password', 'Password length must be greater than 8 digits', 'error');
                } else if (result == 8) {
                    $('#userGroup').css('border', '1px solid red');
                    toastMsg('Group', 'Invalid Group', 'error');
                } else if (result == 10) {
                    $('#userName').css('border', '1px solid red');
                    $('#userEmail').css('border', '1px solid red');
                    toastMsg('Duplicate', 'Duplicate Username or Email', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });

        } else {
            toastMsg('User', 'Something went wrong', 'error');
        }
    }


    function getEdit(obj) {
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        if (data['id'] != '' && data['id'] != undefined) {
            CallAjax('<?php echo base_url('index.php/Users/getEdit')?>', data, 'POST', function (result) {
                console.log(result);
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        $('#edit_idUser').val(data['id']);
                        $('#edit_fullName').val(a[0]['full_name']);
                        $('#edit_userName').val(a[0]['username']);
                        $('#edit_userEmail').val(a[0]['email']);
                        $('#edit_designation').val(a[0]['designation']);
                        $('#edit_contactNo').val(a[0]['contact']);
                        $('#edit_userGroup').val(a[0]['idGroup']);
                        $('#edit_pwdExpiry').val(a[0]['pwdExpiry']);

                    } catch (e) {
                    }
                    $('#editModal').modal('show');
                } else {
                    toastMsg('Error', 'Invalid Data', 'error');
                }
            });
        }
    }

    function editData() {
        $('#edit_fullName').css('border', '1px solid #babfc7');
        $('#edit_userGroup').css('border', '1px solid #babfc7');
        $('#edit_pwdExpiry').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idUser'] = $('#edit_idUser').val();
        data['fullName'] = $('#edit_fullName').val();
        data['designation'] = $('#edit_designation').val();
        data['contactNo'] = $('#edit_contactNo').val();
        data['userGroup'] = $('#edit_userGroup').val();
        data['pwdExpiry'] = $('#edit_pwdExpiry').val();
        if (data['fullName'] == '' || data['fullName'] == undefined) {
            $('#edit_fullName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Full Name', 'Invalid Full Name', 'error');
            return false;
        }
        if (data['userGroup'] == '' || data['userGroup'] == undefined || data['userGroup'] == 0 || data['userGroup'] == '0') {
            $('#edit_userGroup').css('border', '1px solid red');
            flag = 1;
            toastMsg('Group', 'Invalid Group', 'error');
            return false;
        }
        if (data['pwdExpiry'] == '' || data['pwdExpiry'] == undefined || data['pwdExpiry'] == 0 || data['pwdExpiry'] == '0') {
            $('#edit_pwdExpiry').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password Expiry', 'Invalid Password Expiry', 'error');
            return false;
        }

        if (flag === 0) {
            showloader();
            CallAjax('<?php echo base_url('index.php/Users/editData')?>', data, 'POST', function (res) {
                hideloader();
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('User', 'Successfully Edited', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 3 || res == 4 || res == 5) {
                    $('#edit_userName').css('border', '1px solid red');
                    toastMsg('User Name', 'Invalid User Name', 'error');
                } else if (result == 8) {
                    toastMsg('Password', 'Password length must be greater than 8 digits', 'error');
                } else if (res == 6) {
                    $('#edit_userEmail').css('border', '1px solid red');
                    toastMsg('Email', 'Invalid Email', 'error');
                } else if (res == 7) {
                    $('#edit_userPassword').css('border', '1px solid red');
                    toastMsg('Password', 'Invalid Password', 'error');
                } else {
                    toastMsg('User', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getResetPwd(obj) {
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        data['fullname'] = $(obj).parent('td').attr('data-fullname');
        data['username'] = $(obj).parent('td').attr('data-username');
        if (data['id'] != '' && data['id'] != undefined) {
            $('#editPwd_idUser').val(data['id']);
            $('#edit_fullNamePwd').val(data['fullname']);
            $('#edit_userNamePwd').val(data['username']);
            $('#editPwdModal').modal('show');
        } else {
            toastMsg('User', 'Invalid User', 'error');
        }
    }

    function resetPwd() {
        $('#edit_userNamePwd').css('border', '1px solid #babfc7');
        $('#edit_fullNamePwd').css('border', '1px solid #babfc7');
        $('#edit_userPassword').css('border', '1px solid #babfc7');
        $('#edit_userPasswordConfirm').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idUser'] = $('#editPwd_idUser').val();
        data['fullName'] = $('#edit_fullNamePwd').val();
        data['userName'] = $('#edit_userNamePwd').val();
        data['userPassword'] = $('#edit_userPassword').val();
        data['userPasswordConfirm'] = $('#edit_userPasswordConfirm').val();

        if (data['idUser'] == '' || data['idUser'] == undefined || data['idUser'].length < 1) {
            flag = 1;
            ('#edit_userNamePwd').css('border', '1px solid red');
            toastMsg('User', 'Invalid User', 'error');
            return false;
        }
        if (data['fullName'] == '' || data['fullName'] == undefined) {
            $('#edit_fullName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Full Name', 'Invalid Full Name', 'error');
            return false;
        }
        if (data['userPassword'].length < 8) {
            $('#userPassword').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password', 'Password must be 8 characters long', 'error');
            return false;
        }
        if (data['userPassword'] == '' || data['userPassword'] == undefined) {
            $('#edit_userPassword').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password', 'Invalid Password', 'error');
            return false;
        }
        if (data['userPasswordConfirm'] == '' || data['userPasswordConfirm'] == undefined || data['userPasswordConfirm'] != data['userPassword']) {
            $('#edit_userPasswordConfirm').css('border', '1px solid red');
            flag = 1;
            toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
            return false;
        }
        if (flag === 0) {
            showloader();
            CallAjax('<?php echo base_url('index.php/Users/resetPwd')?>', data, 'POST', function (res) {
                hideloader();
                if (res == 1) {
                    $('#editPwdModal').modal('hide');
                    toastMsg('User', 'Password successfully reset', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 4) {
                    toastMsg('Password', 'Invalid Password', 'error');
                } else if (res == 5) {
                    toastMsg('Confirm Password', 'Invalid Confirm Password', 'error');
                } else if (res == 6) {
                    toastMsg('Confirm Password', 'Confirm Password is not matching with Password', 'error');
                } else if (res == 2) {
                    toastMsg('User', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('User', 'Invalid User', 'error');
                }
            });
        }
    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_idUser').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idUser'] = $('#delete_idUser').val();
        if (data['idUser'] == '' || data['idUser'] == undefined || data['idUser'] == 0) {
            toastMsg('User', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Users/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    toastMsg('User', 'Successfully Deleted', 'success');
                    $('#deleteModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('User', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('User', 'Invalid User', 'error');
                }

            });
        }
    }
</script>