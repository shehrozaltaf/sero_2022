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
                        <h2 class="content-header-title float-left mb-0">Card Review Summary</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Card Review Summary</li>
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
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Province
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control province_select"
                                                        onchange="changeProvinces()">
                                                    <option value="0" readonly disabled selected>Province</option>
                                                    <?php if (isset($province) && $province != '') {
                                                        foreach ($province as $k => $p) {
                                                            echo '<option value="' . $p->pid . '" ' . (isset($slug_province) && $slug_province == $p->pid ? "selected" : "") . '>' . $p->province . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select">
                                                    <option value="0" readonly disabled selected>District</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div> <div class=" ">
                                        <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                            Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Analytics card section start -->
            <?php
            if (!isset($total) || $total == '') {
                $total = 0;
            }
            echo '<input type="hidden" id="t_hidden" value="' . $total . '">';

            if (!isset($getBcg) || $getBcg== '') {
                $getBcg = 0;
            }
            echo '<input type="hidden" id="bcg_hidden" value="' . $getBcg . '">';

            if (!isset($getpenta3) || $getpenta3 == '') {
                $getpenta3 = 0;
            }
            echo '<input type="hidden" id="penta3_hidden" value="' . $getpenta3 . '">';

            if (!isset($getCardAvailable) || $getCardAvailable == '') {
                $getCardAvailable = 0;
            }
            echo '<input type="hidden" id="card_hidden" value="' . $getCardAvailable . '">';
            ?>
            <section id="statistics-card">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?php echo $total; ?></h2>
                                    <p>Total</p>
                                </div>
                                <div class="avatar bg-rgba-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-list text-primary font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <section id="analytics-card">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Card Availability</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="card-chart" class="mx-auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">BCG Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="bcg-chart" class="mx-auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Penta-3 report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="penta3-chart" class="mx-auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?php echo $getCardAvailable; ?></h2>
                                    <p>Card Avaliable</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-file-text text-warning font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?php echo $getBcg; ?></h2>
                                    <p>BCG</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-file-text text-success font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?php echo $getpenta3; ?></h2>
                                    <p>Penta 3</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-file-text text-danger font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!-- Analytics Card section end-->

        </div>
    </div>
</div>
<!-- END: Content-->
<input type="hidden" id="hidden_slug_dist"
       value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>

<script>


    $(document).ready(function () {
        changeProvinces();
    });


    $(window).on("load", function () {
        var $primary = '#7367F0';
        var $warning = '#FF9F43';
        var $danger = '#EA5455';
        var $success = '#00db89';
        var $white = '#fff';

        var t_hidden = $('#t_hidden').val();
        if (t_hidden == '' || t_hidden == undefined) {
            t_hidden = 0
        }

        /*===========BCG===============*/
        var bcg_hidden = $('#bcg_hidden').val();
        if (bcg_hidden == '' || bcg_hidden == undefined) {
            bcg_hidden = 0
        }
        var bcg_percent = (bcg_hidden / t_hidden) * 100;

        var bcgChartOptions = {
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
            colors: [$success],
            plotOptions: {
                radialBar: {
                    size: 120,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $white,
                        strokeWidth: '100%',

                    },
                    dataLabels: {
                        value: {
                            offsetY: 30,
                            color: '#99a2ac',
                            fontSize: '2rem'
                        }
                    }
                },
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [$primary],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                dashArray: 8
            },
            series: [parseInt(bcg_percent).toFixed()],
            labels: ['BCG'],
        };
        var bcgChart = new ApexCharts(
            document.querySelector("#bcg-chart"),
            bcgChartOptions
        );
        bcgChart.render();

        /*===========PENTA 3===============*/
        var penta3_hidden = $('#penta3_hidden').val();
        if (penta3_hidden == '' || penta3_hidden == undefined) {
            penta3_hidden = 0
        }
        var penta3_percent = (penta3_hidden / t_hidden) * 100;
        var penta3ChartOptions = {
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
            colors: [$success],
            plotOptions: {
                radialBar: {
                    size: 120,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $white,
                        strokeWidth: '100%',

                    },
                    dataLabels: {
                        value: {
                            offsetY: 30,
                            color: '#99a2ac',
                            fontSize: '2rem'
                        }
                    }
                },
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [$danger],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                dashArray: 8
            },
            series: [parseInt(penta3_percent).toFixed()],
            labels: ['Penta-3'],
        };
        var penta3Chart = new ApexCharts(
            document.querySelector("#penta3-chart"),
            penta3ChartOptions
        );
        penta3Chart.render();

        /*===========Card===============*/
        var card_hidden = $('#card_hidden').val();
        if (card_hidden == '' || card_hidden == undefined) {
            card_hidden = 0
        }
        var card_percent = (card_hidden / t_hidden) * 100;
        var cardChartOptions = {
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
            colors: [$success],
            plotOptions: {
                radialBar: {
                    size: 120,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $white,
                        strokeWidth: '100%',

                    },
                    dataLabels: {
                        value: {
                            offsetY: 30,
                            color: '#99a2ac',
                            fontSize: '2rem'
                        }
                    }
                },
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [$warning],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            stroke: {
                dashArray: 8
            },
            series: [parseInt(card_percent).toFixed()],
            labels: ['Card Availability'],
        };
        var cardChart = new ApexCharts(
            document.querySelector("#card-chart"),
            cardChartOptions
        );
        cardChart.render();


    });

    function changeProvinces() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var dist = $('#hidden_slug_dist').val();
                var items = '<option value="0">Select All</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.dist_id + '" ' + (dist == v.dist_id ? 'selected' : '') + '>' + v.district + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.district_select').html('').html(items);
            });
        } else {
            $('.district_select').html('');
        }
    }


    function searchData() {
        var province = $('.province_select').val();
        var district = $('.district_select').val();
        if (province == '' || province == undefined || province == '0') {
            province = '';
        }
        if (district == '' || district == undefined || district == '0') {
            district = '';
        }
        window.location.href = '<?php echo base_url() ?>index.php/Vaccine_Indicators?p=' + province + '&d=' + district;
    }

</script>