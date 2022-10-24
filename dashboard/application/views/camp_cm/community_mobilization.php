<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Community Mobilizations</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Community Mobilizations
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
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select"
                                                        id="district_select"
                                                        onchange="changeDistrict('district_select','ucs_select',1)">
                                                    <option value="0" readonly disabled selected>District</option>
                                                    <?php if (isset($district) && $district != '') {
                                                        foreach ($district as $k => $d) {
                                                            echo '<option value="' . $d->dist_id . '" ' . (isset($slug_district) && $slug_district == $d->dist_id ? "selected" : "") . '>' . $d->district . '</option>';
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
                                                <select class="select2 form-control ucs_select" id="ucs_select"
                                                        onchange="changeUC('ucs_select','area',1)">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary" onclick="searchData()">Get
                                                Data
                                            </button>
                                            <?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
                                                <button type="button" class="btn btn-danger" onclick="addModal()">Add
                                                    Mobilization
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (isset($slug_district) && $slug_district != '' && $slug_district != 0) { ?>
                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Community Mobilizations</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataex-html5-selectors">
                                                <thead>
                                                <tr>
                                                    <th>Area</th>
                                                    <th>Plan Date</th>
                                                    <th>Session No</th>
                                                    <th>Status</th>
                                                    <th>Conducted Date</th>
                                                    <th>Venue</th>
                                                    <th>Gender Type</th>
                                                    <th>Session Type</th>
                                                    <th>Session Topic</th>
                                                    <th>Mobilizers</th>
                                                    <th>Locked</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (isset($myData) && $myData != '') {
                                                    foreach ($myData as $k => $r) { ?>
                                                        <tr>
                                                            <td><?php echo $r['area_name'] ?></td>
                                                            <td>
                                                                <?php if (isset($r['plan_date']) && $r['plan_date'] != '') {
                                                                    $hiddenplan_date = date('d-m-Y', strtotime($r['plan_date']));
                                                                    $plan_date = date('Y, n, j', strtotime($r['plan_date']));
                                                                    echo date('d-m-Y', strtotime($r['plan_date']));
                                                                } else {
                                                                    $hiddenplan_date = '';
                                                                    $plan_date = 'true';
                                                                    echo '-';
                                                                }

                                                                if (isset($r['camp_status']) && $r['camp_status'] != '') {
                                                                    if ($r['camp_status'] == 'Planned') {
                                                                        $camp_status = '<span class="text-primary">Planned</span>';
                                                                    } elseif ($r['camp_status'] == 'Conducted') {
                                                                        $camp_status = '<span class="text-success">Conducted</span>';
                                                                    } elseif ($r['camp_status'] == 'Canceled') {
                                                                        $camp_status = '<span class="text-danger">Canceled</span>';
                                                                    } else {
                                                                        $camp_status = '';
                                                                    }
                                                                } else {
                                                                    $camp_status = '';
                                                                }
                                                                ?></td>
                                                            <td><?php echo(isset($r['session_no']) && $r['session_no'] != '' ? $r['session_no'] : '') ?></td>
                                                            <td><?php echo $camp_status ?></td>
                                                            <td><?php echo(isset($r['execution_date']) && $r['execution_date'] != '' ? date('d-m-Y', strtotime($r['execution_date'])) : '') ?></td>
                                                            <td><?php echo(isset($r['venue']) && $r['venue'] != '' ? $r['venue'] : '') ?></td>
                                                            <td><?php echo(isset($r['participant_gender_type']) && $r['participant_gender_type'] != '' ? $r['participant_gender_type'] : '') ?></td>
                                                            <td><?php echo(isset($r['session_type']) && $r['session_type'] != '' ? $r['session_type'] : '') ?></td>
                                                            <td><?php echo(isset($r['session_topic']) && $r['session_topic'] != '' ? $r['session_topic'] : '') ?></td>
                                                            <td><?php echo $r['doctors'] ?></td>
                                                            <?php
                                                            $locked_event = '';
                                                            $l_class = '';
                                                            if ($r['locked'] == 1) {
                                                                $loc = 'Locked';
                                                                $locked_icon = 'icon-lock';
                                                                $l_class = 'bg-gradient-danger';
                                                                $locked_event = '<i class="feather ' . $locked_icon . '"></i> ';
                                                            } elseif ($r['locked'] == 0) {
                                                                $loc = 'UnLock';
                                                                $locked_icon = 'icon-unlock';
                                                                $l_class = 'bg-gradient-success';
                                                                if ($r['camp_status'] == 'Conducted') {
                                                                    $locked_event = ' <a href="javascript:void(0)" onclick="getLock(this)">
                                                                    <i class="feather ' . $locked_icon . '"></i> 
                                                                    </a>';
                                                                }
                                                            } else {
                                                                $loc = '';
                                                                $locked_icon = '';
                                                            } ?>
                                                            <td><a href="javascript:void(0)"
                                                                   class="btn btn-sm <?php echo $l_class; ?>"><?php echo $loc; ?></a>
                                                            </td>
                                                            <td data-id="<?php echo $r['id'] ?>"
                                                                data-campno="<?php echo(isset($r['session_no']) && $r['session_no'] != '' ? $r['session_no'] : '') ?>">
                                                                <?php
                                                                if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) {
                                                                    echo $locked_event;
                                                                }
                                                                if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1 && $r['locked'] == 0 && $r['camp_status'] != 'Conducted' && $r['camp_status'] != 'Canceled') { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="getEdit(this)"
                                                                       data-plandate="<?php echo $plan_date; ?>"
                                                                       data-hiddenplandate="<?php echo $hiddenplan_date; ?>"><i
                                                                                class="feather icon-edit"></i> </a>
                                                                <?php } ?>
                                                                <?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1 && $r['locked'] == 0) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="getDelete(this)">
                                                                        <i class="feather icon-trash"></i>
                                                                    </a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Area</th>
                                                    <th>Plan Date</th>
                                                    <th>Session No</th>
                                                    <th>Status</th>
                                                    <th>Conducted Date</th>
                                                    <th>Venue</th>
                                                    <th>Gender Type</th>
                                                    <th>Session Type</th>
                                                    <th>Session Topic</th>
                                                    <th>Mobilizers</th>
                                                    <th>Locked</th>
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

<input type="hidden" id="hidden_slug_ucs" value="<?php echo(isset($slug_ucs) && $slug_ucs != '' ? $slug_ucs : ''); ?>">
<input type="hidden" id="hidden_slug_area"
       value="<?php echo(isset($slug_area) && $slug_area != '' ? $slug_area : ''); ?>">
<!-- Modal -->
<!-- END: Content-->
<?php if (isset($permission[0]->CanAdd) && $permission[0]->CanAdd == 1) { ?>
    <div class="modal  fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_add"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_add">Add Community Mobilization</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="session_no">Camp No: </label>
                        <input type="text" class="form-control" id="session_no" name="session_no" value="" readonly
                               disabled
                               required>
                    </div>
                    <div class="form-group">
                        <label for="plan_date">Plan Date: </label>
                        <input type="text" class="form-control mypickadat" id="plan_date"
                               name="plan_date" required>
                    </div>

                    <div class="form-group">
                        <label for="area">Location: </label>
                        <select class="select2 form-control" name="area" id="area"
                                required>
                            <option value="0" readonly disabled selected>Select Location</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="participant_gender_type">Session Specific Gender: </label>
                        <select class="select2 form-control" name="participant_gender_type" id="participant_gender_type"
                                required>
                            <option value="0" readonly disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Both">Both</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="session_type">Session Type: </label>
                        <select class="select2 form-control" name="session_type" id="session_type"
                                onchange="setOtherOption('session_type', 'session_type_other');" required>
                            <option value="0" readonly disabled selected>Select Camp Type</option>
                            <option value="BBCM">BBCM</option>
                            <option value="Group Session">Group Session</option>
                            <option value="Individual counselling">Individual counselling</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="session_type_other">Session Type Other: </label>
                        <input type="text" class="form-control" id="session_type_other"
                               name="session_type_other" readonly disabled required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger mybtn" onclick="addData()">Add</button>
                </div>

            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_edit"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_edit">Conducted/Cancel Community Mobilization</h4>
                    <input type="hidden" id="edit_idCommunity_mobilization" name="edit_idCommunity_mobilization">
                    <input type="hidden" id="edit_session_no" name="edit_session_no">
                    <input type="hidden" id="edit_hiddenplan_date" name="edit_hiddenplan_date">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="camp_status">Status: </label>
                                <select class="select2 form-control" onchange="disbaledInps_Cancel()"
                                        id="camp_status" required>
                                    <option value="0" readonly disabled selected>Status</option>
                                    <option value="Conducted">Conducted</option>
                                    <option value="Canceled">Canceled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="execution_date">Conducted Date: </label>
                                <input type="text" class="form-control mypickadat_execution" id="execution_date"
                                       name="execution_date"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="remarks">Remarks/Reason: </label>
                                <textarea name="remarks" class="form-control" id="remarks" cols="10"
                                          rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Mobilizer">Mobilizer: </label>
                                <select class="select2 form-control" id="Mobilizer" name="Mobilizer[]"
                                        multiple="multiple" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="venue">Venue: </label>
                                <select name="venue" id="venue" class="form-control select2"
                                        onchange="setOtherOption('venue', 'venue_other');" required>
                                    <option value="0" readonly selected disabled>Select Venue</option>
                                    <option value="Mosque">Mosque</option>
                                    <option value="School">School</option>
                                    <option value="Hujra">Hujra</option>
                                    <option value="Otaq">Otaq</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="venue_other">Venue Other: </label>
                                <input type="text" class="form-control" id="venue_other"
                                       name="venue_other" disabled required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="session_topic">Session Topic: </label>
                                <select name="session_topic[]" id="session_topic" class="form-control select2"
                                        multiple="multiple"
                                        onchange="setOtherOption('session_topic', 'session_topic_other');" required>
                                    <option value="COVID-19 Preventive Measures">COVID-19 Preventive Measures</option>
                                    <option value="Diarrhea Preventive Measures">Diarrhea Preventive Measures</option>
                                    <option value="Health and Hygiene">Health & Hygiene</option>
                                    <option value="Health Care during COVID-19">Health Care during COVID-19</option>
                                    <option value="Infant and Young Child Feeding">Infant & Young Child Feeding</option>
                                    <option value="Polio Preventive Measures">Polio Preventive Measures</option>
                                    <option value="Project Introduction">Project Introduction</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="session_topic_other">Session Topic Other: </label>
                                <input type="text" class="form-control" id="session_topic_other"
                                       name="session_topic_other" disabled required>
                            </div>
                        </div>
                    </div>
                    <div class="divider divider-primary">
                        <div class="divider-text">Estimated Population</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="total_male">Total Male Participants: </label>
                                <input type="number" class="form-control" id="total_male"
                                       name="total_male" maxlength="4" max="4"
                                       minlength="1" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="total_female">Total Female Participants: </label>
                                <input type="number" class="form-control" id="total_female"
                                       name="total_female" maxlength="4" max="4"
                                       min="1" minlength="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="divider divider-primary">
                        <div class="divider-text">Community Leaders</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="political_com_leaders">Political: </label>
                                <input type="number" class="form-control" id="political_com_leaders"
                                       name="political_com_leaders" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="religious_com_leaders">Religious: </label>
                                <input type="number" class="form-control" id="religious_com_leaders"
                                       name="religious_com_leaders" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="educational_com_leaders">Educational: </label>
                                <input type="number" class="form-control" id="educational_com_leaders"
                                       name="educational_com_leaders" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="businessman_com_leaders">Businessman: </label>
                                <input type="number" class="form-control" id="businessman_com_leaders"
                                       name="businessman_com_leaders" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="other_com_leaders">Other Community Leaders: </label>
                                <input type="number" class="form-control" id="other_com_leaders"
                                       name="other_com_leaders" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="divider divider-primary">
                        <div class="divider-text">Health Care Providers</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="doctors_health_provider">Doctors: </label>
                                <input type="number" class="form-control" id="doctors_health_provider"
                                       name="doctors_health_provider" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="paramedics_health_provider">Paramedics: </label>
                                <input type="number" class="form-control" id="paramedics_health_provider"
                                       name="paramedics_health_provider" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lhws_health_provider">LHWs: </label>
                                <input type="number" class="form-control" id="lhws_health_provider"
                                       name="lhws_health_provider" maxlength="4" max="4" min="1" minlength="1" value="0"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lhvs_health_provider">LHVs: </label>
                                <input type="number" class="form-control" id="lhvs_health_provider"
                                       name="lhvs_health_provider" maxlength="4" max="4" min="1" minlength="1" value="0"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cmws_health_provider">CMWs: </label>
                                <input type="number" class="form-control" id="cmws_health_provider"
                                       name="cmws_health_provider" maxlength="4" max="4" min="1" minlength="1" value="0"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="vaccinators_health_provider">Vaccinators: </label>
                                <input type="number" class="form-control" id="vaccinators_health_provider"
                                       name="vaccinators_health_provider" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="other_health_provider">Other Health Care Providers: </label>
                                <input type="number" class="form-control" id="other_health_provider"
                                       name="other_health_provider" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="divider divider-primary">
                        <div class="divider-text">Government Officials</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fcv_government_officials">FCV: </label>
                                <input type="number" class="form-control" id="fcv_government_officials"
                                       name="fcv_government_officials" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ucpw_government_officials">UCPW: </label>
                                <input type="number" class="form-control" id="ucpw_government_officials"
                                       name="ucpw_government_officials" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ttsp_government_officials">TTSP: </label>
                                <input type="number" class="form-control" id="ttsp_government_officials"
                                       name="ttsp_government_officials" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="other_government_officials">Other Government: </label>
                                <input type="number" class="form-control" id="other_government_officials"
                                       name="other_government_officials" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="divider divider-primary">
                        <div class="divider-text">Other Participants</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="other_participants">Other Participants: </label>
                                <input type="number" class="form-control" id="other_participants"
                                       name="other_participants" maxlength="4" max="4" min="1" minlength="1"
                                       value="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="editData()">Update
                    </button>
                </div>

            </div>
        </div>
    </div>

<?php } ?>

<?php if (isset($permission[0]->CanEdit) && $permission[0]->CanEdit == 1) { ?>
    <div class="modal fade text-left" id="lockModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_lock"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_lock">Lock Community Mobilization</h4>
                    <input type="hidden" id="lock_idCommunity_mobilization" name="lock_idCommunity_mobilization">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to Lock this Community Mobilization?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="lockData()">Lock
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($permission[0]->CanDelete) && $permission[0]->CanDelete == 1) { ?>
    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel_delete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="myModalLabel_delete">Delete Community Mobilization</h4>
                    <input type="hidden" id="delete_idCommunity_mobilization" name="delete_idCommunity_mobilization">
                </div>
                <div class="modal-body">
                    <p>Are you sure, you want to delete this?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="deleteData()">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        changeDistrict('district_select', 'ucs_select', 1);
        mydate();
        changeUC('ucs_select', 'area', 1);
        limit_numeric('total_male', 4);
        limit_numeric('total_female', 4);
        limit_numeric('political_com_leaders', 4);
        limit_numeric('religious_com_leaders', 4);
        limit_numeric('educational_com_leaders', 4);
        limit_numeric('businessman_com_leaders', 4);
        limit_numeric('other_com_leaders', 4);
        limit_numeric('doctors_health_provider', 4);
        limit_numeric('paramedics_health_provider', 4);
        limit_numeric('lhws_health_provider', 4);
        limit_numeric('lhvs_health_provider', 4);
        limit_numeric('cmws_health_provider', 4);
        limit_numeric('vaccinators_health_provider', 4);
        limit_numeric('other_health_provider', 4);
        limit_numeric('fcv_government_officials', 4);
        limit_numeric('ucpw_government_officials', 4);
        limit_numeric('ttsp_government_officials', 4);
        limit_numeric('other_government_officials', 4);
        limit_numeric('other_participants', 4);
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
            "order": [[2, "desc"]],
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

    function disbaledInps_Cancel() {
        var camp_status = $('#camp_status').val();
        if (camp_status == 'Canceled') {
            $('#remarks').attr('required', 'required');
            $('#execution_date').val('').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#venue').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#venue').select2("val", 0);
            $('#venue_other').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#session_topic').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#session_topic').select2("val", 0);
            $('#Mobilizer').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#Mobilizer').select2("val", 0);
            $('#session_topic_other').val('').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#total_male').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#total_female').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#political_com_leaders').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#religious_com_leaders').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#educational_com_leaders').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#businessman_com_leaders').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#doctors_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#paramedics_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#lhws_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#lhvs_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#cmws_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#vaccinators_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#fcv_government_officials').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#ucpw_government_officials').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#ttsp_government_officials').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#other_government_officials').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#other_com_leaders').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#other_health_provider').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $('#other_participants').val('0').attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
        } else {
            $('#remarks').removeAttr('required');
            $('#execution_date').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#venue').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#venue_other').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#Mobilizer').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#session_topic').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#session_topic_other').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#total_male').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#total_female').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#political_com_leaders').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#religious_com_leaders').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#educational_com_leaders').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#businessman_com_leaders').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#doctors_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#paramedics_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#lhws_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#lhvs_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#cmws_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#vaccinators_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#fcv_government_officials').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#ucpw_government_officials').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#ttsp_government_officials').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#other_government_officials').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#other_com_leaders').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#other_health_provider').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            $('#other_participants').removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            setOtherOption('venue', 'venue_other');
            setOtherOption('session_topic', 'session_topic_other');
        }
    }

    function setOtherOption(selectOption, otherInpOption) {
        var session_topic = $('#' + selectOption).val();
        if (selectOption == 'session_topic') {
            $('#' + otherInpOption).attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            $.each(session_topic, function (i, v) {
                if (v != '' && v == 'Other') {
                    $('#' + otherInpOption).removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
                }
            });
        } else {
            if (session_topic != '' && session_topic == 'Other') {
                $('#' + otherInpOption).removeAttr('readonly').removeAttr('disabled').attr('required', 'required');
            } else {
                $('#' + otherInpOption).attr('readonly', 'readonly').attr('disabled', 'disabled').removeAttr('required');
            }
        }

    }

    function addModal() {
        var flag = 0;
        var data = {};
        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();
        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        }
        if (flag == 0) {
            showloader();
            $('#tblaudit .tblaudit_body').html('');
            CallAjax('<?php echo base_url('index.php/Camp_CM/Community_mobilization/getMaxCM'); ?>', data, 'POST', function (result) {
                hideloader();
                var maxcamp = parseInt(result);
                if (maxcamp != '' && maxcamp != undefined && maxcamp != 0) {
                    $('#session_no').val(maxcamp);
                    $('#edit_session_no').val(maxcamp);
                    $('#addModal').modal('show');

                } else {
                    $('#district_select').addClass('error');
                    $('#ucs_select').addClass('error');
                    toastMsg('District', 'Invalid District', 'error');
                }
            });

        }

    }

    function addData() {
        $('#editModal').find('.error').removeClass('error');
        var flag = 0;
        var data = {};
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['session_no'] = $('#session_no').val();
        data['area'] = $('#area').val();
        data['plan_date'] = $('#plan_date').val();
        data['participant_gender_type'] = $('#participant_gender_type').val();
        data['session_type'] = $('#session_type').val();
        data['session_type_other'] = $('#session_type_other').val();
        if (data['dist_id'] == '' || data['dist_id'] == undefined) {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;

        }
        if (data['ucCode'] == '' || data['ucCode'] == undefined) {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;

        }
        if (data['session_no'] == '' || data['session_no'] == undefined) {
            $('#session_no').addClass('error');
            toastMsg('Camp', 'Invalid Camp', 'error');
            flag = 1;

        }
        if (data['area'] == '' || data['area'] == undefined) {
            $('#area').addClass('error');
            toastMsg('Area', 'Invalid Area', 'error');
            flag = 1;

        }
        if (data['plan_date'] == '' || data['plan_date'] == undefined) {
            $('#plan_date').addClass('error');
            toastMsg('Plan Date', 'Invalid Plan Date', 'error');
            flag = 1;

        }
        if (data['participant_gender_type'] == '' || data['participant_gender_type'] == undefined) {
            $('#participant_gender_type').addClass('error');
            toastMsg('Participant Gender Type', 'Invalid Participant Gender Type', 'error');
            flag = 1;

        }
        if (data['session_type'] == '' || data['session_type'] == undefined) {
            $('#session_type').addClass('error');
            toastMsg('Camp Type', 'Invalid Camp Type', 'error');
            flag = 1;

        }
        if ((data['session_type_other'] == '' || data['session_type_other'] == undefined) && data['session_type'] == 'Other') {
            $('#session_type_other').addClass('error');
            toastMsg('Camp Type Other', 'Invalid Camp Type Other', 'error');
            flag = 1;

        }

        if (flag == 0) {
            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Camp_CM/Community_mobilization/addCM'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    $('#addModal').modal('hide');
                    setTimeout(function () {
                        window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Community_mobilization?d=' + data['dist_id'] + '&u=' + data['ucCode'];
                    }, 500);
                } else if (result == 2) {
                    $('#dist_id').addClass('error');
                    toastMsg('District', 'Invalid District', 'error');
                } else if (result == 3) {
                    $('#ucCode').addClass('error');
                    toastMsg('UC', 'Invalid UC', 'error');
                } else if (result == 5) {
                    $('#Community_mobilization_rounds').addClass('error');
                    toastMsg('Camp', 'Invalid Camp', 'error');
                } else if (result == 6) {
                    $('#session_type').addClass('error');
                    toastMsg('Camp Type', 'Invalid Camp Type', 'error');
                } else if (result == 7) {
                    toastMsg('Plan Date', 'Invalid Plan Date', 'error');
                    $('#plan_date').addClass('error');
                } else if (result == 8) {
                    $('#Mobilizer').addClass('error');
                    toastMsg('Error', 'Community_mobilization not added', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getEdit(obj) {
        var id = $(obj).parent('td').attr('data-id');
        var campno = $(obj).parent('td').attr('data-campno');
        var edit_hiddenplan_date = $(obj).attr('data-hiddenplandate');
        $('.mypickadat_execution').pickadate({
            destroy: true,
            stop: true,
            reset: true,
            start: true,
            selectYears: true,
            selectMonths: true,
            min: new Date(2021, 2, 1),
            max: true,
            format: 'dd-mm-yyyy'
        }).stop();
        $('#edit_idCommunity_mobilization').val(id);
        $('#edit_session_no').val(campno);
        $('#edit_hiddenplan_date').val(edit_hiddenplan_date);
        changeUC_mobilizer('Mobilizer');
        $('#editModal').modal('show');
    }

    function editData() {
        $('#editModal').find('.error').removeClass('error');
        var flag = 0;
        var data = {};
        data['idCommunity_mobilization'] = $('#edit_idCommunity_mobilization').val();
        data['dist_id'] = $('#district_select').val();
        data['ucCode'] = $('#ucs_select').val();
        data['session_no'] = $('#edit_session_no').val();
        data['camp_status'] = $('#camp_status').val();
        data['execution_date'] = $('#execution_date').val();
        data['remarks'] = $('#remarks').val();

        if (data['idCommunity_mobilization'] == '' || data['idCommunity_mobilization'] == undefined || data['idCommunity_mobilization'].length < 1) {
            flag = 1;
            toastMsg('Community Mobilization', 'Invalid Community Mbilization', 'error');

        }
        if (data['camp_status'] == '' || data['camp_status'] == undefined || data['camp_status'].length < 1) {
            $('#camp_status').addClass('error');
            toastMsg('Status', 'Invalid Status', 'error');
            flag = 1;

        }
        if ((data['execution_date'] == '' || data['execution_date'] == undefined || data['execution_date'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#execution_date').addClass('error');
            toastMsg('Execution Date', 'Invalid Execution Date', 'error');
            flag = 1;
        }

        if ((data['remarks'] == '' || data['remarks'] == undefined || data['remarks'].length < 1) && data['camp_status'] == 'Canceled') {
            $('#remarks').addClass('error');
            toastMsg('Remarks', 'Invalid Remarks', 'error');
            flag = 1;

        }

        data['Mobilizer'] = $('#Mobilizer').val();
        if ((data['Mobilizer'] == '' || data['Mobilizer'] == undefined || data['Mobilizer'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#Mobilizer').addClass('error');
            toastMsg('Mobilizer', 'Invalid Mobilizer', 'error');
            flag = 1;

        }

        data['venue'] = $('#venue').val();
        data['venue_other'] = $('#venue_other').val();
        if ((data['venue'] == '' || data['venue'] == undefined || data['venue'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#venue').addClass('error');
            toastMsg('Venue', 'Invalid Venue', 'error');
            flag = 1;

        }

        data['session_topic'] = $('#session_topic').val();
        if ((data['session_topic'] == '' || data['session_topic'] == undefined || data['session_topic'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#session_topic').addClass('error');
            toastMsg('Session Topic', 'Invalid Session Topic', 'error');
            flag = 1;

        }

        data['session_topic_other'] = $('#session_topic_other').val();
        if ((data['session_topic_other'] == '' || data['session_topic_other'] == undefined || data['session_topic_other'].length < 1) && data['camp_status'] == 'Conducted'
            && data['session_topic'] == 'Other') {
            $('#session_topic_other').addClass('error');
            toastMsg('Session Topic Other', 'Invalid Session Topic Other', 'error');
            flag = 1;

        }


        data['total_male'] = $('#total_male').val();
        if ((data['total_male'] == '' || data['total_male'] == undefined || data['total_male'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#total_male').addClass('error');
            toastMsg('Total Male Participants', 'Invalid Total Male Participants', 'error');
            flag = 1;

        }

        data['total_female'] = $('#total_female').val();
        if ((data['total_female'] == '' || data['total_female'] == undefined || data['total_female'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#total_female').addClass('error');
            toastMsg('Total Female Participants', 'Invalid Total Female Participants', 'error');
            flag = 1;

        }

        var total = parseInt(data['total_male']) + parseInt(data['total_female']);

        data['political_com_leaders'] = $('#political_com_leaders').val();
        if ((data['political_com_leaders'] == '' || data['political_com_leaders'] == undefined || data['political_com_leaders'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#political_com_leaders').addClass('error');
            toastMsg('Political Leader', 'Invalid Political Leader', 'error');
            flag = 1;

        }

        data['religious_com_leaders'] = $('#religious_com_leaders').val();
        if ((data['religious_com_leaders'] == '' || data['religious_com_leaders'] == undefined || data['religious_com_leaders'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#religious_com_leaders').addClass('error');
            toastMsg('Religious Leader', 'Invalid Religious Leader', 'error');
            flag = 1;

        }

        data['educational_com_leaders'] = $('#educational_com_leaders').val();
        if ((data['educational_com_leaders'] == '' || data['educational_com_leaders'] == undefined || data['educational_com_leaders'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#educational_com_leaders').addClass('error');
            toastMsg('Educational Leader', 'Invalid Educational Leader', 'error');
            flag = 1;

        }

        data['businessman_com_leaders'] = $('#businessman_com_leaders').val();
        if ((data['businessman_com_leaders'] == '' || data['businessman_com_leaders'] == undefined || data['businessman_com_leaders'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#businessman_com_leaders').addClass('error');
            toastMsg('Businessman Leader', 'Invalid Businessman Leader', 'error');
            flag = 1;

        }
        data['other_com_leaders'] = $('#other_com_leaders').val();
        if ((data['other_com_leaders'] == '' || data['other_com_leaders'] == undefined || data['other_com_leaders'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#other_com_leaders').addClass('error');
            toastMsg('Other Community Leader', 'Other Community Leader', 'error');
            flag = 1;

        }

        data['doctors_health_provider'] = $('#doctors_health_provider').val();
        if ((data['doctors_health_provider'] == '' || data['doctors_health_provider'] == undefined || data['doctors_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#doctors_health_provider').addClass('error');
            toastMsg('Doctors', 'Invalid Doctors Health Care Providers', 'error');
            flag = 1;

        }

        data['paramedics_health_provider'] = $('#paramedics_health_provider').val();
        if ((data['paramedics_health_provider'] == '' || data['paramedics_health_provider'] == undefined || data['paramedics_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#paramedics_health_provider').addClass('error');
            toastMsg('Paramedics', 'Invalid Paramedics Health Care Providers', 'error');
            flag = 1;

        }

        data['lhws_health_provider'] = $('#lhws_health_provider').val();
        if ((data['lhws_health_provider'] == '' || data['lhws_health_provider'] == undefined || data['lhws_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#lhws_health_provider').addClass('error');
            toastMsg('LHWs', 'Invalid LHWs Health Care Providers', 'error');
            flag = 1;

        }

        data['lhvs_health_provider'] = $('#lhvs_health_provider').val();
        if ((data['lhvs_health_provider'] == '' || data['lhvs_health_provider'] == undefined || data['lhvs_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#lhvs_health_provider').addClass('error');
            toastMsg('LHVs', 'Invalid LHVs Health Care Providers', 'error');
            flag = 1;

        }

        data['cmws_health_provider'] = $('#cmws_health_provider').val();
        if ((data['cmws_health_provider'] == '' || data['cmws_health_provider'] == undefined || data['cmws_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#cmws_health_provider').addClass('error');
            toastMsg('CMWs', 'Invalid CMWs Health Care Providers', 'error');
            flag = 1;

        }

        data['vaccinators_health_provider'] = $('#vaccinators_health_provider').val();
        if ((data['vaccinators_health_provider'] == '' || data['vaccinators_health_provider'] == undefined || data['vaccinators_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#vaccinators_health_provider').addClass('error');
            toastMsg('Vaccinators', 'Invalid Vaccinators Health Care Providers', 'error');
            flag = 1;

        }
        data['other_health_provider'] = $('#other_health_provider').val();
        if ((data['other_health_provider'] == '' || data['other_health_provider'] == undefined || data['other_health_provider'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#other_health_provider').addClass('error');
            toastMsg('Other Health Facility Provider', 'Invalid Other Health Facility Provider', 'error');
            flag = 1;

        }

        data['fcv_government_officials'] = $('#fcv_government_officials').val();
        if ((data['fcv_government_officials'] == '' || data['fcv_government_officials'] == undefined || data['fcv_government_officials'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#fcv_government_officials').addClass('error');
            toastMsg('FCV', 'Invalid FCV Officials', 'error');
            flag = 1;

        }

        data['ucpw_government_officials'] = $('#ucpw_government_officials').val();
        if ((data['ucpw_government_officials'] == '' || data['ucpw_government_officials'] == undefined || data['ucpw_government_officials'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#ucpw_government_officials').addClass('error');
            toastMsg('UCPW', 'Invalid UCPW Officials', 'error');
            flag = 1;

        }

        data['ttsp_government_officials'] = $('#ttsp_government_officials').val();
        if ((data['ttsp_government_officials'] == '' || data['ttsp_government_officials'] == undefined || data['ttsp_government_officials'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#ttsp_government_officials').addClass('error');
            toastMsg('TTSP', 'Invalid TTSP Officials', 'error');
            flag = 1;

        }

        data['other_government_officials'] = $('#other_government_officials').val();
        if ((data['other_government_officials'] == '' || data['other_government_officials'] == undefined || data['other_government_officials'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#other_government_officials').addClass('error');
            toastMsg('Other Government', 'Invalid Other Government Officials', 'error');
            flag = 1;

        }

        data['other_participants'] = $('#other_participants').val();
        if ((data['other_participants'] == '' || data['other_participants'] == undefined || data['other_participants'].length < 1) && data['camp_status'] == 'Conducted') {
            $('#other_participants').addClass('error');
            toastMsg('Other Officials', 'Invalid Other Government Officials', 'error');
            flag = 1;

        }

        var community_leaders = parseInt(data['political_com_leaders']) +
            parseInt(data['religious_com_leaders']) +
            parseInt(data['educational_com_leaders']) +
            parseInt(data['businessman_com_leaders']) +
            parseInt(data['other_com_leaders']) +
            parseInt(data['doctors_health_provider']) +
            parseInt(data['paramedics_health_provider']) +
            parseInt(data['lhws_health_provider']) +
            parseInt(data['lhvs_health_provider']) +
            parseInt(data['cmws_health_provider']) +
            parseInt(data['vaccinators_health_provider']) +
            parseInt(data['other_health_provider']) +
            parseInt(data['fcv_government_officials']) +
            parseInt(data['ucpw_government_officials']) +
            parseInt(data['ttsp_government_officials']) +
            parseInt(data['other_government_officials']) +
            parseInt(data['other_participants']);
        if (community_leaders > total && data['camp_status'] == 'Conducted') {
            $('#political_com_leaders').addClass('error');
            $('#religious_com_leaders').addClass('error');
            $('#educational_com_leaders').addClass('error');
            $('#businessman_com_leaders').addClass('error');
            $('#other_com_leaders').addClass('error');
            $('#doctors_health_provider').addClass('error');
            $('#paramedics_health_provider').addClass('error');
            $('#lhws_health_provider').addClass('error');
            $('#lhvs_health_provider').addClass('error');
            $('#cmws_health_provider').addClass('error');
            $('#vaccinators_health_provider').addClass('error');
            $('#other_health_provider').addClass('error');
            $('#fcv_government_officials').addClass('error');
            $('#ucpw_government_officials').addClass('error');
            $('#ttsp_government_officials').addClass('error');
            $('#other_government_officials').addClass('error');
            $('#other_participants').addClass('error');
            toastMsg('Error', 'Community Leaders must not be greater than total male and female', 'error');
            flag = 1;
        }

        if (flag === 0) {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Community_mobilization/editData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#editModal').modal('hide');
                    toastMsg('Community_mobilization', 'Successfully Updated', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Community_mobilization', 'Invalid Community_mobilization', 'error');
                } else if (res == 3) {
                    $('#camp_status').addClass('error');
                    toastMsg('Status', 'Invalid Status', 'error');
                } else if (res == 4) {
                    $('#execution_date').addClass('error');
                    toastMsg('Execution Date', 'Invalid Execution Date', 'error');
                } else if (res == 5) {
                    $('#remarks').addClass('error');
                    toastMsg('Remarks', 'Invalid Remarks/Reasons', 'error');
                } else if (res == 6) {
                    $('#Mobilizer').addClass('error');
                    toastMsg('Mobilizer', 'Invalid Mobilizer', 'error');
                } else if (res == 7) {
                    $('#venue').addClass('error');
                    toastMsg('Venue', 'Invalid Venue', 'error');
                } else if (res == 8) {
                    $('#session_topic').addClass('error');
                    toastMsg('Session Topic', 'InvalidSession Topic', 'error');
                } else if (res == 9) {
                    $('#total_male').addClass('error');
                    toastMsg('Total Male', 'Invalid Total Male', 'error');
                } else if (res == 10) {
                    $('#total_female').addClass('error');
                    toastMsg('Total Female', 'Invalid Total Female', 'error');
                } else {
                    toastMsg('Community_mobilization', 'Something went wrong', 'error');
                }
            });
        }
    }

    function getLock(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#lock_idCommunity_mobilization').val(id);
        $('#lockModal').modal('show');
    }

    function lockData() {
        var data = {};
        data['idCommunity_mobilization'] = $('#lock_idCommunity_mobilization').val();
        if (data['idCommunity_mobilization'] == '' || data['idCommunity_mobilization'] == undefined || data['idCommunity_mobilization'] == 0) {
            toastMsg('Community_mobilization', 'Something went wrong', 'error');

        } else {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Community_mobilization/lockData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#lockModal').modal('hide');
                    toastMsg('Community Mobilization', 'Successfully Locked', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Error', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Error', 'Invalid Community Mobilization', 'error');
                }

            });
        }
    }

    function getDelete(obj) {
        var id = $(obj).parent('td').attr('data-id');
        $('#delete_idCommunity_mobilization').val(id);
        $('#deleteModal').modal('show');
    }

    function deleteData() {
        var data = {};
        data['idCommunity_mobilization'] = $('#delete_idCommunity_mobilization').val();
        if (data['idCommunity_mobilization'] == '' || data['idCommunity_mobilization'] == undefined || data['idCommunity_mobilization'] == 0) {
            toastMsg('Community Mobilization', 'Something went wrong', 'error');

        } else {
            CallAjax('<?php echo base_url('index.php/Camp_CM/Community_mobilization/deleteData')?>', data, 'POST', function (res) {
                if (res == 1) {
                    $('#deleteModal').modal('hide');
                    toastMsg('Community_mobilization', 'Successfully Deleted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else if (res == 2) {
                    toastMsg('Error', 'Something went wrong', 'error');
                } else if (res == 3) {
                    toastMsg('Error', 'Invalid Community Mobilization', 'error');
                }

            });
        }
    }

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: new Date(2021, 2, 1),
            max: new Date(2021, 11, 31),
            format: 'dd-mm-yyyy'
        });
    }

    function changeDistrict(dist, uc, filter) {
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        var items = '<option value="0" disabled readonly="">UCs</option>';
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                if (filter == 1) {
                    items = '<option value="0" disabled >Select All</option>';
                }
                var dist = $('#hidden_slug_ucs').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.ucCode + '"  ' + (dist == v.ucCode || response.length == 1 ? 'selected' : '') + '>' + v.ucName + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + uc).html('').html(items);
                changeUC('ucs_select', 'area', 1);
            });
        } else {
            $('#' + uc).html('').html(items);
        }
    }

    function changeUC(uc, area, filter) {
        var data = {};
        data['uc'] = $('#' + uc).val();
        data['filter'] = 0;
        if (data['uc'] != '' && data['uc'] != undefined && data['uc'] != '0' && data['uc'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Camp_CM/Camp/getAreaByUCs'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly selected>Location</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.area_no + '">' + v.area_name + ' (' + v.area_no + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + area).html('').html(items);
            });
        } else {
            $('#' + area).html('');
        }
    }

    function changeUC_mobilizer(doctor) {
        var flag = 0;
        var data = {};
        data['district'] = $('#district_select').val();
        data['ucs'] = $('#ucs_select').val();
        if (data['district'] == '' || data['district'] == undefined || data['district'] == '0' || data['district'] == '$1') {
            toastMsg('District', 'Invalid District', 'error');
            flag = 1;
        }
        if (data['ucs'] == '' || data['ucs'] == undefined || data['ucs'] == '0' || data['ucs'] == '$1') {
            toastMsg('UC', 'Invalid UC', 'error');
            flag = 1;
        } else {
            CallAjax('<?php echo base_url() . 'index.php/Camp_CM/Community_mobilization/getMobByUcs'  ?>', data, 'POST', function (res) {
                var items = '<option value="0" disabled readonly>Mobilizer</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.idDoctor + '">' + v.staff_name + ' (' + v.staff_type + ')</option>';
                        })
                    } catch (e) {
                    }
                }
                $('#' + doctor).html('').html(items);
            });
        }
    }

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        if (district == '' || district == undefined || district == '0' || district == '$1') {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            if (ucs == '' || ucs == undefined || ucs == '0') {
                ucs = '';
            }
            window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Community_mobilization?d=' + district + '&u=' + ucs;
        }
    }

</script>