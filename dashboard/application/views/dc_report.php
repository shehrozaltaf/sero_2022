<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Health Camp Entry Status</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Health Camp Entry Status
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
                                                Date From
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control mypickadat" id="dateFrom"
                                                       name="dateFrom">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Date To
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control mypickadat" id="dateTo"
                                                       name="dateTo">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Type
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control" id="stfType" name="stfType">
                                                    <option value="0" selected>Select All</option>
                                                    <option value="DMU">DMU</option>
                                                    <option value="OS">OS</option>
                                                    <option value="Field Stf">Field Stf</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                                    Data
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (isset($from) && $from != '') { ?>
                <section id="statistics-card">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card text-white bg-gradient-info text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h2 class="card-title text-white">
                                            <?php
                                            $tot = 0;
                                            if (isset($myData) && $myData != '') {
                                                foreach ($myData as $key => $rows) {
                                                    $tot += $rows->totalCnt;
                                                }
                                            }
                                            echo $tot; ?>
                                        </h2>
                                        <p class="card-text">Total Entries</p>
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
                                    <h4 class="card-title">Health Camp Entry Status</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Count</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $key => $rows) { ?>
                                                        <tr>
                                                            <td><?php echo(isset($rows->full_name) && $rows->full_name != '' ? $rows->full_name : '') ?></td>
                                                            <td><?php echo(isset($rows->dd) && $rows->dd != '' ? $rows->dd : '') ?></td>
                                                            <td><?php echo(isset($rows->dt) && $rows->dt != '' ? date('d-m-Y', strtotime($rows->dt)) : '') ?></td>
                                                            <td><?php echo(isset($rows->totalCnt) && $rows->totalCnt != '' ? $rows->totalCnt : '') ?></td>
                                                        </tr>
                                                    <?php }
                                                } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Count</th>
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
<!-- END: Content-->
<input type="hidden" value="<?php echo(isset($from) && $from != '' ? $from : date('d-m-Y')) ?>" id="slug_from">
<input type="hidden" value="<?php echo(isset($to) && $to != '' ? $to : date('d-m-Y')) ?>" id="slug_to">
<input type="hidden" value="<?php echo(isset($typ) && $typ != '' ? $typ : 0) ?>" id="slug_typ">
<script>

    $(document).ready(function () {
        mydate();
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
            ],
            order: [[ 1, "asc" ]]
        });
        var slug_from = $('#slug_from').val();
        var slug_to = $('#slug_to').val();
        var slug_typ = $('#slug_typ').val();
        $('#dateFrom').val(slug_from);
        $('#dateTo').val(slug_to);
        $('#stfType').val(slug_typ).select2({val: slug_typ});
    });

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: new Date(2021, 2, 1),
            max: new Date(2021, 11, 31),
            format: 'dd-mm-yyyy'
        });
    }

    function searchData() {
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var stfType = $('#stfType').val();
        if (dateFrom == '' || dateFrom == undefined || dateFrom == '0' || dateFrom == '$1') {
            toastMsg('Date From', 'Invalid Date From', 'error');
        } else if (dateTo == '' || dateTo == undefined || dateTo == '0' || dateTo == '$1') {
            toastMsg('Date To', 'Invalid Date To', 'error');
        } else {
            if (stfType == '' || stfType == undefined || stfType == '0') {
                stfType = '';
            }
            window.location.href = '<?php echo base_url() ?>index.php/Dc_report?f=' + dateFrom + '&t=' + dateTo + '&s=' + stfType;
        }
    }
</script>