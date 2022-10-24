<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Daily Progress Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Progress Report Email</li>
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
                                        <div class="col-sm-6 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control province_select"
                                                        onchange="changeProvince()">
                                                    <option value="0" readonly disabled selected>District</option>
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
                                                UC
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
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
                </div>
            </section>


            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Users</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard ">
                                    <div class="row">
                                        <div class="col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="bcg" class="label-control ">Report Date</label>
                                                <input type="text" class="form-control mypickadat" required
                                                       id="report_date"
                                                       name="report_date"
                                                       value="<?php echo date('d-m-Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cardHtml">

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
<script>

    $(document).ready(function () {
        getData();
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            disable: [
                [2020, 7, 1],
                [2020, 8, 28]
            ],
            format: 'dd-mm-yyyy'
        });
    });


    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var items = '<option value="0"   readonly disabled selected>District</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    console.log(response);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.dist_id + '" onclick="changeDist()">' + v.district + '</option>';
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


    function getData() {
        var data = {};
        data['province'] = $('.province_select').val();
        data['district'] = $('.district_select').val();
        CallAjax("<?php echo base_url() . 'index.php/ProgressReportEmail/getUsers' ?>", data, "POST", function (Result) {
            var a = JSON.parse(Result);
            var items = "";
            $('.cardHtml').html('');
            if (a != null) {
                items += "<div class='table-responsive'>";
                items += "<table class='table table-striped table-bordered '>";
                items += "<tr>";
                items += "<td></td>";
                items += "<td></td>";
                items += "<td><h4>Check All</h4></td>";
                items += '<td><input type="checkbox"  name="CheckAll" value="Check All"  ' +
                    'id="CheckAll"   onchange="CheckAll(this)" /></td>';
                items += "</tr>";
                items += "<tr>";
                items += "<th> User Name </th>";
                items += "<th> Full Name </th>";
                items += "<th> District </th>";
                items += "<th> Send Mail</th>";
                items += "</tr>";

                if (a.length > 0) {
                    try {
                        $.each(a, function (i, val) {
                            items += "<tr class='fgtr'>";
                            items += "<td>" + val.username + "</td>";
                            items += "<td>" + val.full_name + "</td>";
                            items += "<td>" + val.district + "</td>";
                            items += "<td>";
                            items += '<input type="checkbox" class="checkboxes" data-username="' + val.username + '"  name="CanViewAllDetail" value="' + val.username + '"  ' +
                                'id="CanViewAllDetail' + i + '"  />';
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
        // $('#btn-Edit').css('display', 'none');

        var data = {};
        var report_date = $('#report_date').val();
        if (report_date == '' || report_date == undefined) {
            toastMsg('Date', 'Invalid Report Date', 'error');
        } else {
            data['report_date'] = report_date;
            var users = [];
            var username = '';
            var count = $('.fgtr').find('.checkboxes');
            for (var i = 0; i < count.length; i++) {
                if ($(count[i]).is(':checked')) {
                    username = $(count[i]).attr('data-username');
                    users.push({'username': username});
                }
            }
            data['users'] = users;
            CallAjax("<?php echo base_url() . 'index.php/ProgressReportEmail/sendEmail' ?>", data, "POST", function (Result) {
                console.log(Result);
                /*if (data) {
                    toastMsg('Success', 'Successfully Changed', 'success');
                    setTimeout(function () {
                        $('#btn-Edit').css('display', 'block');
                        // window.location.reload();
                    }, 2000);
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }*/
            });
        }

    }

</script>