<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Cluster Reset</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Cluster Reset</li>
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
                                        <div class="col-sm-6 col-12">
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

<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Reset Cluster</h4>
                    <input type="hidden" id="reset_idCluster" name="reset_idCluster">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to reset this <span class="cluster_head"></span> cluster?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="resetData()">Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<input type="hidden" id="hidden_slug_dist"
       value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<input type="hidden" id="hidden_slug_uc" value="<?php echo(isset($slug_uc) && $slug_uc != '' ? $slug_uc : ''); ?>">

<script>

    function getData() {
        $('.main_content_div').addClass('hide');
        var flag =0;
        var data = {};
        var district_select = $('#district_select').val();
        if (district_select == '' || district_select == undefined || district_select == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        var uc_select = $('#uc_select').val();
        if (uc_select == '' || uc_select == undefined || uc_select == '0') {
            $('#uc_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('UC', 'Invalid UC', 'error');
            return false;
        } else {
            CallAjax("<?php echo base_url() . 'index.php/Dashboard/getClustersByUCs' ?>", data, "POST", function (Result) {
                var a = JSON.parse(Result);
                var items = "";
                $('.main_content_div').removeClass('hide');
                $('.cardHtml').html('');
                if (a != null) {
                    items += "<div class='table-responsive'>";
                    items += "<table class='table table-striped dataex-html5-selectors'>";
                    items += "<thead><tr>";
                    items += "<th>Cluster</th>";
                    items += "<th>Randomized</th>";
                    items += "<th>Reset</th>";
                    items += "</tr></thead><tbody>";

                    var randomized = '';
                    var checked = '';
                    if (a.length > 0) {
                        try {
                            $.each(a, function (i, val) {
                                if (val.randomized == 1) {
                                    randomized = 'Randomized';
                                    items += "<tr class='fgtr'>";
                                    items += "<td>" + val.cluster_no + "</td>";
                                    items += "<td>" + randomized + "</td>";
                                    items += "<td>";
                                    items += ' <a href="javascript:void(0)" data-id="'+ val.cluster_no +'"  title="Reset Cluster" onclick="getReset(this)">' +
                                        '<i class="feather icon-trash"></i> </a>';
                                    items += "</td>";
                                    items += "</tr>";
                                }
                            });

                        } catch (e) {
                            console.log(e);
                        }
                    }
                    items += "</tbody></table></div>";
                    $('.cardHtml').html(items);
                    setTimeout(function () {
                        $('.dataex-html5-selectors').DataTable({
                            dom: 'Bfrtip',
                            "displayLength": 50,
                            "oSearch": {"sSearch": " "},
                            autoFill: false,
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
                    },500);
                } else {

                }
            });
        }

    }

    function getReset(obj) {
        var id = $(obj).attr('data-id');
        $('#reset_idCluster').val(id);
        $('.cluster_head').html(id);
        $('#deleteModal').modal('show');
    }

    function resetData() {
        var data = {};
        data['cluster'] = $('#reset_idCluster').val();
        if (data['cluster'] == '' || data['cluster'] == undefined || data['cluster'] == 0) {
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        } else {
            showloader();
            CallAjax('<?php echo base_url('index.php/Cluster_reset/setReset')?>', data, 'POST', function (res) {
                hideloader();
                if (res == 1) {
                    toastMsg('Cluster', 'Cluster reset successfully', 'success');
                    $('#deleteModal').modal('hide');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                }else if (res ==2) {
                    toastMsg('Cluster', 'Cluster updated but Bl_randomized not updated', 'error');
                }else if (res ==3) {
                    toastMsg('Cluster', 'Invalid Cluster', 'error');
                }else if (res == 4) {
                    toastMsg('Cluster', 'Cluster Not Updated', 'error');
                }else  {
                    toastMsg('Cluster', 'Something went wrong', 'error');
                }

            });
        }
    }

</script>