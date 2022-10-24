<!--<link rel="stylesheet" type="text/css" href="--><?php //echo base_url() ?><!--assets/vendors/css/ui/prism.min.css">-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo base_url() ?><!--assets/vendors/css/file-uploaders/dropzone.min.css">-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo base_url() ?><!--assets/css/plugins/file-uploaders/dropzone.css">-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Upload Data</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Upload</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="basic-select2" id="dropzone-examples">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <!--<div class="form-group row">
                                        <div class="col-md-2">
                                            <span>Table</span>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="select2 form-control idTable" id="idTable"
                                                    name="idTable" required>
                                                <option value="0" readonly disabled selected>Table Type</option>
                                                <option value="project">Project</option>
                                                <option value="budget">Budget</option>
                                                <option value="employee">Employee</option>
                                                <option value="actual">Actual</option>
                                                <option value="projected">Projected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <span>Upload File</span>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" class="custom-file-input  form-control"
                                                   id="document_file" name="document_file" accept="application/xlsx">
                                            <label class="custom-file-label" for="document_file">Choose PDF</label>
                                        </div>
                                    </div>-->

                                    <form id="document_form" method="post"
                                          onsubmit="return false" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <h4 class="card-title">Table</h4>
                                                <div class="form-group">
                                                    <select class="select2 form-control idTable" id="idTable"
                                                            name="idTable" required>
                                                        <option value="0" readonly disabled selected>Table Type</option>
                                                        <option value="bl_randomised">bl_randomised</option>
                                                        <option value="clusters">clusters</option>
                                                        <option value="devices">devices</option>
                                                        <option value="users">users</option>
                                                        <option value="users_dash">users_dash</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <h4 class="card-title">Upload File</h4>
                                                <div class="form-group">
                                                    <input type="file" class="form-control"
                                                           id="document_file" name="document_file" required>
                                                </div>
                                            </div>
                                        </div>


                                        <!--<div class="row">
                                            <div class="col-12 col-sm-12 ">
                                                <h4 class="card-title">Upload File</h4>
                                                <div class="card">
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <form action="#" method="post" class="dropzone dropzone-area"
                                                                  id="dpz-remove-thumb" enctype="multipart/form-data">
                                                                <div class="dz-message">Drop Files Here To Upload</div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
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

        </div>
    </div>
</div>
<!-- END: Content-->
<!--<script src="--><?php //echo base_url() ?><!--assets/vendors/js/extensions/dropzone.min.js"></script>-->
<!--<script src="--><?php //echo base_url() ?><!--assets/vendors/js/ui/prism.min.js"></script>-->

<!--<script src="--><?php //echo base_url() ?><!--assets/js/scripts/extensions/dropzone.js"></script>-->

<script>
    /*Dropzone.options.dpzRemoveThumb = {
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 1, // MB
        addRemoveLinks: true,
        dictRemoveFile: " Trash",
        init: function () {
            this.on("maxfilesexceeded", function (file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    };*/


    $(document).ready(function () {
        $('#document_file').change(function () {
            $('#document_label').text(this.files[0].name);
        });

    });

    function addData() {
        $('#idTable').css('border', '1px solid #babfc7');
        $('#document_file').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idTable'] = $('#idTable').val();
        data['document_file'] = $('#document_file').val();
        if (data['idTable'] == '' || data['idTable'] == undefined) {
            $('#idTable').css('border', '1px solid red');
            toastMsg('Table', 'Invalid Table', 'error');
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
            CallAjax('<?php echo base_url('index.php/Upload_data/addExcelData')?>', formData, 'POST', function (result) {
                $('.mybtn').removeAttr('disabled', 'disabled');
                try {
                    var response = JSON.parse(result);
                    if (response[0] == 'Success') {
                        toastMsg(response[0], response[1].message, 'success');
                        $('.res_heading').html(response[0]).css('color', 'green');
                        $('.res_msg').html(response[1]).css('color', 'green');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500)
                    } else {
                        toastMsg(response[0], response[1].message, 'error');
                        $('.res_heading').html(response[0]).css('color', 'red');
                        $('.res_msg').html(response[1].message).css('color', 'red');
                    }
                } catch (e) {
                }
            }, true);
        }
    }


</script>