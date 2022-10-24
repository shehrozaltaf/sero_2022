<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Camps</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Camps
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
                                        <div class="col-sm-4 col-12">
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
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                UC
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select"
                                                        onchange="changeUC('ucs_select','area_select',1)">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Area
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control area_select" id="area_select">
                                                    <option value="0" readonly disabled selected>Area</option>
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
                                                    Camp
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
                                    <h4 class="card-title">Camps</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th width="10%">Area</th>
                                                    <th width="9%">Plan Date</th>
                                                    <th width="9%">MHS No</th>
                                                    <th>Status</th>
                                                    <th>Conducted Date</th>
                                                    <th>Duration (days)</th>
                                                    <th>Remarks</th>
                                                    <th>Doctors</th>
                                                    <th>Locked</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) { ?>
                                                        <tr>
                                                            <td><?php echo $r['area_name'] ?></td>
                                                            <td><?php if (isset($r['plan_date']) && $r['plan_date'] != '') {
                                                                    $plan_date = date('Y, n, j', strtotime($r['plan_date']));
                                                                    $hiddenplan_date = date('d-m-Y', strtotime($r['plan_date']));
                                                                    echo date('d-m-Y', strtotime($r['plan_date']));
                                                                } else {
                                                                    $plan_date = 'true';
                                                                    $hiddenplan_date = '';
                                                                    echo '-';
                                                                }

                                                                if (isset($r['camp_status']) && $r['camp_status'] != '') {
                                                                    if ($r['camp_status'] == 'Planned') {
                                                                        $camp_status = '<span class="text-primary">Planned</span>';
                                                                    } elseif ($r['camp_status'] == 'Conducted') {
                                                                        $camp_status = '<span class="text-success">Conducted</span>';
                                                                    } elseif ($r['camp_status'] == 'Canceled') {
                                                                        $camp_status = '<span class="text-danger">Canceled</span>';
                                                                    } else {
                                                                        $camp_status = '';
                                                                    }
                                                                } else {
                                                                    $camp_status = '';
                                                                }
                                                                ?></td>
                                                            <td><?php echo(isset($r['camp_no']) && $r['camp_no'] != '' ? $r['camp_no'] : '') ?></td>
                                                            <td><?php echo $camp_status ?></td>
                                                            <td><?php echo(isset($r['execution_date']) && $r['execution_date'] != '' ? date('d-m-Y', strtotime($r['execution_date'])) : '') ?></td>
                                                            <td><?php echo(isset($r['execution_duration']) && $r['execution_duration'] != '' ? $r['execution_duration'] : '') ?></td>

                                                            <td><?php echo(isset($r['remarks']) && $r['remarks'] != '' ? $r['remarks'] : '') ?></td>
                                                            <td><?php echo $r['doctors'] ?></td>
                                                            <?php
                                                            $locked_event = '';
                                                            $l_class = '';
                                                            if ($r['locked'] == 1) {
                                                                $loc = 'Locked';
                                                                $locked_icon = 'icon-lock';
                                                                $l_class = 'bg-gradient-danger';
                                                                if ($_SESSION['login']['idUser'] == 1 && $_SESSION['login']['idGroup'] == 1) {
                                                                    $locked_event = ' <a href="javascript:void(0)" onclick="getunLock(this)">
                                                                    <i class="feather ' . $locked_icon . '"></i> 
                                                                    </a>';
                                                                } else {
                                                                    $locked_event = '<i class="feather ' . $locked_icon . '"></i> ';
                                                                }

                                                            } elseif ($r['locked'] == 0) {
                                                                $loc = 'UnLock';
                                                                $locked_icon = 'icon-unlock';
                                                                $l_class = 'bg-gradient-success';
                                                                if ($r['camp_status'] == 'Conducted') {
                                                                    $locked_event = ' <a href="javascript:void(0)" onclick="getLock(this)">
                                                                    <i class="feather ' . $locked_icon . '"></i> 
                                                                    </a>';
                                                                }
                                                            } else {
                                                                $loc = '';
                                                                $locked_icon = '';
                                                            } ?>
                                                            <td><a href="javascript:void(0)"
                                                                   class="btn btn-sm <?php echo $l_class; ?>"><?php echo $loc; ?></a>
                                                            </td>
                                                            <td data-id="<?php echo $r['id'] ?>">
                                                                <?php
                                                                if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) {
                                                                    echo $locked_event;
                                                                }
                                                                if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1 && $r['locked'] == 0 && $r['camp_status'] != 'Conducted') { ?>
                                                                    <a href="javascript:void(0)" onclick="getEdit(this)"
                                                                       data-plandate="<?php echo $plan_date; ?>"
                                                                       data-hiddenplandate="<?php echo $hiddenplan_date; ?>"><i
                                                                                class="feather icon-edit"></i> </a>
                                                                <?php } ?>
                                                                <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1 && $r['locked'] == 0) { ?>
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
                                                    <th width="10%">Area</th>
                                                    <th width="9%">Plan Date</th>
                                                    <th width="9%">MHS No</th>
                                                    <th>Status</th>
                                                    <th>Conducted Date</th>
                                                    <th>Duration (days)</th>
                                                    <th>Remarks</th>
                                                    <th>Doctors</th>
                                                    <th>Locked</th>
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

<input type="hidden" id="hidden_slug_ucs" value="<?php echo(isset($slug_ucs) && $slug_ucs != '' ? $slug_ucs : ''); ?>">
<input type="hidden" id="hidden_slug_area" value="<?php echo(isset($slug_area) && $slug_area != '' ? $slug_area : ''); ?>">
<!-- Modal -->
<!-- END: Content-->
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="modal  fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add Camp</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="camp_rounds">Rounds: </label>
                        <input type="number" class="form-control" min="1" minlength="1"
                               onchange="getMaxCampNo('camp_no')" autocomplete="camp_rounds"
                               max="1" maxlength="1" id="camp_rounds" name="camp_rounds" value="1" equired>
                    </div>
                    <div class="camp_plan">

                    </div>

                    <!--<div class="form-group">
                        <label for="camp_doctors">Doctors: </label>
                        <select class="select2 form-control" id="camp_doctors" name="camp_doctors[]"
                                multiple="multiple" required>
                        </select>
                    </div>-->


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger mybtn" onclick="addData()">Add</button>
                </div>
                <div class="m-1">
                    <h5 class=" bg-primary white  p-1">Summary: </h5>
                    <table id="tblaudit" class=" text-center" width='100%' border="1">
                        <thead>
                        <tr>
                            <th>Camp No</th>
                            <th>Round</th>
                            <th>Plan Date</th>
                            <th>Status</th>
                            <th>Conducted Date</th>
                        </tr>
                        </thead>
                        <tbody class="tblaudit_body">
                        </tbody>
                    </table>
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
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit Camp</h4>

                    <input type="hidden" id="edit_idCamp" name="edit_idCamp">
                    <input type="hidden" id="edit_hiddenplan_date" name="edit_hiddenplan_date">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="camp_status">Status: </label>
                        <select class="select2 form-control" onchange="disbaledInps_Cancel()"
                                id="camp_status" required>
                            <option value="0" readonly disabled selected>Status</option>
                            <option value="Conducted">Conducted</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="execution_date">Conducted Date: </label>
                        <input type="text" class="form-control mypickadat_execution" id="execution_date"
                               name="execution_date" autocomplete="execution_date"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="execution_duration">Camp Duration (days): </label>
                        <input type="number" value="1" class="form-control" id="execution_duration"
                               name="execution_duration" autocomplete="execution_duration" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks: </label>
                        <textarea name="remarks" class="form-control" id="remarks" cols="10" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="editData()">Update
                    </button>
                </div>

            </div>
        </div>
    </div>

<?php } ?>

