<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">App Users</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">App Users
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
                                <h4 class="card-title">APP Users</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>District</th>
                                                <th>Designation</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($user) && $user != '') {
                                                $Sno = 0;
                                                foreach ($user as $k => $r) {
                                                    $Sno++ ?>
                                                    <tr>
                                                        <td><?php echo $Sno ?></td>
                                                        <td><?php echo $r->full_name ?></td>
                                                        <td><?php echo $r->username ?></td>
                                                        <td><?php echo $r->dist_id ?></td>
                                                        <td><?php echo $r->designation ?></td>
                                                        <td data-id="<?php echo $r->id ?>"
                                                            data-fullname="<?php echo $r->full_name ?>"
                                                            data-username="<?php echo $r->username ?>">
                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                <a href="javascript:void(0)" title="Reset Password"
                                                                   onclick="getResetPwd(this)"><i
                                                                            class="feather icon-settings"></i></a>
                                                            <?php } ?>
                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                <a href="javascript:void(0)" title="Edit User"
                                                                   onclick="getEdit(this)"><i
                                                                            class="feather icon-edit"></i> </a>
                                                            <?php } ?>
                                                            <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
                                                                <a href="javascript:void(0)" title="Block User"
                                                                   onclick="getDelete(this)">
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
                                                <th>SNo</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>District</th>
                                                <th>Designation</th>
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
                    <form action="javascript:void(0)" autocomplete="off">
                        <div class="form-group">
                            <label for="fullName">Full Name: </label>
                            <input type="text" class="form-control fullName"
                                   id="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="userName">User Name: </label>
                            <input type="email" class="form-control userName" minlength="8"
                                   autocomplete="userNameas" id="userName" required>
                        </div>

                        <label for="userPassword">Password</label>
                        <fieldset class="form-label-group position-relative has-icon-left">
                            <input type="password" class="form-control myPwdInput "
                                   id="userPassword" name="userPassword" minlength="8"
                                   placeholder="Password" required>
                            <div class="form-control-position toggle-password">
                                <i class="feather icon-eye-off pwdIcon"></i>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <label for="district">District: </label>
                            <select class="form-control select2" id="district" required>
                                <option value="0">Select District</option>
                                <?php if (isset($districts) && $districts != '') {
                                    foreach ($districts as $d) {
                                        echo '<option value="' . $d->dist_id . '">' . $d->district . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation: </label>
                            <input type="text" class="form-control" id="designation" required>
                        </div>
                    </form>
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

                    <input type="hidden" id="edit_idUser" name="edit_idUser">
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="edit_fullName">Full Name: </label>
                        <input type="text" class="form-control edit_fullName"
                               id="edit_fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_userName">User: </label>
                        <input type="text" class="form-control edit_userName" id="edit_userName" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="edit_district">District: </label>
                        <select class="form-control" id="edit_district" required>
                            <option value="0">Select District</option>
                            <?php if (isset($districts) && $districts != '') {
                                foreach ($districts as $d) {
                                    echo '<option value="' . $d->dist_id . '">' . $d->district . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_designation">Designation: </label>
                        <input type="text" class="form-control" id="edit_designation" required>
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

                    <label for="edit_userPassword" class="label-control">Password</label>
                    <fieldset class="form-label-group position-relative has-icon-left">
                        <input type="password" class="form-control myPwdInput" autocomplete="off"
                               id="edit_userPassword" name="edit_userPassword"
                               placeholder="Password" required>
                        <div class="form-control-position toggle-password">
                            <i class="feather icon-eye-off pwdIcon"></i>
                        </div>

                    </fieldset>
                    <label for="edit_userPasswordConfirm">Confirm Password</label>
                    <fieldset class="form-label-group position-relative has-icon-left">
                        <input type="password" class="form-control myPwdInput" autocomplete="off"
                               id="edit_userPasswordConfirm" name="edit_userPasswordConfirm"
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
                    <h4 class="modal-title white" id="myModalLabel_delete">Block User</h4>
                    <input type="hidden" id="delete_idUser" name="delete_idUser">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to block this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteData()">Block
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

<script>

    $(document).ready(function () {
        validatePwd('userName');
        validatePwd('edit_userName');
        validatePwd('userPassword');
        validatePwd('edit_userPassword');
        validatePwd('edit_userPasswordConfirm');
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

    function addData() {
        $('#fullName').css('border', '1px solid #babfc7');
        $('#userName').css('border', '1px solid #babfc7');
        $('#userPassword').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['fullName'] = $('#fullName').val();
        data['userName'] = $('#userName').val();
        data['userPassword'] = $('#userPassword').val();
        data['district'] = $('#district').val();
        data['designation'] = $('#designation').val();
        if (data['fullName'] == '' || data['fullName'] == undefined) {
            $('#fullName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Full Name', 'Invalid Full Name', 'error');
            return false;
        }
        if (data['userName'].length < 8) {
            $('#userName').css('border', '1px solid red');
            flag = 1;
            toastMsg('User Name', 'Username must be 8 characters long', 'error');
            return false;
        }
        if (data['userPassword'].length < 8) {
            $('#userPassword').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password', 'Password must be 8 characters long', 'error');
            return false;
        }

        if (data['userName'] == '' || data['userName'] == undefined || data['userName'].length < 8) {
            $('#userName').css('border', '1px solid red');
            flag = 1;
            toastMsg('User Name', 'Invalid User Name', 'error');
            return false;
        }

        if (data['userPassword'] == '' || data['userPassword'] == undefined || data['userPassword'].length < 8) {
            $('#userPassword').css('border', '1px solid red');
            flag = 1;
            toastMsg('Password', 'Invalid Password', 'error');
            return false;
        }
        if (data['district'] == '' || data['district'] == undefined || data['district'] == 0 || data['district'] == '0') {
            $('#district').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }
        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/App_Users/addData'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result !== '' && JSON.parse(result).length > 0) {
                    var response = JSON.parse(result);
                    try {
                        toastMsg(response[0], response[1], response[2]);
                        if (response[0] === 'Success') {
                            $('#addModal').modal('hide');
                            setTimeout(function () {
                                window.location.reload();
                            }, 700);
                        }
                    } catch (e) {
                    }
                } else {
                    toastMsg('Error', 'Something went wrong while uploading data', 'error');
                }

            });
        } else {
            toastMsg('User', 'Something went wrong', 'error');
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
            CallAjax('<?php echo base_url('index.php/App_Users/deleteData')?>', data, 'POST', function (res) {
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

    function getEdit(obj) {
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        if (data['id'] != '' && data['id'] != undefined) {
            showloader();
            CallAjax('<?php echo base_url('index.php/App_Users/getEdit')?>', data, 'POST', function (result) {
                hideloader();
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        $('#edit_idUser').val(data['id']);
                        $('#edit_userName').val(a[0]['username']);
                        $('#edit_fullName').val(a[0]['full_name']);
                        $('#edit_district').val(a[0]['dist_id']);
                        $('#edit_designation').val(a[0]['designation']);
                    } catch (e) {
                    }
                    $('#editModal').modal('show');
                } else {
                    toastMsg('User', 'Invalid User', 'error');
                }
            });
        }
    }

    function editData() {
        $('#edit_userName').css('border', '1px solid #babfc7');
        $('#edit_fullName').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idUser'] = $('#edit_idUser').val();
        data['fullName'] = $('#edit_fullName').val();
        data['userName'] = $('#edit_userName').val();
        data['district'] = $('#edit_district').val();
        data['designation'] = $('#edit_designation').val();

        if (data['idUser'] == '' || data['idUser'] == undefined || data['idUser'].length < 1) {
            flag = 1;
            toastMsg('User', 'Invalid User', 'error');
            return false;
        }
        if (data['fullName'] == '' || data['fullName'] == undefined) {
            $('#edit_fullName').css('border', '1px solid red');
            flag = 1;
            toastMsg('Full Name', 'Invalid Full Name', 'error');
            return false;
        }
        if (data['userName'].length < 8) {
            $('#userName').css('border', '1px solid red');
            flag = 1;
            toastMsg('User Name', 'Username must be 8 characters long', 'error');
            return false;
        }

        if (data['userName'] == '' || data['userName'] == undefined) {
            $('#edit_userName').css('border', '1px solid red');
            flag = 1;
            toastMsg('User Name', 'Invalid User Name', 'error');
            return false;
        }
        if (data['district'] == '' || data['district'] == undefined || data['district'] == 0 || data['district'] == '0') {
            $('#edit_district').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        if (flag === 0) {
            showloader();
            CallAjax('<?php echo base_url('index.php/App_Users/editData')?>', data, 'POST', function (res) {
                hideloader();
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('User', 'Successfully Edited', 'success');
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
            toastMsg('Confrim Password', 'Invalid Confrim Password', 'error');
            return false;
        }
        if (flag === 0) {
            showloader();
            CallAjax('<?php echo base_url('index.php/App_Users/resetPwd')?>', data, 'POST', function (res) {
                hideloader();
                if (res == 1) {
                    $('#editPwdModal').modal('hide');
                    toastMsg('User', 'Password successfully reset', 'success');
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