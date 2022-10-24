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
                        <h2 class="content-header-title float-left mb-0">Line Listing Progress</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Line Listing</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Analytics card section start -->
            <section id="analytics-card">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">Total Clusters</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0"><?php
                                                $t_cluster_url = 'o';
                                                $c_cluster_url = 'o';
                                                $ip_cluster_url = 'o';
                                                $r_cluster_url = 'o';
                                                if (isset($totalcluster['total']) && $totalcluster['total'] != '') {
                                                    echo $totalcluster['total'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?></h1>
                                            <small>Clusters</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="total_linelisting" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body completed_clusters">
                                    <?php $colors = array('primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                                        'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                                        'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3',
                                        'primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                                        'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                                        'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3');

                                    if (isset($totalcluster['list']) && $totalcluster['list'] != '') {
                                        $s = 0;
                                        foreach ($totalcluster['list'] as $k => $t_list) { ?>
                                            <a href="<?php echo base_url('index.php/Dashboard/dashboard_index/d' . $t_list['id'] . '_' . $t_cluster_url) ?>">
                                                <div class="d-flex justify-content-between mb-25">
                                                    <div class="browser-info">
                                                        <p class="mb-25"><?php echo ucfirst($t_list['district']); ?></p>
                                                    </div>
                                                    <div class="stastics-info text-right">
                                                        <span><?php echo $t_list['clusters_by_district']; ?></span>
                                                    </div>

                                                </div>
                                            </a>
                                            <div class="progress progress-bar-<?php echo $colors[$s] ?> mb-2">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="<?php echo $t_list['clusters_by_district']; ?>"
                                                     aria-valuemin="100" aria-valuemax="100"
                                                     style="width:100%"></div>
                                            </div>  <?php $s++;
                                        }

                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <h4 class="card-title">Completed Clusters</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <?php if (!isset($completed['total']) || $completed['total'] == '') {
                                                $completed['total'] = 0;
                                            }
                                            $perc_completed = ($completed['total'] / $totalcluster['total']) * 100;
                                            echo '<input type="hidden" id="comp_percentage" value="' . $perc_completed . '">'; ?>
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                <?php echo(isset($completed['total']) && $completed['total'] != '' ? $completed['total'] : 0) ?>
                                            </h1>
                                            <small>Clusters</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="completed-chart" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body completed_clusters">
                                    <?php if (isset($completed) && $completed != '') {
                                        $s = 0;
                                        foreach ($completed as $k => $d) {
                                            if ($k != 'total') {
                                                if (!isset($d) || $d == '') {
                                                    $d = 0;
                                                    $t = 0;
                                                }
                                                $id = 0;
                                                foreach ($totalcluster['list'] as $dis) {
                                                    if ($dis['district'] == $k) {
                                                        $t = $dis['clusters_by_district'];
                                                        $id = $dis['id'];
                                                    }
                                                }
                                                $perc = ($d / $t) * 100;
                                                ?>
                                                <a href="<?php echo base_url('index.php/Dashboard/dashboard_index/d' . $id . '_' . $c_cluster_url) ?>">
                                                    <div class="d-flex justify-content-between mb-25">
                                                        <div class="browser-info">
                                                            <p class="mb-25"><?php echo $k; ?></p>
                                                        </div>
                                                        <div class="stastics-info text-right">
                                                            <span><?php echo $d; ?> <small>(<?php echo number_format($perc,0); ?>%)</small></span>
                                                        </div>

                                                    </div>
                                                </a>
                                                <div class="progress progress-bar-<?php echo $colors[$s] ?> mb-2">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="<?php echo $perc; ?>"
                                                         aria-valuemin="<?php echo $perc; ?>" aria-valuemax="100"
                                                         style="width:<?php echo $perc; ?>%"></div>
                                                </div>
                                                <?php $s++;
                                            }
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="mb-0">InProgress Clusters</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <?php if (!isset($ip['total']) || $ip['total'] == '') {
                                                $ip['total'] = 0;
                                            }
                                            $perc_ip = ($ip['total'] / $totalcluster['total']) * 100;
                                            echo '<input type="hidden" id="ip_percentage" value="' . $perc_ip . '">'; ?>
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                <?php echo(isset($ip['total']) && $ip['total'] != '' ? $ip['total'] : 0) ?>
                                            </h1>
                                            <small>Clusters</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="inprogress-chart" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <?php if (isset($ip) && $ip != '') {
                                        $s = 0;
                                        foreach ($ip as $k => $d) {
                                            if ($k != 'total') {
                                                if (!isset($d) || $d == '') {
                                                    $d = 0;
                                                    $t = 0;
                                                }
                                                $id = 0;
                                                foreach ($totalcluster['list'] as $dis) {
                                                    if ($dis['district'] == $k) {
                                                        $t = $dis['clusters_by_district'];
                                                        $id = $dis['id'];
                                                    }
                                                }
                                                $perc = ($d / $t) * 100;
                                                ?>
                                                <a href="<?php echo base_url('index.php/Dashboard/dashboard_index/d' . $id . '_' . $ip_cluster_url) ?>">
                                                    <div class="d-flex justify-content-between mb-25">
                                                        <div class="browser-info">
                                                            <p class="mb-25"><?php echo $k; ?></p>
                                                        </div>
                                                        <div class="stastics-info text-right">
                                                            <span><?php echo $d; ?> <small>(<?php echo number_format($perc,0); ?>%)</small></span>
                                                        </div>

                                                    </div>
                                                </a>
                                                <div class="progress progress-bar-<?php echo $colors[$s] ?> mb-2">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="<?php echo $perc; ?>"
                                                         aria-valuemin="<?php echo $perc; ?>" aria-valuemax="100"
                                                         style="width:<?php echo $perc; ?>%"></div>
                                                </div>
                                                <?php $s++;
                                            }
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="mb-0">Remaining Clusters</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <?php if (!isset($r['total']) || $r['total'] == '') {
                                                $r['total'] = 0;
                                            }
                                            $perc_r = ($r['total'] / $totalcluster['total']) * 100;
                                            echo '<input type="hidden" id="r_percentage" value="' . $perc_r . '">'; ?>
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                <?php echo(isset($r['total']) && $r['total'] != '' ? $r['total'] : 0) ?>
                                            </h1>
                                            <small>Clusters</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="remaining-chart" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <?php if (isset($r) && $r != '') {
                                        $s = 0;
                                        foreach ($r as $k => $d) {
                                            if ($k != 'total') {
                                                if (!isset($d) || $d == '') {
                                                    $d = 0;
                                                    $t = 0;
                                                }
                                                $id = 0;
                                                foreach ($totalcluster['list'] as $dis) {
                                                    if ($dis['district'] == $k) {
                                                        $t = $dis['clusters_by_district'];
                                                        $id = $dis['id'];
                                                    }
                                                }
                                                $perc = ($d / $t) * 100;
                                                ?>
                                                <a href="<?php echo base_url('index.php/Dashboard/dashboard_index/d' . $id . '_' . $r_cluster_url) ?>">
                                                    <div class="d-flex justify-content-between mb-25">
                                                        <div class="browser-info">
                                                            <p class="mb-25"><?php echo $k; ?></p>
                                                        </div>
                                                        <div class="stastics-info text-right">
                                                            <span><?php echo $d; ?> <small>(<?php echo number_format($perc,0); ?>%)</small></span>
                                                        </div>

                                                    </div>
                                                </a>
                                                <div class="progress progress-bar-<?php echo $colors[$s] ?> mb-2">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="<?php echo $perc; ?>"
                                                         aria-valuemin="<?php echo $perc; ?>" aria-valuemax="100"
                                                         style="width:<?php echo $perc; ?>%"></div>
                                                </div>
                                                <?php $s++;
                                            }
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Analytics Card section end-->

            <?php if (isset($get_linelisting_table) && $get_linelisting_table != '') { ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Linelisting Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Cluster Number</th>
                                                    <th>Total Structures</th>
                                                    <th>Residential Structures</th>
                                                    <th>HH Targeted Children</th>
                                                    <th>Children 12-23 Months</th>
                                                    <th>Collecting Tabs</th>
                                                    <th>Completed Tabs</th>
                                                    <th>Status</th>
                                                    <th>Randomized</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $sno = 0;
                                                foreach ($get_linelisting_table as $k => $r) {
                                                    $sno++;
                                                    $explode = explode("|", $r->geoarea);
                                                    $province = ltrim(rtrim($explode[0]));
                                                    $division = ltrim(rtrim($explode[1]));
                                                    $p_id = substr($r->enumcode, 0, 3);
                                                    $d_id = substr($r->enumcode, 0, 5);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sno; ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Dashboard/index/d' . $p_id . '_t'); ?>">
                                                                <?php echo ucwords(strtolower($province)); ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo base_url('index.php/Dashboard/index/d' . $p_id . '_t/s' . $d_id . '_t'); ?>">
                                                                <?php echo ucwords(strtolower($division)); ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $r->cluster_no; ?></td>
                                                        <td><?php echo $r->structures; ?></td>
                                                        <td><?php echo $r->residential_structures; ?></td>
                                                        <td><?php echo $r->target_children; ?></td>
                                                        <td><?php echo(isset($r->no_of_children) && $r->no_of_children != '' ? $r->no_of_children : 0) ?></td>
                                                        <td><?php echo $r->collecting_tabs; ?></td>
                                                        <td><?php echo $r->completed_tabs; ?></td>
                                                        <td><?php $rand_show = '';
                                                            if ($r->structures == 0 || $r->structures == '') {
                                                                $rand_show = '2';
                                                                $stat = 'Remaining';
                                                            } else if ($r->status != '1') {
                                                                $rand_show = '1';
                                                                $stat = 'Ready to Randomize';
                                                            } else {
                                                                $rand_show = '3';
                                                                $stat = 'Randomized';
                                                            }
                                                            echo $stat;

                                                            ?></td>

                                                        <?php
                                                        if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1 && $rand_show == '1') {
                                                            echo '<td><a href="javascript:void(0)" onclick="randomizeBtn(this)" data-cluster="' . $r->cluster_no . '" class="btn btn-sm btn-primary">Randomize</a></td>';
                                                        } elseif ($rand_show == '2') {
                                                            echo '<td>-</td>';
                                                        } else {
                                                            echo '<td><a href="' . base_url('index.php/Dashboard/make_pdf/' . $r->cluster_no) . '" target="_blank" class="btn  btn-sm btn-success">Print</a> ';
                                                            echo ' | <a href="' . base_url('index.php/Dashboard/get_excel/' . $r->cluster_no) . '" target="_blank" class="btn btn-sm btn-danger">Get Excel</a></td>';
                                                        } ?>

                                                    </tr>
                                                <?php }
                                                ?>
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>District</th>
                                                    <th>UC</th>
                                                    <th>Cluster Number</th>
                                                    <th>Total Structures</th>
                                                    <th>Residential Structures</th>
                                                    <th>HH Targeted Children</th>
                                                    <th>Children 12-23 Months</th>
                                                    <th>Collecting Tabs</th>
                                                    <th>Completed Tabs</th>
                                                    <th>Status</th>
                                                    <th>Randomized</th>
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

<!-- END: Page JS-->

<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>

<script>

    function randomizeBtn(obj) {
        var data = {};
        data['cluster_no'] = $(obj).attr('data-cluster');
        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            return false;
        } else {
            showloader();
            CallAjax('<?php echo base_url('index.php/Dashboard/systematic_randomizer') ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    setTimeout(function () {
                        window.open('<?php echo base_url() ?>index.php/Data_collection_progress/randomized_household/' + data['cluster_no'], '_blank');
                    }, 1000);
                } else if (result == 2) {
                    toastMsg('Already Randomized', 'Cluster No ' + data['cluster_no'] + ' is Already Randomized', 'info');
                } else if (result == 3) {
                    toastMsg('Zero Households', 'Cluster No ' + data['cluster_no'] + ' has Zero Households', 'danger');
                } else if (result == 4) {
                    toastMsg('Cluster', 'Invalid Cluster No', 'error');
                } else if (result == 5) {
                    toastMsg('Error', 'Error on updating Status', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }


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
    $(window).on("load", function () {
        var $primary = '#7367F0';
        var $warning = '#FF9F43';
        var $danger = '#EA5455';
        var $success = '#00db89';
        var $info = '#00cfe8';
        var $color1 = '#a9b400';
        var $color2 = '#ae5a79';
        var $color3 = '#e7eef7';
        var $primary_light = '#9c8cfc';
        var $warning_light = '#FFC085';
        var $danger_light = '#f29292';
        var $strok_color = '#b9c3cd';
        var $white = '#fff';


        var total_label = [];
        var total_series = [];
        var totalClustersList = $('.totalClustersList li');
        $.each(totalClustersList, function (i, v) {
            total_label.push($(v).find('.total_name').text());
            total_series.push(parseInt($(v).find('.total_val').text()));
        });
        /*var customerChartoptions = {
            chart: {
                height: 325,
                type: 'pie',
                dropShadow: {
                    enabled: false,
                    blur: 5,
                    left: 1,
                    top: 1,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                pie: {
                    size: 120,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                },
            },
            labels: total_label,
            series: total_series,
            /!*labels: ['Khyber Paktunkhwa', 'Punjab', 'Sindh', 'Balochistan', 'Adjacent Areas-FR'],
            series: [4, 3, 25, 8, 3],*!/
            dataLabels: {
                enabled: false
            },
            legend: {show: false},
            stroke: {
                width: 1
            },
            colors: [$primary, $warning, $danger, $success, $info, $color1, $color2, $color3],
            fill: {
                type: 'gradient',
                gradient: {
                    gradientToColors: [$primary_light, $warning_light, $danger_light]
                }
            }
        };*/
        var customerChartoptions = {
            chart: {
                height: 250,
                type: 'radialBar',
                sparkline: {
                    enabled: true,
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                },
            },
            plotOptions: {
                radialBar: {
                    size: 110,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $strok_color,
                        strokeWidth: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 18,
                            color: $strok_color,
                            fontSize: '4rem'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#00b5b5'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                lineCap: 'round'
            },
            colors: [$danger],
            series: [parseInt(100).toFixed()],
            labels: ['Total Clusters'],
        };
        var customerChart = new ApexCharts(
            document.querySelector("#total_linelisting"),
            customerChartoptions
        );
        customerChart.render();

        // Completed Chart -----------------------------

        var comp_percentage = $('#comp_percentage').val();
        if (comp_percentage == '' || comp_percentage == undefined) {
            comp_percentage = 0;
        }

        var supportChartoptions = {
            chart: {
                height: 250,
                type: 'radialBar',
                sparkline: {
                    enabled: true,
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                },
            },
            plotOptions: {
                radialBar: {
                    size: 110,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $strok_color,
                        strokeWidth: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 18,
                            color: $strok_color,
                            fontSize: '4rem'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#00b5b5'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                lineCap: 'round'
            },
            colors: [$danger],
            series: [parseInt(comp_percentage).toFixed()],
            labels: ['Completed Clusters'],
        };
        var supportChart = new ApexCharts(
            document.querySelector("#completed-chart"),
            supportChartoptions
        );
        supportChart.render();

        // InProgress Chart -----------------------------
        var ip_percentage = $('#ip_percentage').val();
        if (ip_percentage == '' || ip_percentage == undefined) {
            ip_percentage = 0;
        }
        var goalChartoptions = {
            chart: {
                height: 250,
                type: 'radialBar',
                sparkline: {
                    enabled: true,
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                },
            },
            plotOptions: {
                radialBar: {
                    size: 110,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $strok_color,
                        strokeWidth: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 18,
                            color: $strok_color,
                            fontSize: '4rem'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#00b5b5'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                lineCap: 'round'
            },
            colors: [$success],
            series: [parseInt(ip_percentage).toFixed()],
            labels: ['InProgress Clusters'],
        };
        var goalChart = new ApexCharts(
            document.querySelector("#inprogress-chart"),
            goalChartoptions
        );
        goalChart.render();

        // Remaining Chart -----------------------------
        var r_percentage = $('#r_percentage').val();
        if (r_percentage == '' || r_percentage == undefined) {
            r_percentage = 0;
        }
        var remainingChartoptions = {
            chart: {
                height: 250,
                type: 'radialBar',
                sparkline: {
                    enabled: true,
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                },
            },
            plotOptions: {
                radialBar: {
                    size: 110,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $strok_color,
                        strokeWidth: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 18,
                            color: $strok_color,
                            fontSize: '4rem'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#00b5b5'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                lineCap: 'round'
            },
            colors: [$primary],
            labels: ['Remaining Clusters'],
            series: [parseInt(r_percentage).toFixed()]
        };
        var remainingChart = new ApexCharts(
            document.querySelector("#remaining-chart"),
            remainingChartoptions
        );
        remainingChart.render();


    });
</script>