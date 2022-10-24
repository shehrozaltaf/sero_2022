<!-- BEGIN: Content-->
<style>
    table td {
        border: 1px solid black !important;
        padding: 5px !important;

    }

    .mainRow {
        width: 35%;
        word-wrap: break-word;
    }

    .SecondaryRow {
        width: 10%;
        word-wrap: break-word;
    }

    .b {
        font-weight: bold;
    }

    .r {
        text-align: right;
        font-weight: bold;
    }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Health Camps Report</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Health Camps Report</li>
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
                                        <div class="col-sm-4 col-12">
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
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                UC
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control ucs_select" id="ucs_select"
                                                        onchange="changeUC('ucs_select','area_select',1)">
                                                    <option value="0" readonly disabled selected>UC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Area
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control area_select" id="area_select">
                                                    <option value="0" readonly disabled selected>Area</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary" onclick="searchData()">Get
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
            <?php if (isset($slug_district) && $slug_district != '' && $slug_district != 0) { ?>

                <section id="column-selectors">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Health Camps Reporting</h4>
                                    <div class="col-sm-12 col-md-12 col-lg-12 float-right text-right">
                                        <button class="btn btn-primary btn-print mb-1 mb-md-0 waves-effect waves-light myprintBtn">
                                            <i class="feather icon-file-text"></i>
                                            Print
                                        </button>
                                        <button class="btn btn-outline-primary  ml-0 ml-md-1 waves-effect waves-light myDownloadBtn">
                                            <i class="feather icon-download"></i>
                                            Download
                                        </button>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">

                                        <div>
                                            <table class="table printcontent ">
                                                <tbody>
                                                <tr>
                                                    <td colspan="4" class="mainRow b text-center"><h4>SHRUC-Health Camp Report</h4></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="mainRow r">District</td>
                                                    <td class="SecondaryRow"><?php echo(isset($dist_name) && $dist_name != '' ? $dist_name : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="mainRow r">UC</td>
                                                    <td class="SecondaryRow"><?php echo(isset($ucName) && $ucName != '' ? $ucName : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="mainRow r">Camp number</td>
                                                    <td class="SecondaryRow"><?php echo(isset($camp_no) && $camp_no != '' ? $camp_no : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="mainRow r">Date of Health Camp</td>
                                                    <td class="SecondaryRow"><?php echo(isset($execution_date) && $execution_date != '' ? date('d-m-Y', strtotime($execution_date)) : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="mainRow r">Venue of Health Camp</td>
                                                    <td class="SecondaryRow"><?php echo(isset($execution_duration) && $execution_duration != '' ? $execution_duration : '-') ?></td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="16" class="mainRow b">Beneficiaries Basic Curative
                                                        (Medical Reasons)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Number from <2 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u2ym) && $u2ym != '' ? $u2ym : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u2yf) && $u2yf != '' ? $u2yf : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Number from 2-5 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u24mm) && $u24mm != '' ? $u24mm : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u24mf) && $u24mf != '' ? $u24mf : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Number from 5-14 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u60mm) && $u60mm != '' ? $u60mm : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u60mf) && $u60mf != '' ? $u60mf : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Number of Patients above 14 yrs</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u14m) && $u14m != '' ? $u14m : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($u14f) && $u14f != '' ? $u14f : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Total Beneficiaries for Basic
                                                        Curative
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($totmale) && $totmale != '' ? $totmale : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($totfemale) && $totfemale != '' ? $totfemale : '-') ?></td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="9" class="mainRow b">Routine immunization given to
                                                        number of Target age Children & Women (Preventive)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Total Number of Children given any
                                                        type of Routine Immunization
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($givenroutinem) && $givenroutinem != '' ? $givenroutinem : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($givenroutinef) && $givenroutinef != '' ? $givenroutinef : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" class="mainRow">Number of Women given TT</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Total</td>
                                                    <td class="SecondaryRow"><?php echo(isset($givenTT) && $givenTT != '' ? $givenTT : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow"># of Zero Dose Routine given any
                                                        vaccine (Below two year children among the total RI)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($zeroRIu2m) && $zeroRIu2m != '' ? $zeroRIu2m : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($zeroRIu2m) && $zeroRIu2m != '' ? $zeroRIu2m : '-') ?></td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="4" class="mainRow b">Polio SIA Benificiary</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow">Number of children below 5 Yrs given
                                                        OPV only
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($siam) && $siam != '' ? $siam : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($siaf) && $siaf != '' ? $siaf : '-') ?></td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="5" class="mainRow b">MNCH</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" class="mainRow"># of Women provided Antenatal</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Total</td>
                                                    <td class="SecondaryRow"><?php echo(isset($anc) && $anc != '' ? $anc : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" class="mainRow"># of Referrals to higher level Health Facility</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Total</td>
                                                    <td class="SecondaryRow"><?php echo(isset($referals) && $referals != '' ? $referals : '-') ?></td>
                                                </tr>


                                                <tr>
                                                    <td rowspan="7" class="mainRow b">IMNCI</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow"># of children provided ORS/Zinc</td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($ors_zincm) && $ors_zincm != '' ? $ors_zincm : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($ors_zincf) && $ors_zincf != '' ? $ors_zincf : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" class="mainRow"># of Children receiving
                                                        Amoxicilin/treatment for Pneumonia or respiratory tract
                                                        infections
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Male</td>
                                                    <td class="SecondaryRow"><?php echo(isset($amoxm) && $amoxm != '' ? $amoxm : '-') ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Female</td>
                                                    <td class="SecondaryRow"><?php echo(isset($amoxf) && $amoxf != '' ? $amoxf : '-') ?></td>
                                                </tr>

                                                <tr>
                                                    <td rowspan="3" class="mainRow b">Refferal Slip</td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" class="mainRow">Total number of beneficaries visited
                                                        health camp along with refferal slips
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="SecondaryRow">Total</td>
                                                    <td class="SecondaryRow"><?php echo(isset($refslip) && $refslip != '' ? $refslip : '-') ?></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3" class="mainRow r">Total Beneficiaries</td>
                                                    <td class="SecondaryRow"><?php echo(isset($tot) && $tot != '' ? $tot : '-') ?></td>
                                                </tr>
                                                </tbody>
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
<script type="text/JavaScript" src="<?php echo base_url() ?>assets/js/scripts/extensions/invoice.js"></script>
<script type="text/JavaScript" src="<?php echo base_url() ?>assets/js/scripts/extensions/jspdf.min.js"></script>
<script>

    $(document).ready(function () {
        changeDistrict('district_select', 'ucs_select', 1);
        $(".myprintBtn").click(function () {
            $(".printcontent").print();
        });

        $('.myDownloadBtn').click(function () {
            let pdf = new jsPDF();
            let section = $('.printcontent');
            let page = function () {
                pdf.save('shruc_health_camp_report.pdf');
            };
            pdf.addHTML(section, page);
        });
    });


    function changeDistrict(dist, uc, filter) {
        var data = {};
        data['district'] = $('#' + dist).val();
        data['arms'] = 1;
        var items = '<option value="0" disabled readonly="">UCs</option>';
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getUCsByDistrict'  ?>', data, 'POST', function (res) {
                if (filter == 1) {
                    items = '<option value="0" disabled>Select All</option>';
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
                changeUC('ucs_select', 'area_select', 1);
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
                var items = '<option value="0" disabled readonly="">Area</option>';
                if (filter == 1) {
                    items = '<option value="0">Select Area</option>';
                }
                var areas = $('#hidden_slug_area').val();
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.area_no + '"  ' + (areas == v.area_no || response.length == 1 ? 'selected' : '') + '>' + v.area_name + ' (' + v.area_no + ')</option>';
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

    function searchData() {
        var district = $('.district_select').val();
        var ucs = $('.ucs_select').val();
        var area = $('.area_select').val();
        if (district == '' || district == undefined || district == '0' || district == '$1') {
            toastMsg('District', 'Invalid District', 'error');
        } else {
            if (ucs == '' || ucs == undefined || ucs == '0') {
                ucs = '';
            }
            if (area == '' || area == undefined || area == '0') {
                area = '';
            }
            window.location.href = '<?php echo base_url() ?>index.php/Camp_CM/Health_camp_report?d=' + district + '&u=' + ucs + '&a=' + area;
        }
    }

</script>