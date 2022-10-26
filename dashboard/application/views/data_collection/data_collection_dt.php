<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/card-analytics.css">

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Data Collection Progress</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Data Collection</li>
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
                                <h4 class="card-title">Data Collection Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>Province</th>
                                                <th>District</th>
                                                <th>Cluster Number</th>
                                                <th>Households Randomized</th>
                                                <th>Households Visited</th>
                                                <th>Completed</th>
                                                <th>Refused</th>
                                                <th>Others</th>
                                                <th>Children 6-11</th>
                                                <th>Children 12-23</th>
                                                <th>Sample Taken</th>
                                                <th>Cluster Status</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php if (isset($get_linelisting_table) && $get_linelisting_table != '') {
                                                foreach ($get_linelisting_table as $k => $r) {
                                                    $explode = explode("|", $r->geoarea);
                                                    $province = ltrim(rtrim($explode[0]));
                                                    $division = ltrim(rtrim($explode[1]));

                                                    $p_id = substr($r->enumcode, 0, 1);
                                                    $d_id = substr($r->enumcode, 0, 3);


                                                    if ($r->randomized_households > 0) {
                                                        if ($r->one_child == 0) {
                                                            $status = '<span class="label btn btn-sm btn-info">Pending</span>';
                                                        } else if ($r->collected_forms>=18 && $r->sample_taken>=18 ) {
                                                            $status = '<span class="label btn btn-sm btn-success">Completed</span>';
                                                        } else {
                                                            $status = '<span class="label btn btn-sm btn-primary">In Progress</span>';
                                                        }
                                                    } else {
                                                        $status = '<span class="label label-warning btn-sm btn-danger">Not Randomized</span>';
                                                    }

                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Data_collection_progress/dc_index/d' . $p_id . '_t'); ?>">
                                                                <?php echo ucwords(strtolower($province)); ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Data_collection_progress/dc_index/d' . $p_id . '_t/s' . $d_id . '_t'); ?>">
                                                                <?php echo ucwords(strtolower($division)); ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $r->hh02; ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Data_collection_progress/randomized_household/' . $r->hh02); ?>"
                                                               target="_blank">
                                                                <?php echo $r->randomized_households; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Data_collection_progress/collected_household/' . $r->hh02); ?>"
                                                               target="_blank">
                                                                <?php echo $r->collected_forms; ?>
                                                            </a>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Data_collection_progress/completed_household/' . $r->hh02); ?>"
                                                               target="_blank">
                                                                <?php echo $r->completed_forms; ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Data_collection_progress/refused_household/' . $r->hh02); ?>"
                                                               target="_blank">
                                                                <?php echo $r->refused_forms; ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $r->remaining_forms; ?></td>
                                                        <td><?php echo $r->child_6_11months; ?></td>
                                                        <td><?php echo $r->child_12_23months; ?></td>
                                                        <td><?php echo $r->sample_taken; ?></td>
                                                        <td><?php echo $status; ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <th>Province</th>
                                                <th>District</th>
                                                <th>Cluster Number</th>
                                                <th>Households Randomized</th>
                                                <th>Households Visited</th>
                                                <th>Completed</th>
                                                <th>Refused</th>
                                                <th>Others</th>
                                                <th>Children 6-11</th>
                                                <th>Children 12-23</th>
                                                <th>Sample Taken</th>
                                                <th>Cluster Status</th>
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

<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>

<script>
    $(document).ready(function () {
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 25,
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