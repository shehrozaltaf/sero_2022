<style>
    table.dataTable td{
        padding: 2px !important;
    }
    table.dataTable th{
        padding: 10px !important;
    }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Dashboard User Activity</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">User Activity</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors2">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-sm-12"> <p>Status: <strong> <?= (isset($user[0]->status) && $user[0]->status=='1'?'Active':'Revoked/Deleted')?></strong></p></div>
                                        <div class="col-sm-6"> <p>Created By: <strong> <?= (isset($user[0]->userCreatedBy) && $user[0]->userCreatedBy!=''?$user[0]->userCreatedBy:'')?></strong></p></div>
                                        <div class="col-sm-6"> <p>Created DateTime: <strong><?= (isset($user[0]->userCreatedDateTime) && $user[0]->userCreatedDateTime!=''?date('d-M-Y H:i:s',strtotime($user[0]->userCreatedDateTime)):'')?></strong></p></div>
                                        <div class="col-sm-6"> <p>Last Updated By: <strong><?= (isset($user[0]->updateBy) && $user[0]->updateBy!=''?$user[0]->updateBy:'')?></strong></p></div>
                                        <div class="col-sm-6"> <p>Last Updated DateTime: <strong><?= (isset($user[0]->updatedDateTime) && $user[0]->updatedDateTime!=''?date('d-M-Y H:i:s',strtotime($user[0]->updatedDateTime)):'')?></strong></p></div>
                                        <div class="col-sm-6"> <p>Revoke/Deleted By: <strong><?= (isset($user[0]->deleteBy) && $user[0]->deleteBy!=''?$user[0]->deleteBy:'')?></strong></p></div>
                                        <div class="col-sm-6"> <p>Revoke/Deleted DateTime: <strong><?= (isset($user[0]->deletedDateTime) && $user[0]->deletedDateTime!=''?date('d-M-Y H:i:s',strtotime($user[0]->deletedDateTime)):'')?></strong></p></div>
                                    </div>

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
            <section id="column-selectors">
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
<!-- END: Content-->

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
</script>