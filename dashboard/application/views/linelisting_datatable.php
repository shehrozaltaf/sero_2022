<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/charts/apexcharts.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/card-analytics.css">

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Line Listing Progress</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Line Listing</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <?php if (isset($get_linelisting_table) && $get_linelisting_table != '') {
                foreach ($get_linelisting_table as $k => $r) {
                    $explode = explode("|", $r['geoarea']);
                    $province = ltrim(rtrim($explode[0]));
                    $division = ltrim(rtrim($explode[1]));
                    $p_id = substr($r['dist_id'], 0, 3);
                    $d_id = substr($r['dist_id'], 0, 5);
                }

                ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Linelisting Report</h4>

                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <p>
                                                <a href="<?php echo base_url('index.php/Dashboard/dashboard_index/d' . $p_id . '_t'); ?>">
                                                    <?php echo ucwords(strtolower($province)); ?>
                                                </a>
                                                <a href="<?php echo base_url('index.php/Dashboard/dashboard_dt/d' . $p_id . '_t/s' . $d_id . '_t'); ?>">
                                                    <?php echo ' / ' . ucwords(strtolower($division)); ?>
                                                </a>
                                            </p>

                                            <table class="table table-striped  dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Cluster Number</th>
                                                    <th>Total Structures</th>
                                                    <th>Total Household</th>
                                                    <th>HH Targeted Children</th>
                                                    <th>Household 6-11 Months</th>
                                                    <th>Household 12-23 Months</th>
                                                    <th>Children 6-11 Months</th>
                                                    <th>Children 12-23 Months</th>
                                                    <th>Collecting Tabs</th>
                                                    <th>Completed Tabs</th>
                                                    <th>Tab Activity</th>
                                                    <th>Status</th>
                                                    <th>Randomized</th>
                                                    <th>Planning</th>
                                                    <th>Data Collected</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $sno = 0;
                                                foreach ($get_linelisting_table as $k => $r) {
                                                    $sno++;
                                                    $explode = explode("|", $r['geoarea']);
                                                    $province = ltrim(rtrim($explode[0]));
                                                    $division = ltrim(rtrim($explode[1]));
                                                    $p_id = substr($r['dist_id'], 0, 3);
                                                    $d_id = substr($r['dist_id'], 0, 5);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sno; ?></td>
                                                        <td><?php echo $r['cluster_no']; ?></td>
                                                        <td><?php echo $r['structures']; ?></td>
                                                        <td><?php echo $r['residential_structures']; ?></td>
                                                        <td><?php echo $r['target_children']; ?></td>
                                                        <td><?php echo(isset($r['hh_6_11_months']) && $r['hh_6_11_months'] != '' ? $r['hh_6_11_months'] : 0) ?></td>
                                                        <td><?php echo(isset($r['hh_12_23_months']) && $r['hh_12_23_months'] != '' ? $r['hh_12_23_months'] : 0) ?></td>
                                                        <td><?php echo(isset($r['no_of_children_6_11_months']) && $r['no_of_children_6_11_months'] != '' ? $r['no_of_children_6_11_months'] : 0) ?></td>
                                                        <td><?php echo(isset($r['no_of_children']) && $r['no_of_children'] != '' ? $r['no_of_children'] : 0) ?></td>
                                                        <td><?php echo $r['collecting_tabs']; ?></td>
                                                        <td><?php echo $r['completed_tabs']; ?></td>
                                                        <td>
                                                            <?php if ($r['collecting_tabs'] == 1) {
                                                                echo '<small>Start : <span class="primary">' . date('d-m-Y h:i A', strtotime($r['startActivity'])) . '</span></small>';
                                                                echo '<br><small>End : <span class="primary">' . date('d-m-Y h:i A', strtotime($r['endActivity'])) . '</span></small>';

                                                            } else {
                                                                echo '-';
                                                            } ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $rand_show = '';
                                                            if ($r['structures'] == 0 || $r['structures'] == '') {
                                                                $rand_show = '2';
                                                                $stat = 'Remaining';
                                                            } else if ($r['collecting_tabs'] != $r['completed_tabs']) {
                                                                $rand_show = '4';
                                                                $stat = 'In Progress';
                                                            } else if ($r['status'] != '1') {
                                                                $rand_show = '1';
                                                                $stat = 'Ready to Randomize';
                                                                if (!isset($r['area']) || $r['area'] == '' || $r['area'] == 0) {
                                                                    $rand_show = '10';
                                                                }
                                                            } else {
                                                                $rand_show = '3';
                                                                $stat = 'Randomized';
                                                            }

                                                            if(isset($r['area']) &&$r['area']!=''){
                                                                $area_show = '<a href="'.base_url().$r['map_upload'].'" target="_blank" class="btn btn-sm btn-secondary"> View Map</a>';
                                                            }elseif($rand_show == '10'){
                                                                $area_show = '<a href="javascript:void(0)" onclick="addArea_Modal(this)" data-cluster="' . $r['cluster_no'] . '"data-geoarea="' . $r['geoarea'] . '" class="btn btn-sm btn-primary area_btn rand_btn">Add Cluster Identification</a>';
                                                            }else{
                                                                $area_show='';
                                                            }


                                                            echo $stat;
                                                            ?>
                                                        </td>
                                                        <?php
                                                        if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1 && $rand_show == '1') {
                                                            echo '<td><a href="javascript:void(0)" onclick="randomizeBtn(this)" data-cluster="' . $r['cluster_no'] . '" class="btn btn-sm btn-primary rand_btn">Randomize</a><br>'.$area_show.'</td>';
                                                        } elseif ($rand_show == '2' || $rand_show == '4') {
                                                            echo '<td>-</td>';
                                                        } elseif ($rand_show == '10') {
                                                            echo '<td>'.$area_show.'</td>';
                                                        } else {
                                                            echo '<td><a href="' . base_url('index.php/Dashboard/make_pdf/' . $r['cluster_no']) . '" target="_blank" class="btn  btn-sm btn-success">Print</a> ';
                                                            echo ' | <a href="' . base_url('index.php/Dashboard/get_excel/' . $r['cluster_no']) . '" target="_blank" class="btn btn-sm btn-danger">Get Excel</a>
                                                                   | '.$area_show.'</td>';
                                                        }

                                                        if ($rand_show == 3 && isset($r['planning']) && $r['planning'] != 2) {
                                                            $plan_after = 3;
                                                        } else {
                                                            $plan_after = 0;
                                                        }
                                                        ?>


                                                        <?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
                                                            <td data-id="<?php echo $r['cluster_no'] ?>"
                                                                data-dist="<?php echo $r['dist_id'] ?>">
                                                                <?php
                                                                if ($plan_after == 3) {
                                                                    echo '<a href="javascript:void(0)" class=" btn btn-sm bg-gradient-primary"
                                                                       onclick="add_after_planning(this)">DC Planning </a>';
                                                                }
                                                                if (isset($r['planning']) && $r['planning'] != '' && ($r['planning'] == 1 || $r['planning'] == 2)) {
                                                                    echo '<a href="javascript:void(0)" class=" btn btn-sm bg-gradient-warning"
                                                                       onclick="view_planning(this)">View Planning</a>';
                                                                } else {
                                                                    echo '  <a href="javascript:void(0)" class="btn btn-sm bg-gradient-success"
                                                                       onclick="add_before_planning(this)">Listing
                                                                        Planning</a>';
                                                                }


                                                                echo '  <a href="' . base_url() . 'index.php/Manual_linelisting?p=' . $p_id . '&d=' . $d_id . '&c=' . $r['cluster_no'] . '" 
                                                                          target="_blank"  class="btn btn-sm bg-gradient-info" >Manual Linelisting</a>';
                                                                ?>
                                                            </td>
                                                        <?php } else {
                                                            echo '<td>-</td>';
                                                        } ?>
                                                        <?php
                                                        if (isset($r['data_collected']) && $r['data_collected'] == 'Manual') {
                                                            $data_collected = 'Manual';
                                                        } else {
                                                            $data_collected = 'App';
                                                        }

                                                        echo '<td>' . $data_collected . '</td>';
                                                        ?>
                                                    </tr>
                                                <?php }
                                                ?>
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Cluster Number</th>
                                                    <th>Total Structures</th>
                                                    <th>Total Household</th>
                                                    <th>HH Targeted Children</th>
                                                    <th>Household 6-11 Months</th>
                                                    <th>Household 12-23 Months</th>
                                                    <th>Children 6-11 Months</th>
                                                    <th>Children 12-23 Months</th>
                                                    <th>Collecting Tabs</th>
                                                    <th>Completed Tabs</th>
                                                    <th>Tab Activity</th>
                                                    <th>Status</th>
                                                    <th>Randomized</th>
                                                    <th>Planning</th>
                                                    <th>Data Collected</th>
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

