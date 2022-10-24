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
                        <h2 class="content-header-title float-left mb-0">Camp Status Progress</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Camp Status</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Analytics card section start -->
            <section id="analytics-card">
                <?php $colors = array('primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                    'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                    'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3',
                    'primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                    'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                    'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3');
                ?>
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">Total Planned Camps</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0"><?php
                                                if (isset($graphdata['total']) && $graphdata['total'] != '') {
                                                    $totalCamps = $graphdata['total'];
                                                } else {
                                                    $totalCamps = 0;
                                                }
                                                echo $totalCamps;
                                                ?></h1>
                                            <small>Camps</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="total_camps" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body total_Camps">
                                    <?php if (isset($graphdata['list']) && $graphdata['list'] != '') {
                                        $t = 0;
                                        foreach ($graphdata['list']['Total'] as $k => $t_list) {

                                            ?>
                                            <a
                                                href="<?php echo base_url('index.php/Camp_CM/Camp?s=t&d=' . substr($t_list['ucCode'], 0, 3) . '&u=' . $t_list['ucCode'] . '&a=0') ?>"
                                                target="_blank">
                                                <div class="d-flex justify-content-between mb-25">
                                                    <div class="browser-info">
                                                        <p class="mb-25"><?php echo ucfirst($t_list['ucName']); ?></p>
                                                    </div>
                                                    <div class="stastics-info text-right">
                                                        <span><?php echo $t_list['camps']; ?></span>
                                                    </div>

                                                </div>
                                                <div class="progress progress-bar-<?php echo $colors[$t] ?> mb-2">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="<?php echo $t_list['camps']; ?>"
                                                         aria-valuemin="100" aria-valuemax="100"
                                                         style="width:100%"></div>
                                                </div>
                                            </a>
                                            <?php $t++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">Conducted Camps</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <?php
                                            if (isset($graphdata['Conducted']) && $graphdata['Conducted'] != '') {
                                                $Conducted = $graphdata['Conducted'];
                                            } else {
                                                $Conducted = 0;
                                            }

                                            $perc_Conducted = ($Conducted / $totalCamps) * 100;
                                            echo '<input type="hidden" autocomplete="conducted_percentage_off" id="conducted_percentage" value="' . $perc_Conducted . '">'; ?>
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                <?php echo $Conducted; ?>
                                            </h1>
                                            <small>Camps</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="conducted-chart" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body conducted_Camps">
                                    <?php
                                    if (isset($graphdata['list']['Conducted']) && $graphdata['list']['Conducted'] != '') {
                                        $cond_s = 0;
                                        foreach ($graphdata['list']['Conducted'] as $cond_k => $cond_list) {
                                            $con_t = 0;
                                            foreach ($graphdata['list']['Total'] as $tkeys => $dis) {
                                                if ($tkeys == $cond_list['ucCode']) {
                                                    $con_t = $dis['camps'];
                                                }
                                            }
                                            $cond_perc = ($cond_list['camps'] / $con_t) * 100;
                                            $cond_perc = number_format($cond_perc, 2);
                                            ?>
                                            <a
                                                href="<?php echo base_url('index.php/Camp_CM/Camp?s=c&d=' . substr($cond_list['ucCode'], 0, 3) . '&u=' . $cond_list['ucCode'] . '&a=0') ?>"
                                                target="_blank">
                                                <div class="d-flex justify-content-between mb-25">
                                                    <div class="browser-info">
                                                        <p class="mb-25"><?php echo ucfirst($cond_list['ucName']); ?></p>
                                                    </div>
                                                    <div class="stastics-info text-right">
                                                        <span><?php echo $cond_list['camps']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="progress progress-bar-<?php echo $colors[$cond_s] ?> mb-2">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="<?php echo $cond_perc; ?>"
                                                         aria-valuemin="<?php echo $cond_perc; ?>" aria-valuemax="100"
                                                         style="width:<?php echo $cond_perc; ?>%"></div>
                                                </div>
                                            </a>
                                            <?php $cond_s++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-end">
                                <h4 class="card-title">Remaining Camps</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body py-0">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <?php
                                            if (isset($graphdata['Remaining']) && $graphdata['Remaining'] != '') {
                                                $Remaining = $graphdata['Remaining'];
                                            } else {
                                                $Remaining = 0;
                                            }

                                            $perc_completed = ($Remaining / $totalCamps) * 100;
                                            echo '<input type="hidden" autocomplete="planned_percentage_off" id="planned_percentage" value="' . $perc_completed . '">'; ?>
                                            <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                <?php echo $Remaining ?>
                                            </h1>
                                            <small>Camps</small>
                                        </div>
                                        <div class="col-sm-12 col-12 d-flex justify-content-center">
                                            <div id="planned-chart" class="mt-75"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body planned_Camps">
                                    <?php if (isset($graphdata['list']['Remaining']) && $graphdata['list']['Remaining'] != '') {
                                        $p = 0;
                                        foreach ($graphdata['list']['Remaining'] as $p_k => $p_list) {
                                            $t = 0;
                                            foreach ($graphdata['list']['Total'] as $tkeys => $dis) {
                                                if ($tkeys == $p_list['ucCode']) {
                                                    $t = $dis['camps'];
                                                }
                                            }
                                            $perc = ($p_list['camps'] / $t) * 100;

                                            ?>
                                            <a
                                                href="<?php echo base_url('index.php/Camp_CM/Camp?s=r&d=' . substr($p_list['ucCode'], 0, 3) . '&u=' . $p_list['ucCode'] . '&a=0') ?>"
                                                target="_blank">
                                                <div class="d-flex justify-content-between mb-25">
                                                    <div class="browser-info">
                                                        <p class="mb-25"><?php echo ucfirst($p_list['ucName']); ?></p>
                                                    </div>
                                                    <div class="stastics-info text-right">
                                                        <span><?php echo $p_list['camps']; ?></span>
                                                    </div>

                                                </div>
                                                <div class="progress progress-bar-<?php echo $colors[$p] ?> mb-2">
                                                    <div class="progress-bar" role="progressbar"
                                                         aria-valuenow="<?php echo $perc; ?>"
                                                         aria-valuemin="<?php echo $perc; ?>" aria-valuemax="100"
                                                         style="width:<?php echo $perc; ?>%"></div>
                                                </div>
                                            </a>
                                            <?php $p++;
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Analytics Card section end-->

            <section id="dashboard-analytics">
                <div class="row match-height">
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex justify-content-between pb-0">
                                    <h4>Visitors</h4>
                                </div>

                                <div class="card-body">
                                    <?php
                                    if (isset($totalVisitors['Overall']) && $totalVisitors['Overall'] != '') {
                                        $toOverall = $totalVisitors['Overall'];
                                    } else {
                                        $toOverall = 0;
                                    }
                                    ?>
                                    <p class="mb-0 line-ellipsis text-center">Overall</p>
                                    <h1 class="text-bold-700 text-center"><?php echo $toOverall; ?></h1>
                                    <?php
                                    if (isset($totalVisitors) && $totalVisitors != '') {
                                        foreach ($totalVisitors as $vKey => $totlV) {
                                            if (isset($totlV['totalVisitors']) && $totlV['totalVisitors'] != '') {
                                                $toV = $totlV['totalVisitors'];
                                                $toP = ($totlV['totalVisitors'] / $toOverall) * 100;
                                            } else {
                                                $toV = 0;
                                                $toP = 0;
                                            }
                                            if ($vKey != 'Overall') {
                                                ?>
                                                <div class="chart-info d-flex justify-content-between mb-1 totalVisitorsDiv">
                                                    <div class="series-info d-flex align-items-center">
                                                        <a href="<?php echo base_url('index.php/Camp_CM/Camp_status/status_visitors?t=totalvisitors&uc=' . $totlV['ucCode'] . ' ') ?>"
                                                           target="_blank">
                                                            <i class="fa fa-circle-o text-bold-700 text-<?php echo $colors[$vi] ?>"></i>
                                                            <span class="text-bold-600 ml-50 visi_name"><?php echo(isset($vKey) && $vKey != '' ? $vKey : 0) ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="product-result">
                                                    <span class="visi_val" data-per="<?php echo $toP ?>">
                                                        <?php echo $toV ?>
                                                    </span>
                                                    </div>
                                                </div>

                                                <?php $vi++;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex justify-content-between pb-0">
                                    <h4>Children</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($totalChildren['Overall']) && $totalChildren['Overall'] != '') {
                                        $toIOverall = $totalChildren['Overall'];
                                    } else {
                                        $toIOverall = 0;
                                    }
                                    ?>
                                    <p class="mb-0 line-ellipsis text-center">Overall</p>
                                    <h1 class="text-bold-700 text-center"><?php echo $toIOverall; ?></h1>
                                    <?php
                                    if (isset($totalChildren) && $totalChildren != '') {
                                        $vii = 0;
                                        foreach ($totalChildren as $iKey => $totlI) {
                                            if ($iKey != 'Overall') { ?>
                                                <div class="chart-info d-flex justify-content-between mb-1 totalImmunizationDiv">
                                                    <div class="series-info d-flex align-items-center">
                                                        <a href="<?php echo base_url('index.php/Camp_CM/Camp_status/status_children?t=c&uc=' . (isset($totlI['ucCode']) && $totlI['ucCode'] != '' ? $totlI['ucCode'] : '0') . ' ') ?>"
                                                           target="_blank">
                                                            <i class="fa fa-circle-o text-bold-700 text-<?php echo $colors[$vii] ?>"></i>
                                                            <span class="text-bold-600 ml-50 immi_name"><?php echo(isset($totlI['ucName']) && $totlI['ucName'] != '' ? $totlI['ucName'] : $iKey) ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="product-result">
                                                    <span class="wra_val">
                                                        <?php echo(isset($totlI['totalVisitors']) && $totlI['totalVisitors'] != '' ? $totlI['totalVisitors'] : 0) ?>
                                                    </span>
                                                    </div>
                                                </div>
                                                <?php $vii++;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex justify-content-between pb-0">
                                    <h4>WRA</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($totalWRA['Overall']) && $totalWRA['Overall'] != '') {
                                        $to_wra_Overall = $totalWRA['Overall'];
                                    } else {
                                        $to_wra_Overall = 0;
                                    }
                                    ?>
                                    <p class="mb-0 line-ellipsis text-center">Overall</p>
                                    <h1 class="text-bold-700 text-center"><?php echo $to_wra_Overall; ?></h1>
                                    <?php
                                    if (isset($totalWRA) && $totalWRA != '') {
                                        $wra = 0;
                                        foreach ($totalWRA as $wra_Key => $totl_wra) {
                                            if ($wra_Key != 'Overall') {
                                                ?>
                                                <div class="chart-info d-flex justify-content-between mb-1 totalWRADiv">
                                                    <div class="series-info d-flex align-items-center">
                                                        <a href="<?php echo base_url('index.php/Camp_CM/Camp_status/status_wra?t=wra&uc=' . (isset($totl_wra['ucCode']) && $totl_wra['ucCode'] != '' ? $totl_wra['ucCode'] : '301') . ' ') ?>"
                                                           target="_blank">
                                                            <i class="fa fa-circle-o text-bold-700 text-<?php echo $colors[$wra] ?>"></i>
                                                            <span class="text-bold-600 ml-50 wra_name"><?php echo(isset($totl_wra['ucName']) && $totl_wra['ucName'] != '' ? $totl_wra['ucName'] : $wra_Key) ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="product-result">
                                                    <span class="wra_val">
                                                        <?php echo(isset($totl_wra['totalVisitors']) && $totl_wra['totalVisitors'] != '' ? $totl_wra['totalVisitors'] : 0) ?>
                                                    </span>
                                                    </div>
                                                </div>
                                                <?php $wra++;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex justify-content-between  pb-0">
                                    <h4>Others</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($totalother['Overall']) && $totalother['Overall'] != '') {
                                        $to_other_Overall = $totalother['Overall'];
                                    } else {
                                        $to_other_Overall = 0;
                                    }
                                    ?>
                                    <p class="mb-0 line-ellipsis text-center">Overall</p>
                                    <h1 class="text-bold-700  text-center"><?php echo $to_other_Overall; ?></h1>
                                    <?php
                                    if (isset($totalother) && $totalother != '') {
                                        $other = 0;
                                        foreach ($totalother as $other_Key => $totl_other) {
                                            if ($other_Key != 'Overall') {
                                                ?>
                                                <div class="chart-info d-flex justify-content-between mb-1 totalotherDiv">
                                                    <div class="series-info d-flex align-items-center">
                                                        <a href="javascript:void(0)" >
                                                            <i class="fa fa-circle-o text-bold-700 text-<?php echo $colors[$other] ?>"></i>
                                                            <span class="text-bold-600 ml-50 other_name"><?php echo(isset($totl_other['ucName']) && $totl_other['ucName'] != '' ? $totl_other['ucName'] : $other_Key) ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="product-result">
                                                    <span class="other_val">
                                                        <?php echo(isset($totl_other['totalVisitors']) && $totl_other['totalVisitors'] != '' ? $totl_other['totalVisitors'] : 0) ?>
                                                    </span>
                                                    </div>
                                                </div>
                                                <?php $other++;
                                            }
                                        }
                                    }
                                    ?>
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

<!-- END: Page JS-->

<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>
<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/charts/chart-apex.js"></script>-->

<script>
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
        var totalCampsList = $('.totalCampsList li');
        $.each(totalCampsList, function (i, v) {
            total_label.push($(v).find('.total_name').text());
            total_series.push(parseInt($(v).find('.total_val').text()));
        });
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
            labels: ['Total Camps'],
        };
        var customerChart = new ApexCharts(
            document.querySelector("#total_camps"),
            customerChartoptions
        );
        customerChart.render();

        // Planned Chart -----------------------------

        var planned_percentage = $('#planned_percentage').val();
        if (planned_percentage == '' || planned_percentage == undefined) {
            planned_percentage = 0;
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
            series: [parseInt(planned_percentage).toFixed()],
            labels: ['Completed Camps'],
        };
        var supportChart = new ApexCharts(
            document.querySelector("#planned-chart"),
            supportChartoptions
        );
        supportChart.render();

        // conducted Chart -----------------------------
        var conducted_percentage = $('#conducted_percentage').val();
        if (conducted_percentage == '' || conducted_percentage == undefined) {
            conducted_percentage = 0;
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
            series: [parseInt(conducted_percentage).toFixed()],
            labels: ['Conducted Camps'],
        };
        var goalChart = new ApexCharts(
            document.querySelector("#conducted-chart"),
            goalChartoptions
        );
        goalChart.render();

        // Canceled Chart -----------------------------
        var canceled_percentage = $('#canceled_percentage').val();
        if (canceled_percentage == '' || canceled_percentage == undefined) {
            canceled_percentage = 0;
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
            labels: ['Canceled Camps'],
            series: [parseInt(canceled_percentage).toFixed()]
        };
        var remainingChart = new ApexCharts(
            document.querySelector("#canceled-chart"),
            remainingChartoptions
        );
        remainingChart.render();


    });
</script>