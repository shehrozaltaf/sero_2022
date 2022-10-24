


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Skip Questions Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Skip Questions Report
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
                                <h4 class="card-title">Form Skip Questions</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <?php if (isset($getFormData) && $getFormData != '') {
                                                    foreach ($getFormData[0] as $k => $r) { ?>
                                                        <th>
                                                            <?php if ($k == 'SkipPecentage') {
                                                                echo 'Skip Pecentage';
                                                            } else {
                                                                echo strtoupper($k);
                                                            } ?>
                                                        </th>
                                                    <?php }
                                                } ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (isset($getFormData) && $getFormData != '') {
                                                foreach ($getFormData as $key => $rows) { ?>
                                                    <tr>
                                                        <?php foreach ($rows as $k => $r) { ?>
                                                            <td>
                                                                <?php if ($k == 'username' || $k == 'total') {
                                                                    echo $r;
                                                                } else {
                                                                    echo $r . '%';
                                                                } ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <?php if (isset($getFormData) && $getFormData != '') {
                                                    foreach ($getFormData[0] as $k => $r) { ?>
                                                        <th>
                                                            <?php if ($k == 'SkipPecentage') {
                                                                echo 'Skip Pecentage';
                                                            } else {
                                                                echo strtoupper($k);
                                                            } ?>
                                                        </th>
                                                    <?php }
                                                } ?>
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
                                <h4 class="card-title">Child Skip Questions</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped childTable">
                                            <thead>
                                            <tr>
                                                <?php if (isset($getChildData) && $getChildData != '') {
                                                    foreach ($getChildData[0] as $k => $r) { ?>
                                                        <th><?php if ($k == 'SkipPecentage') {
                                                                echo 'Skip Pecentage';
                                                            } else {
                                                                echo strtoupper($k);
                                                            } ?>
                                                        </th>
                                                    <?php }
                                                } ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($getChildData) && $getChildData != '') {
                                                foreach ($getChildData as $key => $rows) { ?>
                                                    <tr>
                                                        <?php foreach ($rows as $k => $r) { ?>
                                                            <td> <?php if ($k == 'username' || $k == 'total') {
                                                                    echo $r;
                                                                } else {
                                                                    echo $r . '%';
                                                                } ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <?php if (isset($getChildData) && $getChildData != '') {
                                                    foreach ($getChildData[0] as $k => $r) { ?>
                                                        <th><?php if ($k == 'SkipPecentage') {
                                                                echo 'Skip Pecentage';
                                                            } else {
                                                                echo strtoupper($k);
                                                            } ?>
                                                        </th>
                                                    <?php }
                                                } ?>
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

</script>

<script>
    $(document).ready(function () {
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 10,
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
        $('.childTable').DataTable({
            dom: 'Bfrtip',
            "displayLength": 10,
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