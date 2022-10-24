<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Cluster Profile</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Cluster Profile</li>
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
            <?php
            if (isset($myData) && $myData != '' && isset( $slug_district) && $slug_district!='' ) {  ?>
            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cluster Profile</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>Cluster</th>
                                                <th>Geoarea</th>
                                                <th>Area/Village</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($myData) && $myData != '') {
                                                foreach ($myData as $k => $r) { ?>
                                                    <tr>
                                                        <td><?php echo $r->cluster_no ?></td>
                                                        <td><?php echo $r->geoarea ?></td>
                                                        <td><?php echo $r->area ?></td>
                                                        <td data-id="<?php echo $r->id ?>"
                                                            data-area="<?php echo $r->area ?>"
                                                            data-cluster="<?php echo $r->cluster_no ?>">
                                                            <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1
                                                                && (!isset($r->area) || $r->area == '')) { ?>
                                                                <a href="javascript:void(0)" onclick="getEdit(this)"><i
                                                                            class="feather icon-edit"></i> </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Cluster</th>
                                                <th>Georea</th>
                                                <th>Area/Village</th>
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

        </div>
    </div>
</div>
<!-- END: Content-->

<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_edit"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Edit Cluster Area/Village</h4>

                    <input type="hidden" id="edit_id" name="edit_id">
                    <input type="hidden" id="edit_cluster" name="edit_cluster">
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="edit_area">Area/Village (with any landmark): </label>
                        <input type="text" class="form-control edit_area" id="edit_area">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="editData()">Edit
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

    $(document).ready(function () {
        changeDist();

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

    function getEdit(obj) {
        var data = {};
        data['id'] = $(obj).parent('td').attr('data-id');
        data['cluster'] = $(obj).parent('td').attr('data-cluster');
        data['area'] = $(obj).parent('td').attr('data-area');
        if (data['id'] != '' && data['id'] != undefined && data['cluster'] != '' && data['cluster'] != undefined) {
            $('#edit_id').val(data['id']);
            $('#edit_cluster').val(data['cluster']);
            $('#edit_area').val(data['area']);
            $('#editModal').modal('show');
        } else {
            toastMsg('Error', 'Invalid ID', 'error');
            return false;
        }
    }

    function editData() {
        $('#edit_pageName').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['id'] = $('#edit_id').val();
        data['cluster'] = $('#edit_cluster').val();
        data['area'] = $('#edit_area').val();
        if (data['id'] == '' || data['id'] == undefined || data['id'].length < 1
            && data['cluster'] == '' || data['cluster'] == undefined || data['cluster'].length < 1) {
            flag = 1;
            toastMsg('Error', 'Invalid ID or Cluster', 'error');
            return false;
        }
        if (data['area'] == '' || data['area'] == undefined || data['area'].length < 1) {
            $('#edit_area').css('border', '1px solid red');
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;
            return false;
        }
        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Cluster_profile/editArea')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Area', 'Successfully inserted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 3) {
                    toastMsg('Error', 'Invalid Page', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function searchData() {
        var url = '';
        var district = $('#district_select').val();
        var uc = $('#uc_select').val();
        if (district != '' && district != undefined && district != '0') {
            url += '&d=' + district;
            if (uc != '' && uc != undefined && uc != '0') {
                url += '&u=' + uc;
            }
        }
        window.location.href = '<?php echo base_url() ?>index.php/cluster_profile?s=1' + url;
    }


</script>