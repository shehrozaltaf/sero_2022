<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Error Files</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Error Files</li>
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
                            <input type="hidden" id="hidden_delete"
                                   value="<?php echo(isset($permission[0]->CanDelete) && $permission[0]->CanDelete != '' ? $permission[0]->CanDelete : 0) ?>">
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


            <section id="column-selectors" class="hide main_content_div">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Files</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard cardHtml">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
                <section id="uploadFile" class="hide main_content_div">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Upload Files</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard ">
                                        <form id="document_form" method="post"
                                              onsubmit="return false" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-sm-12 col-12">
                                                    <h4 class="card-title">Upload File</h4>
                                                    <div class="form-group">
                                                        <input type="file" class="form-control"
                                                               id="document_file" name="document_file" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
                                                <button type="submit" class="btn btn-primary mybtn" onclick="addData()">
                                                    Submit
                                                </button>
                                            <?php } ?>
                                        </form>
                                        <div class="row m-1">
                                            <div class="col-sm-12">
                                                <h4 class="res_heading" style="color: green;"></h4>
                                                <p class="res_msg" style="color: green;"></p>
                                            </div>
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


<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete File</h4>
                    <input type="hidden" id="delete_id" name="delete_id">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- END: Content-->
<script>
    $(document).ready(function () {
        $('#document_file').change(function () {
            $('#document_label').text(this.files[0].name);
        });
    });


    function addData() {
        $('#file_name').css('border', '1px solid #babfc7');
        $('#document_file').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['document_file'] = $('#document_file').val();
        data['district'] = $('.district_select').val();
        if (data['district'] == '' || data['district'] == undefined) {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
            return false;
        }

        if (data['document_file'] == '' || data['document_file'] == undefined) {
            $('#document_file').css('border', '1px solid red');
            toastMsg('File', 'Invalid File', 'error');
            flag = 1;
            return false;
        }

        if (flag == 0) {
            $('.res_heading').html('');
            $('.res_msg').html('');
            $('.mybtn').attr('disabled', 'disabled');
            var formData = new FormData($("#document_form")[0]);
            formData.append('district', data['district']);
            CallAjax('<?php echo base_url('index.php/Error_files/uploadFile')?>', formData, 'POST', function (result) {
                $('.mybtn').removeAttr('disabled', 'disabled');
                try {
                    var response = JSON.parse(result);
                    if (response[0] == 'Success') {
                        toastMsg(response[0], response[1], 'success');
                        $('.res_heading').html(response[0]).css('color', 'green');
                        $('.res_msg').html(response[1]).css('color', 'green');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500)
                    } else {
                        toastMsg(response[0], response[1], 'error');
                        $('.res_heading').html(response[0]).css('color', 'red');
                        $('.res_msg').html(response[1]).css('color', 'red');
                    }
                } catch (e) {
                }
            }, true);
        }
    }


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
                            items += '<option value="' + v.dist_id + '">' + v.district + '</option>';
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
        $('.main_content_div').addClass('hide');
        var data = {};
        var hidden_delete = $('#hidden_delete').val();
        data['province'] = $('.province_select').val();
        if (data['province'] == '' || data['province'] == undefined) {
            toastMsg('Province', 'Invalid Province', 'error');
        }
        data['district'] = $('.district_select').val();
        if (data['district'] == '' || data['district'] == undefined) {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            CallAjax("<?php echo base_url() . 'index.php/Error_files/searchData' ?>", data, "POST", function (Result) {
                var a = JSON.parse(Result);
                var items = "";
                $('.main_content_div').removeClass('hide');
                $('.cardHtml').html('');
                if (a != null) {
                    items += "<div class='table-responsive'>";
                    items += "<table class='table table-striped table-bordered '>";
                    items += "<tr>";
                    items += "<th>File Name</th>";
                    items += "<th>Date Time</th>";
                    items += "<th>Action</th>";
                    items += "</tr>";

                    var randomized = '';
                    var checked = '';
                    var u = '';
                    if (a.length > 0) {
                        try {
                            $.each(a, function (i, val) {
                                items += "<tr class='fgtr'>";
                                u = '<?php echo base_url() ?>assets/uploads/error_files/' + val.file_name;
                                items += "<td><a href='" + u + "' target='_blank'> " + val.file_name + "</td>";
                                items += "<td>" + val.createdDateTime + "</td>";
                                items += "<td data-id='" + val.id + "'><a href='" + u + "' target='_blank'><i class='feather icon-eye'></i> </a>";
                                if (hidden_delete == 1) {
                                    items += " <a href='javascript:void(0)' onclick='getDelete(this)'>" +
                                        " <i class='feather icon-trash'></i>" +
                                        "</a>";
                                }
                                items += "</td>";
                                items += "</tr>";
                            });
                        } catch (e) {
                            console.log(e);
                        }
                    }
                    items += "</table></div>";
                    $('.cardHtml').html(items);
                } else {

                }
            });
        }

    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['id'] = $('#delete_id').val();
        if (data['id'] == '' || data['id'] == undefined || data['id'] == 0) {
            toastMsg('ID', 'Something went wrong', 'error');
            return false;
        } else {
            CallAjax('<?php echo base_url('index.php/Error_files/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    toastMsg('File', 'Successfully Deleted', 'success');
                    $('#deleteModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    toastMsg('User', 'Something went wrong', 'error');
                }

            });
        }
    }

</script>