

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Excel Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Excel Report</li>
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
                                <h4 class="card-title">Cluster Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div>
                                        <h6>Project: TPVICS Round 2</h6>
                                        <h6>Cluster
                                            No: <?php echo(isset($cluster_data[0]->hh02) && $cluster_data[0]->hh02 != '' ? $cluster_data[0]->hh02 : ''); ?></h6>
                                        <h6>Randomization
                                            Date: <?php echo(isset($cluster_data[0]->randDT) && $cluster_data[0]->randDT != '' ? date('Y-m-d', strtotime($cluster_data[0]->randDT)) : ''); ?></h6>
                                        <h6>  Division: <?php echo(isset($cluster_data[0]->geoarea) && $cluster_data[0]->geoarea != '' ? $cluster_data[0]->geoarea : ''); ?></h6>
                                        <h6>  Area: <?php echo(isset($cluster_data[0]->area) && $cluster_data[0]->area != '' ? $cluster_data[0]->area : ''); ?></h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>Serial No</th>
                                                <th>Tablet No</th>
                                                <th>Household No</th>
                                                <th>Head of the Household</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $SNo = 0;
                                            if (isset($cluster_data) && $cluster_data != '') {
                                                foreach ($cluster_data as $k => $row) {
                                                    $SNo++; ?>
                                                    <tr>
                                                        <td><?php echo $row->sno; ?></td>
                                                        <td><?php echo $row->tabNo; ?></td>
                                                        <td><?php echo $row->tabNo . '-' . substr($row->compid, 12, 8); ?></td>
                                                        <td><?php echo $row->hh08; ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Serial No</th>
                                                <th>Tablet No</th>
                                                <th>Household No</th>
                                                <th>Head of the Household</th>
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
<!-- BEGIN: Page Vendor JS-->
<script>
    $(document).ready(function () {
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
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