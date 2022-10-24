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
                                                        onchange="changeProvince()">
                                                    <option value="0" readonly disabled selected>Province</option>
                                                    <?php if (isset($province) && $province != '') {
                                                        foreach ($province as $k => $p) {
                                                            echo '<option value="' . $k . '" ' . (isset($slug_province) && $slug_province == $k ? "selected" : "") . '>' . $p . '</option>';
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


                                    </div>
                                    <div class=" ">
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
            if (isset($_REQUEST['d']) && $_REQUEST['d'] != '') {
                $d = $_REQUEST['d'];
            } else {
                $d = 0;
            }
            echo '<input type="hidden" id="dist_hidden" value="' . $d . '">';


            if (isset($getData) && $getData != '') {
                if (!isset($total) || $total == '') {
                    $total = 0;
                }
                echo '<input type="hidden" id="t_hidden" value="' . $total . '">';

                if (!isset($scored) || $scored == '') {
                    $scored = 0;
                }
                echo '<input type="hidden" id="s_hidden" value="' . $scored . '">';

                if (!isset($errored) || $errored == '') {
                    $errored = 0;
                }
                echo '<input type="hidden" id="e_hidden" value="' . $errored . '">';

                if (!isset($edited) || $edited == '') {
                    $edited = 0;
                }
                echo '<input type="hidden" id="edited_hidden" value="' . $edited . '">';
                ?>
                <section id="statistics-card">
                    <div class="row">
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0"><?php echo $total; ?></h2>
                                        <p>Total</p>
                                    </div>
                                    <div class="avatar bg-rgba-success p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-list text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0"><?php echo $scored; ?></h2>
                                        <p>Number of Cards Reviewed</p>
                                    </div>
                                    <div class="avatar bg-rgba-info p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-file-text text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0"><?php echo $errored; ?></h2>
                                        <p>Number of Cards with errors</p>
                                    </div>
                                    <div class="avatar bg-rgba-danger p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-file-text text-danger font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0"><?php echo $edited; ?></h2>
                                        <p>Number of Cards edited</p>
                                    </div>
                                    <div class="avatar bg-rgba-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-file-text text-warning font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="analytics-card">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Status</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="chart" class="mx-auto"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="component-swiper-gallery">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Cluster wise Card Review Summary</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors data_list">
                                                <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Cluster</th>
                                                    <th>Total</th>
                                                    <th>Reviewed</th>
                                                    <th>Error</th>
                                                    <th>Edited</th>
                                                    <th>Reviewed Progress</th>
                                                    <th>Reviewed Percentage</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $colors = array('primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                                                    'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                                                    'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3',
                                                    'primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                                                    'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                                                    'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3');
                                                if (isset($getData) && $getData != '') {
                                                    $SNo = 1;
                                                    $s = 0;
                                                    foreach ($getData as $kk => $vv) {
                                                        if(isset($vv['totalClusters']) && $vv['totalClusters']!=''){
                                                          $totC=  $vv['totalClusters'];
                                                        }else{
                                                            $totC=100;
                                                        }
                                                        $percent = ($vv['scoredClusters'] / $totC) * 100;
                                                        echo '<tr>
                                                            <td>' . $SNo++ . '</td>
                                                            <td>' . $kk . '</td>
                                                            <td>' . $vv['totalClusters'] . '</td>
                                                            <td>' . $vv['scoredClusters'] . '</td>
                                                            <td>' . $vv['errorClusters'] . '</td>
                                                            <td>' . $vv['editedClusters'] . '</td>
                                                           
                                                            <td>
                                                                <div class="progress progress-bar-' . $colors[$s] . '">
                                                                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $vv['scoredClusters'] . '" aria-valuemin="' . $vv['scoredClusters'] . '" aria-valuemax="' . $vv['totalClusters'] . '" style="width:' . number_format($percent, 0) . '%"></div>
                                                                </div>
                                                            </td>
                                                             <td>' . number_format($percent, 2) . '%</td>
                                                          </tr>';
                                                        $s++;
                                                    }
                                                } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Cluster</th>
                                                    <th>Total</th>
                                                    <th>Reviewed</th>
                                                    <th>Error</th>
                                                    <th>Edited</th>
                                                    <th>Reviewed Progress</th>
                                                    <th>Reviewed Percentage</th>
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
            <!-- Analytics Card section end-->


        </div>
    </div>
</div>
<!-- END: Content-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>

<script>


    $(document).ready(function () {
        changeProvince();
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

        var t_hidden = $('#t_hidden').val();
        if (t_hidden == '' || t_hidden == undefined) {
            t_hidden = 0
        }

        var s_hidden = $('#s_hidden').val();
        if (s_hidden == '' || s_hidden == undefined) {
            s_hidden = 0
        }

        var e_hidden = $('#e_hidden').val();
        if (e_hidden == '' || e_hidden == undefined) {
            e_hidden = 0
        }

        var edited_hidden = $('#edited_hidden').val();
        if (edited_hidden == '' || edited_hidden == undefined) {
            edited_hidden = 0
        }

        var themeColors = [$success, $info, $danger, $warning, $color1, $color2, $color3, $primary];
        var options = {
            series: [{
                data: [parseInt(t_hidden), parseInt(s_hidden), parseInt(e_hidden), parseInt(edited_hidden)]
            }],
            chart: {
                type: 'bar',
                height: 380
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: themeColors,
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#000']
                },
                formatter: function (val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                },
                offsetX: 0
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: ['Total Cards', 'Reviewed Cards', 'Cards identified with errors', 'Cards edited'],
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Image Status',
                align: 'center',
                floating: true
            },
            tooltip: {
                theme: 'dark',
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function () {
                            return ''
                        }
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


    });

    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();

        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var dist_hidden = $('#dist_hidden').val();
                var items = '<option value="0"   readonly disabled ' + (dist_hidden == 0 ? 'selected' : '') + '>District</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response[0], function (i, v) {
                            items += '<option value="' + i + '" ' + (dist_hidden == i ? 'selected' : '') + '>' + v + '</option>';
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
        var district = $('.district_select ').val();
        if (district == '' || district == undefined || district == '0') {
            district = 0;
        }
        if (province == '' || province == undefined || province == '0') {
            $('.province_select').css('border', '1px solid red');
            toastMsg('Province', 'Invalid Province', 'error');
            return false;
        } else {
            window.location.href = '<?php echo base_url() ?>index.php/card_image_status?p=' + province + '&d=' + district;
        }

    }


</script>