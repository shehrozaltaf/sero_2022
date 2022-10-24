<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Team Registration</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Team Registration
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section class="basic-select2">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select"
                                                        id="district_select"
                                                        onchange="changeDistrict('district_select','ucs_select',1)">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($district) && $district != '') {
                                                        foreach ($district as $k => $d) {
                                                            echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                UC
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                                Data
                                            </button>
                                            <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
                                                <button type="button" class="btn btn-danger" onclick="addModal()">Add
                                                    Staff
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (isset($slug_district) && $slug_district != '' && $slug_district != 0) { ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Team Registration</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Type</th>
                                                    <th>Staff</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) { ?>
                                                        <tr>
                                                            <td><?php echo $r->district ?></td>
                                                            <td><?php echo $r->ucName ?></td>
                                                            <td><?php echo $r->staff_type ?></td>
                                                            <td><?php echo $r->staff_name ?></td>
                                                            <td data-id="<?php echo $r->idDoctor ?>">
                                                                <?php
                                                                if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="getEdit(this)"><i
                                                                                class="feather icon-edit"></i> </a>
                                                                <?php } ?>
                                                                <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
                                                                    <a href="javascript:void(0)"
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
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Type</th>
                                                    <th>Staff</th>
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
            <?php } ?>
        </div>
    </div>
</div>

<input type="hidden" id="hidden_slug_ucs"
       value="<?php echo(isset($slug_ucs) && $slug_ucs != '' ? $slug_ucs : ''); ?>">
<!-- Modal -->
<!-- END: Content-->
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add Team</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="staff_type">Staff Type: </label>
                        <select class="select2 form-control" name="staff_type"
                                id="staff_type" required
                                onchange="changeDistrict('edit_district','edit_ucCode',0)">
                            <option value="0" readonly disabled selected>Type</option>
                            <option value="Dr">Doctor</option>
                            <option value="LHV">LHV</option>
                            <option value="Vaccinator">Vaccinator</option>
                            <option value="UC Incharge">UC Incharge</option>
                            <option value="Medical Technician">Medical Technician</option>
                            <option value="Mob">Mobilizer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="staff_name">Staff Name: </label>
                        <input type="text" class="form-control" id="staff_name" name="staff_name"
                               autocomplete="staff_name_add" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger mybtn" onclick="addData()">Add</button>
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
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit Team</h4>

                    <input type="hidden" id="edit_idDoctor" name="edit_idDoctor">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_staff_type">Staff Type: </label>
                        <select class=" form-control" name="edit_staff_type"
                                id="edit_staff_type" required
                                onchange="changeDistrict('edit_district','edit_ucCode',0)">
                            <option value="0" readonly disabled>Type</option>
                            <option value="Dr">Doctor</option>
                            <option value="LHV">LHV</option>
                            <option value="LHW">LHW</option>
                            <option value="Vaccinator">Vaccinator</option>
                            <option value="UC Incharge">UC Incharge</option>
                            <option value="Medical Technician">Medical Technician</option>
                            <option value="Mob">Mobilizer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_staff_name">Staff Name: </label>
                        <input type="text" class="form-control" autocomplete="edit_staff_name" id="edit_staff_name"
                               name="edit_staff_name" required>
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

<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Team</h4>
                    <input type="hidden" id="delete_idDoctor" name="delete_idDoctor">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        limit_alph('staff_name');
        limit_alph('edit_staff_name');
        changeDistrict('district_select', 'ucs_select', 1);
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

    function addModal() {
        var flag = 0;
        var data = {};
        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();

        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (flag == 0) {
            limit_alph('staff_name');
            $('#addModal').modal('show');
        }

    }

    function addData() {
        $('#staff_name').css('border', '1px solid #babfc7');
        $('#staff_type').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['staff_name'] = $('#staff_name').val();
        data['staff_type'] = $('#staff_type').val();
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            $('#dist_id').css('border', '1px solid red');
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucCode'] == '' || data['ucCode'] == undefined) {
            $('#ucCode').css('border', '1px solid red');
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (data['staff_name'] == '' || data['staff_name'] == undefined) {
            $('#staff_name').css('border', '1px solid red');
            toastMsg('Doctor', 'Invalid Doctor', 'error');
            flag = 1;
        }
        if (data['staff_type'] == '' || data['staff_type'] == undefined) {
            $('#staff_type').css('border', '1px solid red');
            toastMsg('Staff Type', 'Invalid Staff Type', 'error');
            flag = 1;
        }
        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp_team/addCampDoctor'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Camp_team?d=' + data['dist_id'] + '&u=' + data['ucCode'];
                    }, 500);
                } else if (result == 2) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (result == 3) {
                    $('#ucCode').css('border', '1px solid red');
                    toastMsg('UC', 'Invalid UC', 'error');
                } else if (result == 4) {
                    $('#staff_name').css('border', '1px solid red');
                    toastMsg('Doctor', 'Invalid Doctor', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getEdit(obj) {
        $('#edit_ucCode').html('');
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        if (data['id'] != '' && data['id'] != undefined) {
            changeDistrict('edit_district', 'edit_ucCode', 0);
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp_team/getDoctorEdit')?>', data, 'POST', function (result) {
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        $('#edit_idDoctor').val(data['id']);
                        $('#edit_staff_name').val(a[0]['staff_name']);
                        // $('#edit_staff_type').select2("val", a[0]['staff_type']);
                        $('#edit_staff_type').val(a[0]['staff_type']);

                    } catch (e) {
                    }
                    $('#editModal').modal('show');

                } else {
                    toastMsg('Doctor', 'Invalid Doctor', 'error');
                }
            });
        }
    }

    function editData() {
        $('#edit_staff_name').css('border', '1px solid #babfc7');
        $('#edit_staff_type').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idDoctor'] = $('#edit_idDoctor').val();
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['staff_name'] = $('#edit_staff_name').val();
        data['staff_type'] = $('#edit_staff_type').val();
        if (data['idDoctor'] == '' || data['idDoctor'] == undefined || data['idDoctor'].length < 1) {
            flag = 1;
            toastMsg('Doctor', 'Invalid Doctor', 'error');
            return false;
        }
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            $('#edit_district').css('border', '1px solid red');
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucCode'] == '' || data['ucCode'] == undefined) {
            $('#edit_ucCode').css('border', '1px solid red');
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (data['staff_name'] == '' || data['staff_name'] == undefined) {
            $('#edit_staff_name').css('border', '1px solid red');
            toastMsg('Doctor', 'Invalid Doctor', 'error');
            flag = 1;
        }
        if (data['staff_type'] == '' || data['staff_type'] == undefined) {
            $('#edit_staff_type').css('border', '1px solid red');
            toastMsg('Staff Type', 'Invalid Staff Type', 'error');
            flag = 1;
        }
        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp_team/editData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Doctor', 'Successfully Edited', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 3) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (res == 4) {
                    $('#ucCode').css('border', '1px solid red');
                    toastMsg('UC', 'Invalid UC', 'error');
                } else if (res == 5) {
                    $('#edit_staff_name').css('border', '1px solid red');
                    toastMsg('Doctor', 'Invalid Doctor', 'error');
                } else if (res == 6) {
                    $('#edit_staff_type').css('border', '1px solid red');
                    toastMsg('Doctor', 'Invalid Doctor', 'error');
                } else {
                    toastMsg('Doctor', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_idDoctor').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idDoctor'] = $('#delete_idDoctor').val();
        if (data['idDoctor'] == '' || data['idDoctor'] == undefined || data['idDoctor'] == 0) {
            toastMsg('Doctor', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp_team/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#deleteModal').modal('hide');
                    toastMsg('Doctor', 'Successfully Deleted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Doctor', 'Something went wrong', 'error');
                } else {
                    toastMsg('Doctor', 'Invalid Doctor', 'error');
                }

            });
        }
    }

    function changeDistrict(dist, uc, filter) {
        $('#' + uc).html('');
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly>Select UC</option>';
                var dist = $('#hidden_slug_ucs').val();

                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ucCode + '"  ' + (dist == v.ucCode || response.length == 1 ? 'selected' : '') + '>' + v.ucName + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + uc).html('').html(items);
            });
        } else {
            $('#' + uc).html('');
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        if (district == '' || district == undefined || district == '0' || district == '$1') {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            if (ucs == '' || ucs == undefined || ucs == '0') {
                ucs = '';
            }
            window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Camp_team?d=' + district + '&u=' + ucs;
        }

    }

</script>