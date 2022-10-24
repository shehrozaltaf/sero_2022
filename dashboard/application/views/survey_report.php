


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Sync/Survey Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Survey Report
                                </li>
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

            <section id="column-selectors">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sync Report</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped dataex-html5-selectors">
                                            <thead>
                                            <tr>
                                                <th>Cluster</th>
                                                <th>District</th>
                                                <th>Form Date</th>
                                                <th>Synced</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($myData) && $myData != '') {
                                                foreach ($myData as $k => $r) {  ?>
                                                    <tr>
                                                        <td onclick="getHousehold(this)" data-cluster="<?php echo $r->Cluster  ?>"
                                                            data-formDate="<?php echo $r->FormDate; ?>"><?php echo $r->Cluster ?></td>
                                                        <td><?php echo $r->district ?></td>
                                                        <td><?php echo $r->FormDate ?></td>
                                                        <td><?php echo $r->Synced ?></td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Cluster</th>
                                                <th>District</th>
                                                <th>Form Date</th>
                                                <th>Synced</th>
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
        </div>
    </div>
</div>
<!-- END: Content-->

<input type="hidden" id="hidden_slug_dist"
       value="<?php echo(isset($slug_district) && $slug_district != '' ? $slug_district : ''); ?>">
<!-- Modal -->

<div class="modal fade text-left" id="clusterModal" tabindex="-1" role="dialog" aria-labelledby="clusterModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title white" id="clusterModalLabel">Cluster Data</h5>
                <p>Cluster: <span class="cluster_text"></span>, FormDate: <span class="formdate_text"></span></p>
            </div>
            <div class="modal-body ">
                <h4>Households</h4>
                <ul class="body_text" style="list-style: decimal;"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    function getHousehold(obj) {
        var cluster = $(obj).attr('data-cluster');
        var formDate = $(obj).attr('data-formDate');
        if (cluster != undefined && cluster != '' && formDate != undefined && formDate != '') {
            $('.cluster_text').text(cluster);
            $('.formdate_text').text(formDate);

            $('#clusterModal').modal('show');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/Survey_report/getHousehold',
                data: 'cluster=' + cluster + '&formDate=' + formDate,
                method: 'POST',
                success: function (res) {
                    var items = '';
                    if (res != '' && JSON.parse(res).length > 0) {
                        var response = JSON.parse(res);
                        try {
                            $.each(response, function (i, v) {
                                items += '<li>' + v.hhno + '</li>';
                            })
                        } catch (e) {
                        }
                    }
                    $('.body_text').html(items);
                }

            })
        } else {
            alert('Invalid Cluster');
        }
    }
    $(document).ready(function () {
        changeProvince();
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 50,
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

    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var dist = $('#hidden_slug_dist').val();
                var items = '<option value="0">Select All</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.dist_id + '"  ' + (dist == v.dist_id ? 'selected' : '') + '>' + v.district + '</option>';
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
        var province = $('.province_select').val();
        var district = $('.district_select').val();
        if (province == '' || province == undefined || province == '0') {
            province = '';
        }
        if (district == '' || district == undefined || district == '0') {
            district = '';
        }
        window.location.href = '<?php echo base_url() ?>index.php/survey_report?p=' + province + '&d=' + district;
    }

</script>