<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/extensions/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/extensions/swiper.css">

<style>
    .img-fluid {
        width: 100%;
    }

    .my-table-bordered tr, th, td, .my-table-bordered thead th {
        border: 1px solid black;
    }

    .child_name {
        text-transform: capitalize;
    }

    .clickmsg {
        margin: 0;
        font-size: 9px;
    }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Review Check</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Review Check</li>
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
                                                            echo '<option value="' . $k . '">' . $p . '</option>';
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
                                                <select class="select2 form-control district_select"
                                                        onchange="changeDists()">
                                                    <option value="0" readonly disabled selected>District</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Cluster
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control clusters_select"
                                                        onchange="changeClusters()">
                                                    <option value="0" readonly disabled selected>Cluster</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Household
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control household_select"
                                                        onchange="changeHHs()">
                                                    <option value="0" readonly disabled selected>Household</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Child Line No
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control childNo_select">
                                                    <option value="0" readonly disabled selected>Child No</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>  <div class=" ">
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

            <!-- gallery swiper start -->
            <section id="component-swiper-gallery" class="hide">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Images</h4>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="swiper-gallery swiper-container gallery-top">
                                            <div class="swiper-wrapper gallery_images">
                                            </div>
                                            <!-- Add Arrows -->
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                        <div class="swiper-container gallery-thumbs">
                                            <div class="swiper-wrapper mt-25 gallery_images">
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title data_head">Details:</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body ">
                                        <div class=" data_list ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- gallery swiper ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">
<input type="hidden" id="hidden_id" value="">

