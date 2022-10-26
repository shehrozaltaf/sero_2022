<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Sample Information</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Sample Information</li>
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
                                        <div class="col-sm-12 col-12">
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
                                        <div class="col-sm-12 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select"
                                                        onchange="changeDistrict()">
                                                    <option value="0" readonly disabled selected>District</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Cluster
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control cluster_select">
                                                    <option value="0" readonly disabled selected>Cluster</option>
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
            <input type="hidden" id="slug_province" name="slug_province"
                   value="<?php echo(isset($slug_province) && $slug_province != '' ? $slug_province : 0) ?>">
            <input type="hidden" id="slug_district" name="slug_district"
                   value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : 0) ?>">
            <input type="hidden" id="slug_cluster" name="slug_cluster"
                   value="<?php echo(isset($slug_cluster) && $slug_cluster != '' ? $slug_cluster : 0) ?>">

            <!-- Analytics card section start -->
            <?php if (isset($getData) && $getData != '') { ?>
                <section id="component-swiper-gallery">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Cluster Data</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors data_list">
                                                <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>province</th>
                                                    <th>district</th>
                                                    <th>ebCode</th>
                                                    <th>hh13</th>
                                                    <th>ec01</th>
                                                    <th>ec02</th>
                                                    <th>ec12</th>
                                                    <th>childname</th>
                                                    <th>g01</th>
                                                    <th>g04</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($getData) && $getData != '') {
                                                    $SNo = 1;
                                                    foreach ($getData as $kk => $vv) {
                                                        echo '<tr>
                                                            <td>' . $SNo++ . '</td>
                                                            <td>' . $vv->province . '</td>
                                                            <td>' . $vv->district . '</td>
                                                            <td>' . $vv->ebCode . '</td>
                                                            <td>' . $vv->hh13 . '</td>
                                                            <td>' . $vv->ec01 . '</td>
                                                            <td>' . $vv->ec02 . '</td>
                                                            <td>' . $vv->ec12 . '</td>
                                                            <td>' . $vv->childname . '</td>
                                                            <td>' . $vv->g01 . '</td>
                                                            <td>' . $vv->g04 . '</td>   
                                                            <td><a href="' . base_url('index.php/Sample_Information/addSample/' . $vv->ebCode) . '" target="_blank" class="btn btn-sm btn-success">Add Sample</a></td> 
                                                          </tr>';
                                                    }
                                                } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>province</th>
                                                    <th>district</th>
                                                    <th>ebCode</th>
                                                    <th>hh13</th>
                                                    <th>ec01</th>
                                                    <th>ec02</th>
                                                    <th>ec12</th>
                                                    <th>childname</th>
                                                    <th>g01</th>
                                                    <th>g04</th>
                                                    <th>Action</th>
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


    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Sample_Information/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var dist_hidden = $('#slug_district').val();
                var items = '<option value="0"   readonly disabled ' + (dist_hidden == 0 ? 'selected' : '') + '>District</option>';
                console.log(res);
                if (res != '') {
                    var response = JSON.parse(res);
                    console.log(response);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + i + '" ' + (dist_hidden == i ? 'selected' : '') + '>' + v + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.district_select').html('').html(items);
                setTimeout(function () {
                    changeDistrict();
                }, 2000);
            });
        } else {
            $('.district_select').html('');
        }
    }

    function changeDistrict() {
        var data = {};
        data['province'] = $('.province_select').val();
        data['district'] = $('.district_select').val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Sample_Information/getClusterByDistrict'  ?>', data, 'POST', function (res) {
                var cluster_hidden = $('#slug_cluster').val();
                var items = '<option value="0"   readonly disabled ' + (cluster_hidden == 0 ? 'selected' : '') + '>Cluster</option>';
                console.log(res);
                if (res != '') {
                    var response = JSON.parse(res);
                    console.log(response);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + i + '" ' + (cluster_hidden == i ? 'selected' : '') + '>' + v + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.cluster_select').html('').html(items);
            });
        } else {
            $('.cluster_select').html('');
        }
    }


    function searchData() {
        var province = $('.province_select').val();
        var district = $('.district_select ').val();
        var cluster = $('.cluster_select ').val();
        if (province == '' || province == undefined || province == '0') {
            province = 0;
            toastMsg('Province', 'Invalid Province', 'error');
            return false;
        }
        if (district == '' || district == undefined || district == '0') {
            district = 0;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }
        if (cluster == '' || cluster == undefined || cluster == '0') {
            $('.cluster_select').css('border', '1px solid red');
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        } else {
            window.location.href = '<?php echo base_url() ?>index.php/sample_information?p=' + province + '&d=' + district + '&c=' + cluster;
        }

    }


</script>