<input type="hidden" id="hidden_dist" value="<?php echo $sub_district; ?>">
<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_edit"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Add Listing Planning</h4>
                    <input type="hidden" id="planning_cluster" name="planning_cluster">
                    <input type="hidden" id="planning_dist" name="planning_dist">
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="listing_date">Listing Date: </label>
                            <input type="text" class="form-control listing_date mypickadat" id="listing_date" required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="edit_fullName">Tablet Using: </label>
                            <fieldset>
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="1" class="custom-control-input" name="tablet_using"
                                           id="tablet_using1" checked onclick="tablet_using(this)">
                                    <label class="custom-control-label" for="tablet_using1">Single</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="custom-control custom-radio">
                                    <input type="radio" value="2" class="custom-control-input " name="tablet_using"
                                           id="tablet_using2" onclick="tablet_using(this)">
                                    <label class="custom-control-label" for="tablet_using2">Multiple</label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="dc1">Data Collector 1: </label>
                            <select class="select2 form-control dist_users dc1" id="dc1" required>
                                <option value="0" readonly disabled selected>Data Collector 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group hide dc2_toggle">
                            <label for="dc2">Data Collector 2: </label>
                            <select class="select2 form-control dist_users dc2" id="dc2">
                                <option value="0" readonly disabled selected>Data Collector 2</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="addPlanning_beforeRandomize()">Add Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="afterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_after"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_after">Add DC Planning</h4>
                    <input type="hidden" id="dc_planning_cluster" name="dc_planning_cluster" required>
                    <input type="hidden" id="dc_planning_dist" name="dc_planning_dist" required>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="collection_date">Collection Date: </label>
                            <input type="text" class="form-control collection_date mypickadat" id="collection_date"
                                   required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="collector_name">Collector Name: </label>
                            <select class="select2 form-control dist_users collector_name" id="collector_name" required>
                                <option value="0" readonly disabled selected>Data Collector 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="tablet_id">Tablet Id: </label>
                            <input type="text" class="form-control tablet_id" id="tablet_id" required>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="addPlanning_afterRandomize()">Add Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_view"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_view">View Planning</h4>
                </div>
                <div class="modal-body view_body">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="modal fade text-left" id="editModal_addArea" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_edit_addArea"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Add Cluster Identification</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="clusterNo_area">Cluster Number: </label>
                            <input type="text" class="form-control  clusterNo_area" id="clusterNo_area" readonly
                                   disabled required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="geoarea_area">Geo Area: </label>
                            <input type="text" class="form-control geoarea_area" id="geoarea_area" readonly disabled
                                   required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="form-group ">
                            <label for="area_area">Area: </label>
                            <textarea name="area_area" class="form-control  area_area" id="area_area" cols="30"
                                      rows="5"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upload Map</h4>
                            </div>
                            <div class="card-body">
                                <input type="file" id="map_area" name="map_area"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="addAreaBtn()">Add Data
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<!--<script src="--><?php //echo base_url() ?><!--assets/vendors/js/charts/apexcharts.min.js"></script>-->