<script src="<?php echo base_url() ?>assets/vendors/js/extensions/swiper.min.js"></script>
<script>

    function gallery() {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            zoom: true,
            pagination: {
                el: '.swiper-pagination',
            },
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    }

    function changeProvinces() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Review_check/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var items = '<option value="0"   readonly disabled selected>District</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response[0], function (i, v) {
                            items += '<option value="' + i + '" onclick="changeDist()">' + v + '</option>';
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

    function changeDists() {
        var data = {};
        data['district'] = $('.district_select').val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Review_check/getClustersByDist'  ?>', data, 'POST', function (res) {
                var items = '<option value="0"   readonly disabled selected>Cluster</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.cluster_code + '" onclick="changeCluster()">' + v.cluster_code + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.clusters_select').html('').html(items);
            });
        } else {
            $('.clusters_select').html('');
        }
    }

    function changeClusters() {
        var data = {};
        data['cluster'] = $('.clusters_select').val();
        if (data['cluster'] != '' && data['cluster'] != undefined && data['cluster'] != '0' && data['cluster'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Review_check/getHhnoByCluster'  ?>', data, 'POST', function (res) {
                var items = '<option value="0"   readonly disabled selected>Household</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.hhno + '" onclick="changeHH()">' + v.hhno + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.household_select').html('').html(items);
            });
        } else {
            $('.household_select').html('');
        }
    }

    function changeHHs() {
        var data = {};
        data['cluster'] = $('.clusters_select').val();
        data['hh'] = $('.household_select').val();
        if (data['hh'] != '' && data['hh'] != undefined && data['hh'] != '0' && data['hh'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Review_check/getChildNoByHH'  ?>', data, 'POST', function (res) {
                var items = '<option value="0"   readonly disabled >Child No</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ec13 + '" selected>' + v.ec13 + '</option>';

                        })
                    } catch (e) {
                    }
                }
                $('.childNo_select').html('').html(items);
            });
        } else {
            $('.childNo_select').html('');
        }
    }

    function SubmitData() {
        var flag = 0;
        var data = {};
        data['image_status'] = $('#image_status').val();
        data['dobstatus'] = $('#dobstatus').val();
        data['cluster_no'] = $('.clusters_select').val();
        data['household'] = $('.household_select').val();
        data['comment_status'] = $('#comment_status').val();
        data['comment'] = $('#comment').val();
        if (data['comment_status'] == '' || data['comment_status'] == undefined || data['comment_status'] == '0') {
            $('#comment_status').css('border', '1px solid red');
            flag = 1;
            toastMsg('Comment Status', 'Invalid Comment Status', 'error');
            return false;
        }
        if (data['comment'] == '' || data['comment'] == undefined || data['comment'] == '0') {
            $('#comment').css('border', '1px solid red');
            flag = 1;
            toastMsg('Comment', 'Invalid Comment', 'error');
            return false;
        }

        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            $('.clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            return false;
        }
        if (data['household'] == '' || data['household'] == undefined || data['household'] == '0') {
            $('.household_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household', 'Invalid Household No', 'error');
            return false;
        }

        data['ec13'] = $('#ec13').val();
        data['f01'] = $('#f01').val();
        data['f02'] = $('#f02').val();
        data['child_ec14'] = $('.child_ec14').val();
        if (flag == 0) {
            $('.submitBtn').addClass('hide');
            showloader();
            CallAjax('<?php echo base_url('index.php/Review_check/submitData') ?>', data, 'POST', function (result) {
                hideloader();
                setTimeout(function () {
                    $('.submitBtn').removeClass('hide');
                }, 1000);
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#component-swiper-gallery').addClass('hide');
                    $('.gallery_images').html('');
                    $('.data_list').html('');
                } else if (result == 2) {
                    $('.clusters_select').css('border', '1px solid red');
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    $('.household_select').css('border', '1px solid red');
                    toastMsg('Error', 'Invalid Household No', 'error');
                } else if (result == 6) {
                    $('#comment_status').css('border', '1px solid red');
                    toastMsg('Comment Status', 'Invalid Comment Status', 'error');
                } else if (result == 7) {
                    $$('#comment').css('border', '1px solid red');
                    toastMsg('Comment', 'Invalid Comment', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            $('.clusters_select').css('border', '1px solid red');
            $('.household_select').css('border', '1px solid red');
            toastMsg('Error', 'Something went wrong', 'error');
        }
    }

    function searchData() {
        $('#component-swiper-gallery').addClass('hide');
        $('.submitBtn').addClass('hide');
        var hidden_loginUser = $('#hidden_loginUser').val();
        var submitBtn = '<button class="btn btn-primary submitBtn" onclick="SubmitData()">Submit</button>';
        $('.alreadyscored').text('');
        var flag = 0;
        var data = {};
        data['cluster_no'] = $('.clusters_select').val();
        data['household'] = $('.household_select').val();
        data['childNo'] = $('.childNo_select').val();
        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            $('.clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            return false;
        }
        if (data['household'] == '' || data['household'] == undefined || data['household'] == '0') {
            $('.household_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household', 'Invalid household No', 'error');
            return false;
        }
        if (data['childNo'] == '' || data['childNo'] == undefined || data['childNo'] == '0') {
            $('.childNo_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Child No', 'Invalid Child No', 'error');
            return false;
        }
        if (flag == 0) {
            CallAjax('<?php echo base_url('index.php/Review_check/getData') ?>', data, 'POST', function (res) {
                $('#component-swiper-gallery').removeClass('hide');
                $('.submitBtn').removeClass('hide');
                var items = '';
                var data_items = '';
                var gender = '';
                if (res != '' && res != undefined) {
                    var image_status_val = '';
                    var dob_s = '';
                    var dobstatus_val = '0';
                    var bcg0_val = '0';
                    var opv0_val = '0';
                    var opv1_val = '0';
                    var opv2_val = '0';
                    var opv3_val = '0';
                    var penta1_val = '0';
                    var penta2_val = '0';
                    var penta3_val = '0';
                    var pcv_val = '0';
                    var pcv2_val = '0';
                    var pcv3_val = '0';
                    var rv1_val = '0';
                    var rv2_val = '0';
                    var ipv_val = '0';
                    var measles1_val = '0';
                    var measles2_val = '0';
                    var hep_b_val = '0';
                    var ipv2_val = '0';
                    var tcv_val = '0';
                    var already_scored = '';
                    var already_commented = '';
                    var comment_status_val = '';
                    var comment_val = '';
                    var response = JSON.parse(res);
                    try {
                        if (response['dataExist'] != '' && response['dataExist'] != undefined && response['dataExist'] != 0) {
                            toastMsg('Already Commented', data['cluster_no'] + ' already commented', 'info');
                            var lastIndex = response['dataExist'].slice(-1)[0];
                            comment_status_val = lastIndex.comment_status;
                            comment_val = lastIndex.comment;
                            already_commented = '<h4 class="alreadycommented text-success">Already Commented by:' + lastIndex.createdBy + '</h4>';
                        }

                        if (response['data'] != '' && response['data'] != undefined && response['data'] != 0) {
                            var v = response['data'][0];
                            $.each(response['data'], function (i, vv) {
                                v = response['data'][i];
                            });
                            // $.each(response['data'][0], function (i, v) {
                            items += '<div class="swiper-slide"> ' +
                                '<img class="img-fluid" src="https://vcoe1.aku.edu/sero_2022/api/uploads/' + v.f01 + '" alt="banner"> ' +
                                '</div>' +
                                '<div class="swiper-slide"> ' +
                                '<img class="img-fluid" src="https://vcoe1.aku.edu/sero_2022/api/uploads/' + v.f02 + '" alt="banner"> ' +
                                '</div>';

                            image_status_val = v.image_status;
                            dobstatus_val = v.dobstatus_val;
                            bcg0_val = v.bcg0_val;
                            opv0_val = v.opv0_val;
                            opv1_val = v.opv1_val;
                            opv2_val = v.opv2_val;
                            opv3_val = v.opv3_val;
                            penta1_val = v.penta1_val;
                            penta2_val = v.penta2_val;
                            penta3_val = v.penta3_val;
                            pcv_val = v.pcv1_val;
                            pcv2_val = v.pcv2_val;
                            pcv3_val = v.pcv3_val;
                            rv1_val = v.rv1_val;
                            rv2_val = v.rv2_val;
                            ipv_val = v.ipv0_val;
                            measles1_val = v.measles1_val;
                            measles2_val = v.measles2_val;
                            hep_b_val = v.hep_b_val;
                            ipv2_val = v.ipv2_val;
                            tcv_val = v.tcv_val;

                            if (v.ec15 == 1) {
                                gender = 'M';
                            } else if (v.ec15 == 2) {
                                gender = 'F'
                            } else {
                                gender = '';
                            }
                            if (dobstatus_val == 1) {
                                dob_s = 'OK';
                            } else if (dobstatus_val == 2) {
                                dob_s = 'Invalid DoB'
                            } else {
                                dob_s = '';
                            }
                            already_scored = '<h4 class="alreadyscored text-mycolor2">Reviewed by: ' + v.createdBy + '</h4>';

                            var dob = v.im04dd + '/' + v.im04mm + '/' + v.im04yy;

                            data_items = '<div class="row">' +
                                '<div class="col-lg-6 col-md-12">' +
                                '<h6>Cluster: ' + v.cluster_no + '</h6>' +
                                '<h6 class="child_name">Child: ' + v.ec14 + '</h6>' +
                                '<h6>Date of Birth: ' + dob + '</h6>' +
                                already_scored +
                                already_commented +
                                '<input type="hidden" id="child_ec14" class="child_ec14" value="' + v.ec14 + '">' +
                                '<input type="hidden" id="ec13" class="ec13" value="' + v.ec13 + '">' +
                                '<input type="hidden" id="f01" class="f01" value="' + v.f01 + '">' +
                                '<input type="hidden" id="f02" class="f02" value="' + v.f02 + '">' +
                                '</div>' +
                                '<div class="col-lg-6 col-md-12">' +
                                '<h6>Household: ' + v.household + '</h6>' +
                                '<h6>Gender: ' + gender + '</h6>' +
                                '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col-lg-12 col-md-12 p-1">' +
                                '<label for="image_status">Image Status</label>' +
                                '<input type="text" value="' + image_status_val + '"  class="form-control" id="image_status"  readonly disabled>' +
                                '</div>' +
                                '</div>' +

                                '<div class="row">' +
                                '<div class="col-lg-12 col-md-12 p-1">' +
                                '<label for="dobstatus">DoB Status</label>' +
                                '<input type="text" value="' + dob_s + '"  class="form-control" id="dobstatus"  readonly disabled>' +
                                '</div>' +
                                '</div>' +

                                '<table class="table my-table-bordered image_form_table" border="1">' +
                                '<thead>' +
                                '<tr>' +
                                '<th width="8%"></th>' +
                                '<th  width="15%">At Birth</th>' +
                                '<th width="15%">At 6 Weeks</th>' +
                                '<th width="15%">At 10 Weeks</th>' +
                                '<th width="15%">At 14 Weeks</th>' +
                                '<th width="15%">At 9 Months</th>' +
                                '<th width="15%">At 15 Months</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<tr>' +
                                '<th scope="row">BCG</th>' +
                                '<td class="bcg0  ' + color(bcg0_val) + '"   >' + v.bcg0 + '</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">OPV</th>' +
                                '<td class="opv0  ' + color(opv0_val) + '"  >' + v.opv0 + '</td>' +
                                '<td class="opv1  ' + color(opv1_val) + '" >' + v.opv1 + '</td>' +
                                '<td class="opv2  ' + color(opv2_val) + '" >' + v.opv2 + '</td>' +
                                '<td class="opv3  ' + color(opv3_val) + '" >' + v.opv3 + '</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">Hep B</th>' +
                                '<td class="hep_b  ' + color(hep_b_val) + '"   >' + v.hep_b + '</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">Penta</th>' +
                                '<td>-</td>' +
                                '<td class="penta1  ' + color(penta1_val) + '" >' + v.penta1 + '</td>' +
                                '<td class="penta2  ' + color(penta2_val) + '" >' + v.penta2 + '</td>' +
                                '<td class="penta3  ' + color(penta3_val) + '" >' + v.penta3 + '</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">PCV</th>' +
                                '<td>-</td>' +
                                '<td class="pcv1  ' + color(pcv_val) + '"  >' + v.pcv1 + '</td>' +
                                '<td class="pcv2  ' + color(pcv2_val) + '"  >' + v.pcv2 + '</td>' +
                                '<td class="pcv3  ' + color(pcv3_val) + '"  >' + v.pcv3 + '</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">RV</th>' +
                                '<td>-</td>' +
                                '<td class="rv1  ' + color(rv1_val) + '"  >' + v.rv1 + '</td>' +
                                '<td class="rv2  ' + color(rv2_val) + '"  >' + v.rv2 + '</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">IPV</th>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td class="ipv0  ' + color(ipv_val) + '"  >' + v.ipv0 + '</td>' +


                                '<td>-</td>' +
                                '<td>-</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th scope="row">Measles</th>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td class="measles1  ' + color(measles1_val) + '"  >' + v.measles1 + '</td>' +
                                '<td class="measles2  ' + color(measles2_val) + '"  >' + v.measles2 + '</td>' +

                                '</tr>' +

                                '<tr>' +
                                '<th scope="row">IPV 2</th>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td class="ipv2  ' + color(ipv2_val) + '"  >' + v.ipv2 + '</td>' +
                                '<td>-</td>' +
                                '</tr>' +

                                '<tr>' +
                                '<th scope="row">TCV</th>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td>-</td>' +
                                '<td class="tcv  ' + color(tcv_val) + '"  >' + v.tcv + '</td>' +
                                '<td>-</td>' +
                                '</tr>' +

                                '</tbody>' +
                                '</table>' +

                                '<div class="row">' +
                                '<div class="col-lg-12 col-md-12 p-1">' +
                                '<label for="comment_status">Review Status</label>' +
                                '<select id="comment_status" class="comment_status form-control ">' +
                                '<option value="0" readonly >Review Status</option>' +
                                '<option value="OK" ' + (comment_status_val == 'OK' ? 'selected' : '') + '>OK</option>' +
                                '<option value="Error Identified" ' + (comment_status_val == 'Error Identified' ? 'selected' : '') + '>Error Identified</option>' +
                                '</select>' +
                                '</div>' +
                                '</div>' +

                                '<div class="row">' +
                                '<div class="col-lg-12 col-md-12 p-1">' +
                                '<label for="comment">Review Comments</label>' +
                                '<textarea rows="3" class="form-control" id="comment" name="comment">' + comment_val + '</textarea>' +
                                '</div>' +
                                '</div>' +


                                submitBtn +

                                '<div class="row">' +
                                '<div class="col-lg-12 col-md-12">' +
                                '<div class="mynote">' +
                                '<h6>Note</h6>' +
                                '<p class="click1">Click Once - Matched</p>' +
                                '<p class="click2">Click Twice - Not Matched</p>' +
                                '<p class="click3">Click Thrice - Not Readiable</p>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            // });
                        } else {
                            items += '<div class="swiper-slide"> ' +
                                '<p>No Image found</p>' +
                                '</div>';
                            data_items += '<p>No detail Found</p>';
                            toastMsg('Images', 'No detail Found', 'error');
                        }
                    } catch (e) {
                    }
                } else {
                    items += '<div class="swiper-slide"> ' +
                        '<p>No Image found</p>' +
                        '</div>';
                    data_items += '<p>No detail Found</p>';
                    toastMsg('Images', 'No detail Found', 'error');
                }
                $('.gallery_images').html('').html(items);
                $('.data_list').html('').html(data_items);
                setTimeout(function () {
                    gallery();
                }, 500);
            });
        } else {
            $('.clusters_select').css('border', '1px solid red');
            $('.household_select').css('border', '1px solid red');
            toastMsg('Page', 'Something went wrong', 'error');
        }

    }

    function color(v) {
        var mycolor = '';
        if (v == 1) {
            mycolor = 'mygreen';
        } else if (v == 2) {
            mycolor = 'myred';
        } else if (v == 3) {
            mycolor = 'myorange';
        } else {
            mycolor = '';
        }
        return mycolor;
    }


</script>