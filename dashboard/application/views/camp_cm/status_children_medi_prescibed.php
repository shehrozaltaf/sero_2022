<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/card-analytics.css">
<style>
    .table th, .table td {
        padding: 2px !important;
    }
</style>
<?php

if (!isset($slug_ucs) || $slug_ucs == '') {
    $slug_ucs = '';
} ?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Children Medicine Prescibed Status</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Medicine Prescibed Status</li>
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
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select"
                                                        id="district_select"
                                                        onchange="changeDistrict('district_select','ucs_select',1)">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($district) && $district != '') {
                                                        foreach ($district as $k => $d) {
                                                            echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                UC
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select"
                                                        onchange="changeUC('ucs_select','area_select',1)">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Area
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control area_select" id="area_select">
                                                    <option value="0" readonly disabled selected>Area</option>
                                                </select>
                                            </div>
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
            </section>
            <?php if (isset($slug_district) && $slug_district != '' && $slug_district != 0) {

                if (isset($totalChildren[0]->totalVisitors) && $totalChildren[0]->totalVisitors != '') {
                    $totalChildren_cnt = $totalChildren[0]->totalVisitors;
                } else {
                    $totalChildren_cnt = 0;
                }
                echo '<input type="hidden" id="one_hidden" value="' . $totalChildren . '">';

                if (isset($medi_prescibed[0]->totalCnt) && $medi_prescibed[0]->totalCnt != '') {
                    $medi_prescibed_cnt = $medi_prescibed[0]->totalCnt;
                } else {
                    $medi_prescibed_cnt = 0;
                }
                echo '<input type="hidden" id="two_hidden" value="' . $medi_prescibed_cnt . '">';

                ?>
                <section id="statistics-card">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <div class="card text-white bg-gradient-success text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h2 class="card-title text-white"><?php echo $totalChildren_cnt; ?></h2>
                                        <p class="card-text">Total Children</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6">
                            <div class="card text-white bg-gradient-danger text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <a href="<?php echo base_url('index.php/Camp_CM/Camp_status/status_children_medi_prescibed?uc=' . $slug_ucs) ?>"
                                           target="_blank">
                                            <h2 class="card-title text-white"><?php echo $medi_prescibed_cnt; ?></h2>
                                            <p class="card-text">Medicine Prescribed</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>

            <?php if (isset($medi_prescibed_data) && $medi_prescibed_data != '' && $medi_prescibed_data != 0) {
                $medi_prescibed_array = array();
                foreach ($medi_prescibed_data[0] as $cd_key => $cd_val) {
                    $medi_prescibed_array[$cd_key] = $cd_val;
                }
                arsort($medi_prescibed_array);
                foreach ($medi_prescibed_array as $cd_key => $cd_val) {
                    echo '<input type="hidden" class="child_medi_prescibed" name="child_medi_prescibed' . $cd_key . '" id="child_medi_prescibed' . $cd_key . '" 
                    data-label="' . (str_replace('_', ' ', $cd_key)) . '" value="' . $cd_val . '">';
                }
            } ?>

            <!-- apex charts section start -->
            <section id="apexchart">
                <div class="row">
                    <!-- Bar Chart -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Medicine Prescribed</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div id="bar-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Apex charts section end -->

            <?php if (isset($slug_ucs) && $slug_ucs != '' && $slug_ucs != 0) { ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Camp Children Medicine Presribed Summary</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th width="10%">Camp</th>
                                                    <th width="5%">Area</th>
                                                    <th width="5%">Children under 5</th>
                                                    <th width="5%">Paracetamol</th>
                                                    <th width="5%">Metronidazole</th>
                                                    <th width="5%">Aminophylline Plus Compound</th>
                                                    <th width="5%">Amoxicillin</th>
                                                    <th width="5%">Cetirizine</th>
                                                    <th width="5%">Nonsteroidal Anti-Inflammatory Drug</th>
                                                    <th width="5%">Antiemetic</th>
                                                    <th width="5%">Antimalarial</th>
                                                    <th width="5%">Deworming</th>
                                                    <th width="5%">ORS</th>
                                                    <th width="5%">Folic_Acid</th>
                                                    <th width="5%">Zinc</th>
                                                    <th width="5%">Multivitamin</th>
                                                    <th width="5%">Calcium</th>
                                                    <th width="5%">Iron</th>
                                                    <th width="5%">Other</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) {
                                                        ?>
                                                        <tr>
                                                            <td  width="10%"><?php echo $r->camp_no ?></td>
                                                            <td><?php echo $r->area_name ?></td>
                                                            <td><?php echo $r->u5 ?></td>
                                                            <td><?php echo $r->Paracetamol ?></td>
                                                            <td><?php echo $r->Metronidazole ?></td>
                                                            <td><?php echo $r->Aminophylline_Plus_Compound ?></td>
                                                            <td><?php echo $r->Amoxicillin ?></td>
                                                            <td><?php echo $r->Cetirizine ?></td>
                                                            <td><?php echo $r->Nonsteroidal_Anti_Inflammatory_Drug ?></td>
                                                            <td><?php echo $r->Antiemetic ?></td>
                                                            <td><?php echo $r->Antimalarial ?></td>
                                                            <td><?php echo $r->Deworming ?></td>
                                                            <td><?php echo $r->ORS ?></td>
                                                            <td><?php echo $r->Folic_Acid ?></td>
                                                            <td><?php echo $r->Zinc ?></td>
                                                            <td><?php echo $r->Multivitamin ?></td>
                                                            <td><?php echo $r->Calcium ?></td>
                                                            <td><?php echo $r->Iron ?></td>
                                                            <td><?php echo $r->Other ?></td>
                                                        </tr>
                                                    <?php }
                                                } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Camp</th>
                                                    <th>Area</th>
                                                    <th>Children under 5</th>
                                                    <th>Paracetamol</th>
                                                    <th>Metronidazole</th>
                                                    <th>Aminophylline Plus Compound</th>
                                                    <th>Amoxicillin</th>
                                                    <th>Cetirizine</th>
                                                    <th>Nonsteroidal Anti-Inflammatory Drug</th>
                                                    <th>Antiemetic</th>
                                                    <th>Antimalarial</th>
                                                    <th>Deworming</th>
                                                    <th>ORS</th>
                                                    <th>Folic_Acid</th>
                                                    <th>Zinc</th>
                                                    <th>Multivitamin</th>
                                                    <th>Calcium</th>
                                                    <th>Iron</th>
                                                    <th>Other</th>
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

<input type="hidden" id="hidden_slug_ucs"
       value="<?php echo $slug_ucs; ?>">
<input type="hidden" id="hidden_slug_area"
       value="<?php echo(isset($slug_area) && $slug_area != '' ? $slug_area : ''); ?>">
<!-- Modal -->
<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/charts/apexcharts.min.js"></script>
<script>
    $(document).ready(function () {
        changeDistrict('district_select', 'ucs_select', 1);

        // ----------------------------------
        var $primary = '#7367F0',
            $success = '#28C76F',
            $danger = '#EA5455',
            $warning = '#FF9F43',
            $info = '#00cfe8',
            $label_color_light = '#dae1e7';

        var themeColors = [$primary, $success, $danger, $warning, $info];

        var mydata = [];
        var mylabel = [];
        var child_medi_prescibed = $('.child_medi_prescibed');
        $.each(child_medi_prescibed, function (i, v) {
            mydata.push($(this).val());
            mylabel.push($(this).attr('data-label'));
        });
        var barChartOptions = {
            chart: {
                height: 350,
                type: 'bar',
            },
            colors: themeColors,
            plotOptions: {
                bar: {
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: true
            },
            series: [{
                name: 'Medicine Prescribed',
                data: mydata
            }],
            xaxis: {
                labels: {
                    rotate: -45
                },
                categories: mylabel
            },
            yaxis: {
                title: {
                    text: 'Medicine Prescribed (For Under Five years)',
                },
            }
        };
        var barChart = new ApexCharts(
            document.querySelector("#bar-chart"),
            barChartOptions
        );
        barChart.render();
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
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


    function changeUC(uc, area, filter) {
        var data = {};
        data['uc'] = $('#' + uc).val();
        data['filter'] = 1;
        if (data['uc'] != '' && data['uc'] != undefined && data['uc'] != '0' && data['uc'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Camp_CM/Camp/getAreaByUCs'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly="">Area</option>';
                if (filter == 1) {
                    items = '<option value="0">Select Area</option>';
                }
                var areas = $('#hidden_slug_area').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.mh02 + '"  ' + (areas == v.mh02 || response.length == 1 ? 'selected' : '') + '>' + v.area_name + ' (' + v.mh02 + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + area).html('').html(items);

            });
        } else {
            $('#' + area).html('');
        }
    }

    function changeDistrict(dist, uc, filter) {
        $('#' + uc).html('');
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly>Select UC</option>';
                var dist = $('#hidden_slug_ucs').val();

                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ucCode + '"  ' + (dist == v.ucCode || response.length == 1 ? 'selected' : '') + '>' + v.ucName + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + uc).html('').html(items);
                changeUC('ucs_select', 'area_select', 1);
            });
        } else {
            $('#' + uc).html('');
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var area = $('.area_select').val();
        if (district == '' || district == undefined || district == '0' || district == '$1') {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            if (ucs == '' || ucs == undefined || ucs == '0' || ucs == '$1') {
                toastMsg('UC', 'Invalid UCs', 'error');
            } else {
                if (area == '' || area == undefined || area == '0' || area == '$1') {
                    area = '0';
                }
                window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Camp_status/status_children_medi_prescibed?t=c&uc=' + ucs + '&a=' + area;
            }


        }
    }

</script>