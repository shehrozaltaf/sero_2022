<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Groups Settings</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Settings</a>
                                </li>
                                <li class="breadcrumb-item active">Group Settings
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="content-body">
            <section id="ordering">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Group Setting
                                </h4>
                            </div>
                            <div class="card-content collapse show">
                                <input type="hidden" id="idGroup" name="idGroup"
                                       value="<?php echo(isset($slug) && $slug != '' ? $slug : '') ?>">
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

<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url(); ?>assets/vendors/js/tables/datatable/datatables.min.js"
        type="text/javascript"></script>
<script>
    $(document).ready(function () {
        getFormGroupData();
    });

    function getFormGroupData() {
        var data = {};
        data['idGroup'] = $('#idGroup').val();
        CallAjax("<?php echo base_url() . 'index.php/Settings/getFormGroupData' ?>", data, "POST", function (Result) {
            var a = JSON.parse(Result);
            var items = "";
            $('.cardHtml').html('');
            if (a != null) {
                items += "<div class='table-responsive'>";
                items += "<table class='table table-striped table-bordered '>";
                items += "<tr>";
                items += "<td></td>";
                items += "<td></td>";
                items += "<td></td>";
                items += "<td></td>";
                items += "<td><h4>Check All</h4></td>";
                items += '<td><input type="checkbox"  name="CheckAll" value="Check All"  ' +
                    'id="CheckAll"   onchange="CheckAll(this)" /></td>';
                items += "</tr>";
                items += "<tr>";
                items += "<th> Form Name </th>";
                items += "<th> Can View All Detail </th>";
                items += "<th> Can View </th>";
                items += "<th> Can Add </th>";
                items += "<th> Can Edit </th>";
                items += "<th> Can Delete </th>";
                items += "</tr>";
                if (a.length > 0) {
                    try {
                        $.each(a, function (i, val) {
                            items += "<tr class='fgtr'>";
                            items += "<td>" + val.pageName + "</td>";
                            items += "<td>";
                            if (val.CanViewAllDetail == 1) {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanViewAllDetail" value="' + val.CanViewAllDetail + '"  ' +
                                    'id="CanViewAllDetail' + i + '"   checked/>';
                            } else {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanViewAllDetail" value="' + val.CanViewAllDetail + '"  ' +
                                    'id="CanViewAllDetail' + i + '"  />';
                            }
                            items += "</td>";
                            items += "<td>";
                            if (val.CanView == 1) {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanView" value="' + val.CanView + '"  ' +
                                    'id="CanView' + i + '"   checked/>';
                            } else {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanView" value="' + val.CanView + '"  ' +
                                    'id="CanView' + i + '"  />';
                            }
                            items += "</td>";

                            items += "<td>";
                            if (val.CanAdd == 1) {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanAdd" value="' + val.CanAdd + '"  ' +
                                    'id="CanAdd' + i + '"   checked/>';
                            } else {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanAdd" value="' + val.CanAdd + '"  ' +
                                    'id="CanAdd' + i + '"  />';
                            }
                            items += "</td>";

                            items += "<td>";
                            if (val.CanEdit == 1) {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanEdit" value="' + val.CanEdit + '"  ' +
                                    'id="CanEdit' + i + '"   checked/>';
                            } else {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanEdit" value="' + val.CanEdit + '"  ' +
                                    'id="CanEdit' + i + '"  />';
                            }
                            items += "</td>";

                            items += "<td>";
                            if (val.CanDelete == 1) {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanDelete" value="' + val.CanDelete + '"  ' +
                                    'id="CanDelete' + i + '"   checked/>';
                            } else {
                                items += '<input type="checkbox" data-idPageGroup="' + val.idPageGroup + '"  name="CanDelete" value="' + val.CanDelete + '"  ' +
                                    'id="CanDelete' + i + '"    />';
                            }

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
        $('#btn-Edit').css('display', 'none');
        var tr;
        var arr = {};
        tr = $('.fgtr');
        var count = $(tr).find('input');
        for (i = 0; i < count.length; i++) {
            var data = {};
            data["idPageGroup"] = $(count[i]).attr('data-idPageGroup');
            console.log('asdas  d   ', $(count[i]).attr('data-idPageGroup'));
            data[$(count[i]).attr('name')] = ($(count[i]).is(':checked')) ? true : false;
            arr[i] = data;
        }
        var url = "<?php echo base_url() . 'index.php/Settings/fgAdd' ?>";
        CallAjax(url, arr, "POST", function (data) {
            if (data) {
                toastMsg('Success', 'Successfully Changed', 'success');
                setTimeout(function () {
                    $('#btn-Edit').css('display', 'block');
                    window.location.reload();
                }, 2000);
            } else {
                toastMsg('Error', 'Something went wrong', 'error');
            }
        });
    }

</script>