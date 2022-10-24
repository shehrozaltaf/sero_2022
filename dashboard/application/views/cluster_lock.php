<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Cluster Lock</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Cluster Lock</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $data = $getData[0]; ?>
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
                                                <select class="select2 form-control district_select" autocomplete="dist"
                                                        id="district_select"
                                                        onchange="changeDist()">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($dist) && $dist != '') {
                                                        foreach ($dist as $k => $p) {
                                                            echo '<option value="' . $p->dist_id . '" ' . (isset($slug_district) && $slug_district == $p->dist_id ? "selected" : "") . '>' . $p->district . '</option>';
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
                                                <select class="select2 form-control uc_select" autocomplete="uc"
                                                        id="uc_select">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Status
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control randomized_select">
                                                    <option value="2" selected>All Clusters</option>
                                                    <option value="1">Randomized</option>
                                                    <option value="0">Not Randomized</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" ">
                                        <button type="button" class="btn btn-primary" onclick="getData()">Get
                                            Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section id="column-selectors" class="hide main_content_div">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Clusters</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard cardHtml">
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
<script>
    function getData() {
        $('.main_content_div').addClass('hide');
        var data = {};
        data['district'] = $('#district_select').val();
        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0') {
            $('#district_select').css('border', '1px solid red');
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        data['ucs'] = $('#uc_select').val();
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0') {
            $('#uc_select').css('border', '1px solid red');
            toastMsg('UC', 'Invalid UC', 'error');
            return false;
        } else {
            data['randomized'] = $('.randomized_select').val();
            CallAjax("<?php echo base_url() . 'index.php/Dashboard/getClustersByUCs' ?>", data, "POST", function (Result) {
                var a = JSON.parse(Result);
                var items = "";
                $('.main_content_div').removeClass('hide');
                $('.cardHtml').html('');
                if (a != null) {
                    items += "<div class='table-responsive'>";
                    items += "<table class='table table-striped table-bordered '>";
                    items += "<tr>";
                    items += "<td></td>";
                    items += "<td><h4>Check All</h4></td>";
                    items += '<td><input type="checkbox"  name="CheckAll" value="Check All"  ' +
                        'id="CheckAll"   onchange="CheckAll(this)" /></td>';
                    items += "</tr>";
                    items += "<tr>";
                    items += "<th>Cluster</th>";
                    items += "<th>Randomized</th>";
                    items += "<th>Lock</th>";
                    items += "</tr>";

                    var randomized = '';
                    var checked = '';
                    if (a.length > 0) {
                        try {
                            $.each(a, function (i, val) {
                                items += "<tr class='fgtr'>";
                                items += "<td>" + val.cluster_no + "</td>";
                                if (val.randomized == 1) {
                                    randomized = 'Randomized';
                                } else {
                                    randomized = '';
                                }

                                if (val.locked == 1) {
                                    checked = 'checked';
                                } else {
                                    checked = '';
                                }
                                items += "<td>" + randomized + "</td>";
                                items += "<td>";
                                items += '<input type="checkbox" class="checkboxes" data-cluster_no="' + val.cluster_no + '" ' +
                                    ' name="locked_clusters" value="' + val.locked + '" ' + checked + '  ' +
                                    'id="locked_clusters' + i + '"  />';
                                items += "</td>";

                                items += "</tr>";
                            });
                        } catch (e) {
                            console.log(e);
                        }
                    }
                    items += "</table></div>";
                    items += "<input type='button' value='Send All' id='btn-Edit' onclick='SaveChanges()' class='btn bg-secondary white addbtn'/>";
                    $('.cardHtml').html(items);
                } else {

                }
            });
        }

    }

    function CheckAll(ele) {
        var checkboxes = document.getElementsByTagName('input');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }

    function SaveChanges() {
        var data = {};
        var clusters = [];
        var cluster_no = '';
        var count = $('.fgtr').find('.checkboxes');
        for (var i = 0; i < count.length; i++) {
            cluster_no = $(count[i]).attr('data-cluster_no');
            if ($(count[i]).is(':checked')) {
                clusters.push({'cluster_no': cluster_no, 'lock': 1});
            } else {
                clusters.push({'cluster_no': cluster_no, 'lock': 0});
            }
        }
        if (clusters.length >= 1) {
            $('#btn-Edit').css('display', 'none');
            data['clusters'] = clusters;
            CallAjax("<?php echo base_url() . 'index.php/Cluster_lock/setLock' ?>", data, "POST", function (Result) {
                if (Result == 1) {
                    toastMsg('Success', 'Successfully Changed', 'success');
                    setTimeout(function () {
                        $('#btn-Edit').css('display', 'block');
                        window.location.reload();
                    }, 2000);
                } else if (Result == 3) {
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            toastMsg('Cluster', 'Please select Cluster', 'error');
        }
    }

</script>