<style>
    table.dataTable td {
        padding: 2px !important;
    }

    table.dataTable th {
        padding: 10px !important;
    }
</style>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Logs</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Users - Log Report
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="basic-select2  ">
                <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form action="javascript:void(0)" autocomplete="off">
                                        <div class="row printcontent">
                                            <div class="col-sm-12 col-md-12 col-6">
                                                <div class="form-group">
                                                    <label for="idUser" class="label-control">User</label>
                                                    <select name="idUser" id="idUser"
                                                            class="form-control select2 idUser">
                                                        <option value="0">All Users</option>
                                                        <?php
                                                        if (isset($user) && $user != '') {
                                                            foreach ($user as $u) {
                                                                echo '<option value="' . $u->id . '" ' . (isset($user_slug) && $user_slug == $u->id ? 'selected' : '') . '>' . $u->full_name . ' (' . $u->username . ')</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-12 ">
                                                <button type="button" class="btn btn-primary mybtn" onclick="getData()">
                                                    Get Report
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="column-selectors2" class="main_content_div">
                <?php if (isset($user_slug) && $user_slug != '' && $user_slug != '0') { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    User Data
                                </div>
                                <div class="card-content">
                                    <div class="card-body ">
                                        <ul>
                                            <li>User Name:
                                                <strong><?php echo(isset($getUserData[0]->username) && $getUserData[0]->username != '' ? $getUserData[0]->username : ''); ?></strong>
                                            </li>
                                            <li>User Created by:
                                                <strong><?php echo(isset($getUserData[0]->createdBy) && $getUserData[0]->createdBy != '' ? $getUserData[0]->createdBy : ''); ?></strong>
                                            </li>
                                            <li>User Created date:
                                                <strong><?php echo(isset($getUserData[0]->createdDateTime) && $getUserData[0]->createdDateTime != '' ? date('d-M-Y H:i:s', strtotime($getUserData[0]->createdDateTime)) : ''); ?></strong>
                                            </li>
                                            <li>User Roles/privileges:
                                                <strong><?php echo(isset($getUserData[0]->groupName) && $getUserData[0]->groupName != '' ? $getUserData[0]->groupName : ''); ?></strong>
                                            </li>
                                            <li>User Access level:
                                                <strong><?php echo(isset($getUserData[0]->groupName) && $getUserData[0]->groupName != '' ? $getUserData[0]->groupName : ''); ?></strong>
                                            </li>
                                            <li>User Access Rights Assigned by:
                                                <strong><?php echo(isset($getUserData[0]->createdBy) && $getUserData[0]->createdBy != '' ? $getUserData[0]->createdBy : ''); ?></strong>
                                            </li>
                                            <li>User Modified by:
                                                <strong><?php echo(isset($getUserData[0]->updateBy) && $getUserData[0]->updateBy != '' ? $getUserData[0]->updateBy : ''); ?></strong>
                                            </li>
                                            <li>User Modified date:
                                                <strong><?php echo(isset($getUserData[0]->updatedDateTime) && $getUserData[0]->updatedDateTime != '' ? date('d-M-Y H:i:s', strtotime($getUserData[0]->updatedDateTime)) : ''); ?></strong>
                                            </li>
                                            <li>User Revoked by:
                                                <strong><?php echo(isset($getUserData[0]->deleteBy) && $getUserData[0]->deleteBy != '' ? $getUserData[0]->deleteBy : ''); ?></strong>
                                            </li>
                                            <li>User Revoked/disabled date:
                                                <strong><?php echo(isset($getUserData[0]->deletedDateTime) && $getUserData[0]->deletedDateTime != '' ? date('d-M-Y H:i:s', strtotime($getUserData[0]->deletedDateTime)) : ''); ?></strong>
                                            </li>
                                            <li>User Last login date:
                                                <strong><?php echo(isset($getUserData[0]->getLastLogin) && $getUserData[0]->getLastLogin != '' ? date('d-M-Y H:i:s', strtotime($getUserData[0]->getLastLogin)) : ''); ?></strong>
                                            </li>
                                            <li>User Status:
                                                <strong><?php if (isset($getUserData[0]->status) && $getUserData[0]->status == '1') {
                                                        echo '<span class="primary">Active</span>';
                                                    } else {
                                                        echo '<span class="danger">Revoked</span>';
                                                    } ?></strong></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">

                                    <div class="table-responsive">
                                        <h4 class="card-title">User Login Activity</h4>
                                        <table class="table table-striped dataex-html5-selectors-login">
                                            <thead>
                                            <tr>
                                                <th>SNO</th>
                                                <th>Result</th>
                                                <th>User</th>
                                                <th>Date Time</th>
                                                <th>IP</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            if (isset($getUserLoginActivity) && $getUserLoginActivity != '') {
                                                $s = 1;
                                                foreach ($getUserLoginActivity as $k => $u) { ?>
                                                    <tr>
                                                        <td><?php echo $s++ ?></td>
                                                        <td><?php echo wordwrap($u->result, 80, "<br>\n") ?></td>
                                                        <td><?php echo $u->full_name ?></td>
                                                        <td><?php echo date('d-M-Y H:i:s', strtotime($u->attempted_at)) ?></td>
                                                        <td><?php echo $u->ip_address ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNO</th>
                                                <th>Result</th>
                                                <th>User</th>
                                                <th>Date Time</th>
                                                <th>IP</th>
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
            <section id="column-selectors" class="main_content_div">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Daily Log</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Activity</th>
                                                <th>Result</th>
                                                <th>User</th>
                                                <th>Date Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            if (isset($getUserActivity) && $getUserActivity != '') {
                                                $ss = 1;
                                                foreach ($getUserActivity as $k => $u) { ?>
                                                    <tr>
                                                        <td><?php echo $ss++; ?></td>
                                                        <td><?php echo wordwrap($u->activityName, 50, "<br>\n") ?></td>
                                                        <td><?php echo wordwrap($u->result, 50, "<br>\n") ?></td>
                                                        <td><?php echo $u->full_name ?></td>
                                                        <td><?php echo date('d-M-Y H:i:s', strtotime($u->createdDateTime)) ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Activity</th>
                                                <th>Result</th>
                                                <th>User</th>
                                                <th>Date Time</th>
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
        $('.dataex-html5-selectors-login').DataTable({
            dom: 'Bfrtip',
            "displayLength": 15,
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
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 15,
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

    function getData() {
        var flag = 0;
        var data = {};
        data['idUser'] = $('#idUser').val();
        if (data['idUser'] == '' || data['idUser'] == undefined || data['idUser'] == 0 || data['idUser'] == '0') {
            $('#idUser').css('border', '1px solid red');
            flag = 1;
            toastMsg('User', 'Invalid User', 'error');
            return false;
        } else {
            var url = '<?php echo base_url()?>index.php/Users/log_reports?u=' + data['idUser'];
            window.location.href = url;
        }
    }

</script>