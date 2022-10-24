<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Randomized Households</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Randomized Households</li>
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
                                <h4 class="card-title">Randomized Households Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>Serial No</th>
                                                <th>Hosuehold No</th>
                                                <th>Sample Collected</th>
                                                <th>Children 6-11</th>
                                                <th>Children 12-23</th>
                                                <th>Result of Household Questionnaire</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($data) && $data != '') {
                                                $sno = 0;
                                                foreach ($data as $k => $row) {
                                                    $sno++;
                                                    $get_status = $row->istatus;
                                                    if ($get_status == 0) {
                                                        $status = '<span class="label btn btn-sm btn-info">Not Collected Yet</span>';
                                                    } else if ($get_status == 1) {
                                                        $status = '<span class="label btn btn-sm btn-success">Completed</span>';
                                                    } else if ($get_status == 2) {
//                                                        $status = '<span class="label label btn btn-sm btn-warning">Partially Complete</span>';
                                                        $status = '<span class="label label btn btn-sm btn-warning">No HH member at home or no competent respondent at home at time of visit</span>';
                                                    } else if ($get_status == 3) {
//                                                        $status = '<span class="label btn btn-sm btn-danger">Refused</span>';
                                                        $status = '<span class="label label btn btn-sm btn-mycolor1">Entire household absent for extended period of time</span>';
                                                    } else if ($get_status == 4) {
//                                                        $status = '<span class="label label btn btn-sm btn-mycolor1">Entire household absent for extended period of time</span>';
                                                        $status = '<span class="label btn btn-sm btn-danger">Refused</span>';
                                                    } else if ($get_status == 5) {
//                                                        $status = '<span class="label label btn btn-sm btn-primary">Not Eligible Child </span>';
                                                        $status = '<span class="label btn btn-sm btn-mycolor2">Dwelling vacant or address not a dwelling </span>';
                                                    } else if ($get_status == 6) {
//                                                        $status = '<span class="label btn btn-sm btn-mycolor2">Dwelling vacant or address not a dwelling </span>';
                                                        $status = '<span class="label label btn btn-sm btn-mycolor3">Dwelling not found</span>';
                                                    } else if ($get_status == 7) {
//                                                        $status = '<span class="label label btn btn-sm btn-mycolor3">Dwelling not found</span>';
                                                        $status = '<span class="label label btn btn-sm btn-primary">Not Eligible Child </span>';
                                                    } else if ($get_status == 96) {
                                                        $status = '<span class="label label btn btn-sm btn-info">Other</span>';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sno; ?></td>
                                                        <td><?php echo $row->hhno; ?></td>
                                                        <td><?php
                                                            if ($row->sample_collected == 1) {
                                                                echo 'Yes';
                                                            } elseif ($row->sample_collected == 2) {
                                                                echo 'No';
                                                            } else {
                                                                echo '-';
                                                            } ?></td>
                                                        <td><?php

                                                            if (isset($row->child_6_11months) && $row->child_6_11months != '' && $row->child_6_11months != 0) {
                                                                echo 'Yes';
                                                            } else {
                                                                echo '-';
                                                            } ?></td>
                                                        <td><?php if (isset($row->child_12_23months) && $row->child_12_23months != '' && $row->child_12_23months != 0) {
                                                                echo 'Yes';
                                                            } else {
                                                                echo '-';
                                                            } ?></td>
                                                        <td><?php echo $get_status; ?></td>
                                                        <td><?php echo $status; ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Serial No</th>
                                                <th>Hosuehold No</th>
                                                <th>Sample Collected</th>
                                                <th>Children 6-11</th>
                                                <th>Children 12-23</th>
                                                <th>Result of Household Questionnaire</th>
                                                <th>Status</th>
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


<script>
    $(document).ready(function () {
        $('.dataex-html5-selectors').DataTable({
            destroy: true,
            lengthMenu: [25, 50, 75, 100],
            pageLength: 50,
            iDisplayLength: 50,
            dom: 'Bfrtip',
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
                },
                {
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
                            'Export.xlsx'
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