<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="lockModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_lock"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_lock">Lock Camp</h4>
                    <input type="hidden" id="lock_idCamp" name="lock_idCamp">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to Lock this camp?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="lockData()">Lock
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1 && $_SESSION['login']['idUser'] == 1 && $_SESSION['login']['idGroup'] == 1) { ?>
    <div class="modal fade text-left" id="unlockModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_unlock"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_lock">Unlock Camp</h4>
                    <input type="hidden" id="unlock_idCamp" name="unlock_idCamp">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to unlock this camp?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="unlockData()">Unlock
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
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Camp</h4>
                    <input type="hidden" id="delete_idCamp" name="delete_idCamp">
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
        changeDistrict('district_select', 'ucs_select', 1);
        mydate();
        limit_numeric('camp_rounds', 1);
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

    function disbaledInps_Cancel() {
        var camp_status = $('#camp_status').val();
        if (camp_status == 'Canceled') {
            $('#remarks').attr('required', 'required');
            $('#execution_date').val('').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#execution_duration').val('').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
        } else {
            $('#remarks').removeAttr('required');
            $('#execution_date').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#execution_duration').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
        }
    }

    function addModal() {
        var flag = 0;
        var data = {};
        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();
        data['area'] = $('#area_select').val();
        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (data['area'] == '' || data['area'] == undefined || data['area'] == '0' || data['area'] == '$1') {
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;
        }
        if (flag == 0) {
            showloader();
            $('#tblaudit .tblaudit_body').html('');
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp/getCampDetail'); ?>', data, 'POST', function (result) {
                hideloader();
                var items = '';
                if (result != '' && JSON.parse(result.length > 0)) {
                    var response = JSON.parse(result);
                    try {
                        $.each(response, function (i, v) {
                            items += '<tr>' +
                                '<td>' + v.camp_no + '</td>' +
                                '<td>' + v.camp_round + '</td>' +
                                '<td>' + v.plan_date + '</td>' +
                                '<td>' + v.camp_status + '</td>' +
                                '<td>' + (v.execution_date != '' && v.execution_date != undefined ? v.execution_date : '-') + '</td>' +
                                '</tr>';
                        });
                        getMaxCampNo('camp_no');
                        changeUC_doctors('camp_doctors');
                        $('#tblaudit .tblaudit_body').html(items);
                        $('#addModal').modal('show');
                    } catch (e) {
                    }
                }
            });

        }

    }

    function addData() {
        $('#addModal').find('.error').removeClass('error');
        var flag = 0;
        var data = {};
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['area'] = $('#area_select').val();
        data['camp_rounds'] = $('#camp_rounds').val();
        // data['camp_doctors'] = $('#camp_doctors').val();
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
            return false;
        }
        if (data['ucCode'] == '' || data['ucCode'] == undefined) {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
            return false;
        }
        if (data['area'] == '' || data['area'] == undefined) {
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;
            return false;
        }
        if (data['camp_rounds'] == '' || data['camp_rounds'] == undefined) {
            $('#camp_rounds').css('border', '1px solid red');
            toastMsg('Rounds', 'Invalid Rounds', 'error');
            flag = 1;
            return false;
        }

        var camp_no = [];
        var c = $('.camp_plan .row');
        $.each(c, function (k, v) {
            var rounds = $(this).attr('data-round');
            var camp = {};
            camp['rounds'] = rounds;
            $.each($(v).find('.inputs'), function (kk, vv) {
                var lab = $(vv).attr('data-label');
                var inp = $(vv).val();
                $(this).removeClass('error');
                if (inp == undefined || inp == '') {
                    toastMsg('Error', 'Invalid Value', 'error');
                    $(this).addClass('error');
                    flag = 1;
                    return false;
                }
                camp[lab] = inp;
            });
            camp_no.push(camp);
        });
        data['camps'] = camp_no;


        /*   if (data['camp_doctors'] == '' || data['camp_doctors'] == undefined) {
               $('#camp_doctors').css('border', '1px solid red');
               toastMsg('Camp Doctor', 'Invalid Camp Doctor', 'error');
               flag = 1;
               return false;
           }*/


        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp/addCamp'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Camp?d=' + data['dist_id'] + '&u=' + data['ucCode'] + '&a=' + data['area'];
                    }, 500);
                } else if (result == 2) {
                    $('#dist_id').css('border', '1px solid red');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (result == 3) {
                    $('#ucCode').css('border', '1px solid red');
                    toastMsg('UC', 'Invalid UC', 'error');
                } else if (result == 4) {
                    $('#area_no').css('border', '1px solid red');
                    toastMsg('Area', 'Invalid Area', 'error');
                } else if (result == 5) {
                    $('#camp_rounds').css('border', '1px solid red');
                    toastMsg('Rounds', 'Invalid Rounds', 'error');
                } else if (result == 6) {
                    toastMsg('Camp', 'Invalid Camp', 'error');
                } else if (result == 7) {
                    $('#camp_doctors').css('border', '1px solid red');
                    toastMsg('Camp Doctor', 'Invalid Camp Doctor', 'error');
                } else if (result == 8) {
                    toastMsg('Error', 'Your Camp is already exist', 'error');
                } else if (result == 10) {
                    $('#camp_doctors').css('border', '1px solid red');
                    toastMsg('Error', 'Camp not added', 'error');
                } else if (result == 11) {
                    toastMsg('Error', 'Camp added but doctors not added', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getEdit(obj) {
        var id = $(obj).parent('td').attr('data-id');
        var dates = $(obj).attr('data-plandate');
        var edit_hiddenplan_date = $(obj).attr('data-hiddenplandate');
        var min = true;
        if (dates != '' && dates != undefined) {
            min = new Date(dates);
        }
        // $('#execution_date').removeAttr('class').addClass('form-control').addClass('mypickadat_execution'+id);
        $('.mypickadat_execution').pickadate({
            destroy: true,
            stop: true,
            reset: true,
            start: true,
            selectYears: true,
            selectMonths: true,
            min: new Date(2021, 2, 1),
            max: true,
            format: 'dd-mm-yyyy'
        }).stop();

        $('#edit_idCamp').val(id);
        $('#edit_hiddenplan_date').val(edit_hiddenplan_date);
        $('#editModal').modal('show');
    }

    function editData() {
        $('#camp_status').css('border', '1px solid #babfc7');
        $('#execution_date').css('border', '1px solid #babfc7');
        $('#execution_duration').css('border', '1px solid #babfc7');
        $('#remarks').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idCamp'] = $('#edit_idCamp').val();
        data['camp_status'] = $('#camp_status').val();
        data['execution_date'] = $('#execution_date').val();
        data['execution_duration'] = $('#execution_duration').val();
        data['remarks'] = $('#remarks').val();
        if (data['idCamp'] == '' || data['idCamp'] == undefined || data['idCamp'].length < 1) {
            flag = 1;
            toastMsg('Camp', 'Invalid Camp', 'error');
            return false;
        }
        if (data['camp_status'] == '' || data['camp_status'] == undefined || data['camp_status'].length < 1) {
            $('#camp_status').css('border', '1px solid red');
            toastMsg('Status', 'Invalid Status', 'error');
            flag = 1;
            return false;
        }
        if ((data['execution_date'] == '' || data['execution_date'] == undefined || data['execution_date'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#execution_date').css('border', '1px solid red');
            toastMsg('Execution Date', 'Invalid Execution Date', 'error');
            flag = 1;
            return false;
        }
        if ((data['execution_duration'] == '' || data['execution_duration'] == undefined || data['execution_duration'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#execution_duration').css('border', '1px solid red');
            toastMsg('Execution Duration', 'Invalid Execution Duration', 'error');
            flag = 1;
            return false;
        }
        if ((data['remarks'] == '' || data['remarks'] == undefined || data['remarks'].length < 1) && data['camp_status'] == 'Canceled') {
            $('#remarks').css('border', '1px solid red');
            toastMsg('Remarks', 'Invalid Remarks', 'error');
            flag = 1;
            return false;
        }
        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp/editData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Camp', 'Successfully Edited', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Camp', 'Invalid Camp', 'error');
                } else if (res == 3) {
                    $('#camp_status').css('border', '1px solid red');
                    toastMsg('Status', 'Invalid Status', 'error');
                } else if (res == 4) {
                    $('#participant_no').css('border', '1px solid red');
                    toastMsg('Participant No', 'Invalid Participant No', 'error');
                } else if (res == 5) {
                    $('#refuses_no').css('border', '1px solid red');
                    toastMsg('Refuses No', 'Invalid Refuses No', 'error');
                } else if (res == 6) {
                    $('#remarks').css('border', '1px solid red');
                    toastMsg('Remarks', 'Invalid Remarks', 'error');
                } else if (res == 8) {
                    $('#execution_date').css('border', '1px solid red');
                    toastMsg('Execution Date', 'Invalid Execution Date', 'error');
                } else if (res == 9) {
                    $('#execution_duration').css('border', '1px solid red');
                    toastMsg('Execution Duration', 'Invalid Execution Duration', 'error');
                } else {
                    toastMsg('Camp', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getLock(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#lock_idCamp').val(id);
        $('#lockModal').modal('show');
    }

    function lockData() {
        var data = {};
        data['idCamp'] = $('#lock_idCamp').val();
        if (data['idCamp'] == '' || data['idCamp'] == undefined || data['idCamp'] == 0) {
            toastMsg('Camp', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp/lockData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#lockModal').modal('hide');
                    toastMsg('Camp', 'Successfully Locked', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Camp', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Camp', 'Invalid Camp', 'error');
                }

            });
        }
    }

    function getunLock(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#unlock_idCamp').val(id);
        $('#unlockModal').modal('show');
    }

    function unlockData() {
        var data = {};
        data['idCamp'] = $('#unlock_idCamp').val();
        if (data['idCamp'] == '' || data['idCamp'] == undefined || data['idCamp'] == 0) {
            toastMsg('Camp', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp/unlockData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#unlockModal').modal('hide');
                    toastMsg('Camp', 'Successfully Unlocked', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Camp', 'Something went wrong', 'error');
                } else if (res == 4) {
                    toastMsg('Error', 'You don`t have permission to unlock, Please coordinate with DMU', 'error');
                } else {
                    toastMsg('Camp', 'Invalid Camp', 'error');
                }


            });
        }
    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_idCamp').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idCamp'] = $('#delete_idCamp').val();
        if (data['idCamp'] == '' || data['idCamp'] == undefined || data['idCamp'] == 0) {
            toastMsg('Camp', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Camp/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#deleteModal').modal('hide');
                    toastMsg('Camp', 'Successfully Deleted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Camp', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Camp', 'Invalid Camp', 'error');
                }

            });
        }
    }

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: new Date(2021, 2, 1),
            max: new Date(2021, 11, 31),
            format: 'dd-mm-yyyy'
        });
    }

    function getMaxCampNo(campno) {
        var flag = 0;
        var items = '';
        var data = {};

        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();
        data['area'] = $('#area_select').val();
        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (data['area'] == '' || data['area'] == undefined || data['area'] == '0' || data['area'] == '$1') {
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;
        }

        data['camp_rounds'] = $('#camp_rounds').val();
        if (data['camp_rounds'] == '' || data['camp_rounds'] == undefined || data['camp_rounds'] == '0' || data['camp_rounds'] == '$1') {
            data['camp_rounds'] = 1;
            flag = 1;
        }
        if (flag == 0) {
            CallAjax('<?php echo base_url() . 'index.php/Camp_CM/Camp/getMaxCampNo'  ?>', data, 'POST', function (res) {
                var maxcamp = 0;
                var camp_no = 0;
                for (var i = 1; i <= data['camp_rounds']; i++) {
                    maxcamp = parseInt(res) + i;
                    camp_no = data['area'] + '-' + parseInt(maxcamp);
                    items += '<div class="row" data-round="' + maxcamp + '"> ' +
                        '       <div class="col-sm-4">\n' +
                        '                            <div class="form-group">\n' +
                        '                                <label for="camp_no' + i + '">MHS No: <small>(Round: ' + maxcamp + ')</small></label>\n' +
                        '                                <input type="text" class="form-control inputs camp_no" id="camp_no' + i + '" name="camp_no" disabled readonly\n' +
                        '                                       value="' + camp_no + '" data-label="camp" required>\n' +
                        '                            </div>\n' +
                        '                        </div>\n' +
                        '                        <div class="col-sm-4">\n' +
                        '                            <div class="form-group">\n' +
                        '                                <label for="plan_date' + i + '">Plan Date: <small>(Round: ' + maxcamp + ')</small></label>\n' +
                        '                                <input type="text" class="form-control mypickadat inputs plan_date" id="plan_date' + i + '" name="plan_date"\n' +
                        '                                  data-label="plandate"   autocomplete="plandate_add"  required>\n' +
                        '                            </div>\n' +
                        '                        </div>' +
                        '                       <div class="col-sm-4">' +
                        '                           <div class="form-group">\n' +
                        '                                   <label for="camp_doctors' + i + '">Doctors: <small>(Round: ' + maxcamp + ')</small></label>\n' +
                        '                                   <select class="select2 form-control inputs camp_doctors" id="camp_doctors' + i + '" name="camp_doctors[]"\n' +
                        '                                    multiple="multiple" autocomplete="camp_doctors_add" data-label="camp_doctors" required>\n' +
                        '                                   </select>\n' +
                        '                           </div>' +
                        '                       </div>' +
                        '</div>';
                }
                $('.camp_plan').html(items);
                limit_numeric('camp_rounds', 1);
                changeUC_doctors('camp_doctors');
                setTimeout(function () {
                    $('.camp_doctors').select2();
                }, 1000);
                mydate();
            });
        } else {
            $('#' + campno).val('');
        }


    }

    function changeDistrict(dist, uc, filter) {
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        var items = '<option value="0" disabled readonly="">UCs</option>';
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                if (filter == 1) {
                    items = '<option value="0" disabled>Select All</option>';
                }
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
                changeUC('ucs_select', 'area_select', 1);
            });
        } else {
            $('#' + uc).html('').html(items);
        }
    }

    function changeUC(uc, area, filter) {
        var data = {};
        data['uc'] = $('#' + uc).val();
        data['filter'] = 0;
        if (data['uc'] != '' && data['uc'] != undefined && data['uc'] != '0' && data['uc'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Camp_CM/Camp/getAreaByUCs'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly="">Area</option>';
                if (filter == 1) {
                    items = '<option value="0">Select Area</option>';
                }
                var areas = $('#hidden_slug_area').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.area_no + '"  ' + (areas == v.area_no || response.length == 1 ? 'selected' : '') + '>' + v.area_name + ' (' + v.area_no + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + area).html('').html(items);

            });
        } else {
            $('#' + area).html('');
        }
    }

    function changeUC_doctors(doctor) {
        var flag = 0;
        var data = {};
        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();
        data['area'] = $('#area_select').val();
        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        } else {
            CallAjax('<?php echo base_url() . 'index.php/Camp_CM/Camp/getDoctorsByUcs'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly>Doctor</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.idDoctor + '">' + v.staff_name + ' (' + v.staff_type + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.' + doctor).html('').html(items);
            });
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var area = $('.area_select').val();
        if (district == '' || district == undefined || district == '0' || district == '$1') {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            if (ucs == '' || ucs == undefined || ucs == '0') {
                ucs = '';
            }
            if (area == '' || area == undefined || area == '0') {
                area = '';
            }
            window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Camp?d=' + district + '&u=' + ucs + '&a=' + area;
        }
    }

</script>