<script>

    $(document).ready(function () {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            disable: [
                1,
                [2020, 7, 1],
                [2020, 8, 28]
            ],
            format: 'dd-mm-yyyy'
        });

    });

    function getDistrictUsers(dist) {
        var district = '';
        if (dist == '' || dist == undefined) {
            district = $('#hidden_dist').val();
        } else {
            district = dist;
        }
        var data = {};
        data['dist'] = district;
        if (data['dist'] != '' && data['dist'] != undefined && data['dist'] != '0' && data['dist'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/App_Users/getUsersByDistrict'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" readonly disabled selected>User Name</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.username + '" onclick="changeDist()">' + v.full_name + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.dist_users').html('').html(items);
            });
        } else {
            toastMsg('Error', 'Invalid Data', 'error');
            $('.dist_users').html('');
        }
    }

    function tablet_using(obj) {
        var a = $("input[name='tablet_using']:checked").val();
        if (a == 2) {
            $('.dc2_toggle').removeClass('hide');
            $('#dc2').attr('required', 'required');
        } else {
            $('.dc2_toggle').addClass('hide');
            $('#dc2').removeAttr('required');
        }
    }


    function view_planning(obj) {
        var data = {};
        data['cluster'] = $(obj).parent('td').attr('data-id');
        if (data['cluster'] != '' && data['cluster'] != undefined) {
            CallAjax('<?php echo base_url('index.php/Dashboard/viewPlanning')?>', data, 'POST', function (result) {
                if (result != '' && JSON.parse(result).length > 0) {
                    var a = JSON.parse(result);
                    try {
                        var tablets = '';
                        if (a[0]['tablets'] == 1) {
                            tablets = 'Single';
                        } else if (a[0]['tablets'] == 2) {
                            tablets = 'Multiple';
                        }
                        var html = '';
                        html += '<p><small class="primary">Cluster:</small> ' + a[0]['cluster_no'] + '</p>';
                        html += '<p><small class="primary">District: </small>' + a[0]['province'] + '</p>';
                        html += '<p><small class="primary">UC: </small>' + a[0]['dist'] + '</p>';
                        html += '<p><small class="primary">Listing Date: </small>' + a[0]['listing_date'] + '</p>';
                        html += '<p><small class="primary">Tablets Using: </small>' + tablets + '</p>';
                        html += '<p><small class="primary">Data Collector 1: </small>' + a[0]['dc1'] + '</p>';
                        html += '<p><small class="primary">Data Collector 2: </small>' + a[0]['dc2'] + '</p>';
                        html += '<p><small class="primary">Collection Date: </small>' + a[0]['collection_date'] + '</p>';
                        html += '<p><small class="primary">Collector Name: </small>' + a[0]['collector_name'] + '</p>';
                        html += '<p><small class="primary">Tablet Id: </small>' + a[0]['tablet_id'] + '</p>';
                    } catch (e) {
                    }
                    $('.view_body').html(html);
                    $('#viewModal').modal('show');
                } else {
                    toastMsg('Error', 'Invalid Data', 'error');
                }
            });

        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }
    }

    function add_before_planning(obj) {
        var data = {};
        data['cluster'] = $(obj).parent('td').attr('data-id');
        data['dist'] = $(obj).parent('td').attr('data-dist');
        if (data['cluster'] != '' && data['cluster'] != undefined) {
            $('#planning_cluster').val(data['cluster']);
            $('#planning_dist').val(data['dist']);
            getDistrictUsers(data['dist']);
            $('#editModal').modal('show');
        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }
    }

    function addPlanning_beforeRandomize() {
        var data = {};
        data['planning_cluster'] = $('#planning_cluster').val();
        data['planning_dist'] = $('#planning_dist').val();
        data['listing_date'] = $('#listing_date').val();
        data['tablet_using'] = $("input[name='tablet_using']:checked").val();
        data['dc1'] = $('#dc1').val();
        data['dc2'] = $('#dc2').val();
        var vd = validateData(data);
        if (vd) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Dashboard/addPlanning'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Success', 'Successfully inserted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else if (result == 2) {
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    toastMsg('Error', 'Invalid District', 'error');
                } else if (result == 4) {
                    toastMsg('Error', 'Invalid LineListing Date', 'error');
                } else if (result == 5) {
                    toastMsg('Error', 'Invalid Data Collector', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            toastMsg('Page', 'Something went wrong', 'error');
        }
    }

    function add_after_planning(obj) {
        var data = {};
        data['cluster'] = $(obj).parent('td').attr('data-id');
        data['dist'] = $(obj).parent('td').attr('data-dist');
        if (data['cluster'] != '' && data['cluster'] != undefined) {
            $('#dc_planning_cluster').val(data['cluster']);
            $('#dc_planning_dist').val(data['dist']);
            $('#afterModal').modal('show');
        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }
    }

    function addPlanning_afterRandomize() {
        var data = {};
        data['planning_cluster'] = $('#dc_planning_cluster').val();
        data['planning_dist'] = $('#dc_planning_dist').val();
        data['collection_date'] = $('#collection_date').val();
        data['collector_name'] = $('#collector_name').val();
        data['tablet_id'] = $('#tablet_id').val();
        var vd = validateData(data);
        if (vd) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Dashboard/add_dc_Planning'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    $('#afterModal').modal('hide');
                    toastMsg('Success', 'Successfully inserted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else if (result == 2) {
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 4) {
                    toastMsg('Error', 'Invalid Collection Date', 'error');
                } else if (result == 5) {
                    toastMsg('Error', 'Invalid Collector Name', 'error');
                } else if (result == 7) {
                    toastMsg('Error', 'Invalid Tablet Id', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            toastMsg('Page', 'Something went wrong', 'error');
        }
    }

    function randomizeBtn(obj) {
        $('.rand_btn').css('display', 'none').attr('disabled', 'disabled');
        var data = {};
        data['cluster_no'] = $(obj).attr('data-cluster');
        if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            $('.rand_btn').css('display', 'block').removeAttr('disabled', 'disabled');
            return false;
        } else {
            showloader();
            CallAjax('<?php echo base_url('index.php/Dashboard/systematic_randomizer') ?>', data, 'POST', function (result) {
                $('.rand_btn').css('display', 'block').removeAttr('disabled', 'disabled');
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    var ht = '<a href="<?php echo base_url() ?>/index.php/Dashboard/make_pdf/' + data['cluster_no'] + '"' +
                        ' target="_blank"' +
                        ' class="btn  btn-sm btn-success waves-effect waves-light">Print</a> ' +
                        ' | <a href="<?php echo base_url() ?>/index.php/Dashboard/get_excel/' + data['cluster_no'] + '" ' +
                        'target="_blank" class="btn btn-sm btn-danger waves-effect waves-light">Get Excel</a>';
                    $(obj).parent('td').html(ht);
                    setTimeout(function () {
                        window.open('<?php echo base_url() ?>index.php/Dashboard/make_pdf/' + data['cluster_no'], '_blank');
                    }, 1000);
                } else if (result == 2) {
                    toastMsg('Already Randomized', 'Cluster No ' + data['cluster_no'] + ' is Already Randomized', 'info');
                } else if (result == 3) {
                    toastMsg('Zero Households', 'Cluster No ' + data['cluster_no'] + ' has Zero Households', 'danger');
                } else if (result == 4) {
                    toastMsg('Cluster', 'Invalid Cluster No', 'error');
                } else if (result == 5) {
                    toastMsg('Error', 'Error on updating Status', 'error');
                } else if (result == 7) {
                    toastMsg('Error', 'Duplicate Household Found in Cluster, Please coordinate with DMU', 'error');
                } else if (result == 8) {
                    toastMsg('Error', 'Area is not defined in cluster.', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function addArea_Modal(obj) {
        var data = {};
        data['cluster'] = $(obj).attr('data-cluster');
        data['geoarea'] = $(obj).attr('data-geoarea');
        if (data['cluster'] != '' && data['cluster'] != undefined) {
            $('#clusterNo_area').val(data['cluster']);
            $('#geoarea_area').val(data['geoarea']);
            $('#editModal_addArea').modal('show');
        } else {
            toastMsg('Error', 'Invalid Cluster', 'error');
        }
    }

    function addAreaBtn(obj) {
        $('.area_btn').css('display', 'none').attr('disabled', 'disabled');
        $('.rand_btn').css('display', 'none').attr('disabled', 'disabled');
        $('#clusterNo_area').removeClass('error');
        $('#geoarea_area').removeClass('error');
        $('#area_area').removeClass('error');
        $('#map_area').removeClass('error');
        var flag = 0;

        var data = new FormData();
        data.append('clusterNo_area', $('#clusterNo_area').val());
        data.append('geoarea_area', $('#geoarea_area').val());
        data.append('area_area', $('#area_area').val());
        data.append('map_area', $('#map_area')[0].files[0]);
        data['clusterNo_area'] = $('#clusterNo_area').val();
        data['geoarea_area'] = $('#geoarea_area').val();
        data['area_area'] = $('#area_area').val();
        data['map_area'] = $('#map_area').val();

        if (data['clusterNo_area'] == '' || data['clusterNo_area'] == undefined || data['clusterNo_area'] == '0') {
            toastMsg('Cluster', 'Invalid Cluster No', 'error');
            $('#clusterNo_area').addClass('error');
            flag = 1;
            return false;
        }
        if (data['geoarea_area'] == '' || data['geoarea_area'] == undefined || data['geoarea_area'] == '0') {
            toastMsg('Invalid', 'Invalid GeoArea', 'error');
            $('#geoarea_area').addClass('error');
            flag = 1;
            return false;
        }
        if (data['area_area'] == '' || data['area_area'] == undefined || data['area_area'] == '0') {
            toastMsg('Area', 'Invalid Area', 'error');
            $('#area_area').addClass('error');
            flag = 1;
            return false;
        }
        if (data['map_area'] == '' || data['map_area'] == undefined || data['map_area'] == '0') {
            toastMsg('Map', 'Invalid Map', 'error');
            $('#map_area').addClass('error');
            flag = 1;
            return false;
        }

        if (flag == 0) {

            showloader();
            CallAjax('<?php echo base_url('index.php/Dashboard/addClusterIdentification') ?>', data, 'POST', function (result) {
                $('.rand_btn').css('display', 'block').removeAttr('disabled', 'disabled');
                $('.area_btn').css('display', 'block').removeAttr('disabled', 'disabled');
                hideloader();
                var response = JSON.parse(result);
                if (response[0] == 'Success') {
                    toastMsg(response[0], response[1], 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastMsg(response[0], response[1], 'error');
                }

            }, true);
        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }
    }


    $(document).ready(function () {
        $('.dataex-html5-selectors').DataTable({
            dom: 'Bfrtip',
            "displayLength": 25,
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
</script>