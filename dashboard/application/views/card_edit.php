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
                        <h2 class="content-header-title float-left mb-0">Card Edit</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Card Edit</li>
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
                                                <select class="select2 form-control district_select">
                                                    <option value="0" readonly disabled selected>District</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-sm-2 col-12">
                                            <div class="form-group">
                                                <label for="checklist" class="label-control ">Invalid Date</label>
                                                <input type="checkbox" name="checklist" value="1" id="checklist_1">
                                            </div>
                                        </div>-->
                                        <div class="col-sm-2 col-12">
                                            <div class="form-group">
                                                <label for="checklist" class="label-control ">Reviewed</label>
                                                <input type="checkbox" name="checklist" value="2" id="checklist_2"
                                                       checked>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-12 ">
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

            <!-- gallery swiper start -->
            <section id="component-swiper-gallery" class="hide">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Clusters</h4>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="listdata list-group">
                                        </ul>
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
    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Image_forms/getDistrictByProvince'  ?>', data, 'POST', function (res) {
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

    function searchData() {
        $('#component-swiper-gallery').addClass('hide');
        var flag = 0;
        var data = {};
        data['province'] = $('.province_select').val();
        data['district'] = $('.district_select').val();
        if (data['province'] == '' || data['province'] == undefined || data['province'] == '0') {
            $('.clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Province', 'Invalid Province', 'error');
            return false;
        }
        var list_checklist = [];
        $("input[name=checklist]:checked").each(function () {
            list_checklist.push($(this).val());
        });
        data['checklist'] = list_checklist;
        if (data['checklist'].length < 1 || data['checklist'] == '' || data['checklist'] == undefined || data['checklist'] == '0') {
            flag = 1;
            toastMsg('Checklist', 'Invalid Checklist', 'error');
            return false;
        }

        if (flag == 0) {
            CallAjax('<?php echo base_url('index.php/Card_edit/getData') ?>', data, 'POST', function (res) {
                var items = '';
                if (res != '' && res != undefined) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<li class="list-group-item">' + i + '<ul>';
                            $.each(v, function (ii, vv) {
                                var editedBy = '';
                                if (vv.editedBy != '' && vv.editedBy != undefined) {
                                    editedBy = '<span class="danger"> Already edited by: ' + vv.editedBy + ' </span>';
                                }
                                var url = 'Card_edit/edit_form?c=' + i + '&h=' + vv.hhno + '&ec=' + vv.ec13;
                                items += '<li class=""><a  target="_blank" href="' + url + '"> ' + vv.hhno + ' - ' + vv.ec13 + '</a> ' + editedBy + '</li>';
                            });
                            items += "</ul></li>";

                        })
                    } catch (e) {
                    }
                } else {
                    items += '<p>No detail Found</p>';
                    toastMsg('Images', 'No detail Found', 'error');
                }
                $('.listdata').html('').html(items);
                $('#component-swiper-gallery').removeClass('hide');
            });
        } else {
            toastMsg('Page', 'Something went wrong', 'error');
        }

    }

</script>