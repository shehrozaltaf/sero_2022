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
                        <h2 class="content-header-title float-left mb-0">Manual Linelisting</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Manual Linelisting</li>
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
                                                Province
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control province_select" autocomplete="pro"
                                                        id="province_select"
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
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                District
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control district_select" autocomplete="dist"
                                                        id="district_select" onchange="changeDistrict()">
                                                    <option value="0" readonly disabled selected>District</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Cluster
                                            </div>
                                            <div class="form-group">
                                                <select class="select2 form-control clusters_select"
                                                        onchange="displayClusterBtn()" autocomplete="clus"
                                                        id="clusters_select">
                                                    <option value="0" readonly disabled selected>Cluster</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chkCluster_div">
                                        <p class="geoarea_name"></p>
                                        <button type="button" class="btn btn-info chkCluster_btn"
                                                onclick="chkCluster()">
                                            Check Cluster
                                        </button>
                                    </div>
                                    <div class="row nextDiv hide">
                                        <div class="col-sm-12 col-12">
                                            <div class="text-bold-600 font-medium-2">
                                                Number of Households (having 12-23 Months Children):
                                            </div>
                                            <div class="form-group">
                                                <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/"
                                                       onKeyPress="if(this.value.length==3) return false;"
                                                       class="form-control number_hh" id="number_hh"
                                                       minlength="1" min="1" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nextDiv hide ">
                                        <button type="button" class="btn btn-primary" onclick="searchData()">Set
                                            Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="analytics-card" class="my_card hide">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Linelisting</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card_html">

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
<input type="hidden" id="hidden_slug_cluster"
       value="<?php echo(isset($slug_cluster) && $slug_cluster != '' ? $slug_cluster : ''); ?>">

<script>
    $(document).ready(function () {
        changeProvince();
        mydate();
    });


    function displayClusterBtn() {
        $('.chkCluster_btn').removeClass('hide');
        $('.nextDiv').addClass('hide');
        $('.my_card').addClass('hide');
    }

    function chkCluster() {
        $('.my_card').addClass('hide');
        $('.card_html').html('');
        var flag = 0;

        var province_select = $('#province_select').val();
        if (province_select == '' || province_select == undefined || province_select == '0') {
            $('#province_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Province', 'Invalid Province', 'error');
            return false;
        }

        var district_select = $('#district_select').val();
        if (district_select == '' || district_select == undefined || district_select == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        var cluster_select = $('#clusters_select').val();
        if (cluster_select == '' || cluster_select == undefined || cluster_select == '0') {
            $('#clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        }
        if (flag == 0) {
            var data = {};
            data['cluster'] = cluster_select;
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getClustersData'  ?>', data, 'POST', function (res) {
                var items = 'Invalid Cluster';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        if (response[0].geoarea != undefined && response[0].geoarea != '') {
                            items = 'Cluster: ' + cluster_select + ' (Area: ' + response[0].geoarea + ')';
                        } else {
                            items = 'Invalid Cluster';
                        }

                    } catch (e) {
                    }
                }
                $('.geoarea_name').html('').html(items);
                $('.chkCluster_btn').addClass('hide');
                $('.nextDiv').removeClass('hide');
                mydate();
            });
        }
    }

    function changeProvince() {
        var data = {};
        data['province'] = $('.province_select').val();
        if (data['province'] != '' && data['province'] != undefined && data['province'] != '0' && data['province'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getDistrictByProvince'  ?>', data, 'POST', function (res) {
                var dist = $('#hidden_slug_dist').val();
                var items = '<option value="0"   readonly disabled ' + (dist == '' || dist == undefined ? 'selected' : '') + '>District</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.dist_id + '" onclick="changeDistrict()" ' + (dist == v.dist_id ? 'selected' : '') + '>' + v.district + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.district_select').html('').html(items);
                changeDistrict();
            });
        } else {
            $('.district_select').html('');
        }
    }

    function changeDistrict() {
        var data = {};
        data['district'] = $('.district_select').val();
        if (data['district'] != '' && data['district'] != undefined && data['district'] != '0' && data['district'] != '$1') {
            CallAjax('<?php echo base_url() . 'index.php/Dashboard/getClustersByDistrict'  ?>', data, 'POST', function (res) {
                var cluster = $('#hidden_slug_cluster').val();
                var items = '<option value="0"   readonly disabled  ' + (cluster == '' || cluster == undefined ? 'selected' : '') + '>Cluster</option>';
                if (res != '' && JSON.parse(res).length > 0) {
                    var response = JSON.parse(res);
                    try {
                        $.each(response, function (i, v) {
                            items += '<option value="' + v.cluster_no + '" ' + (cluster == v.cluster_no ? 'selected' : '') + '>' + v.cluster_no + '</option>';
                        })
                    } catch (e) {
                    }
                }
                $('.clusters_select').html('').html(items);
            });
        } else {
            $('.clusters_select').html('');
        }
    }

    function searchData() {
        $('.my_card').addClass('hide');
        $('.card_html').html('');
        var flag = 0;

        var province_select = $('#province_select').val();
        if (province_select == '' || province_select == undefined || province_select == '0') {
            $('#province_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Province', 'Invalid Province', 'error');
            return false;
        }

        var district_select = $('#district_select').val();
        if (district_select == '' || district_select == undefined || district_select == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        var cluster_select = $('#clusters_select').val();
        if (cluster_select == '' || cluster_select == undefined || cluster_select == '0') {
            $('#clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        }

        var number_hh = $('#number_hh').val();
        if (number_hh == '' || number_hh == undefined || number_hh == '0') {
            $('#number_hh').css('border', '1px solid red');
            flag = 1;
            toastMsg('Household Number', 'Invalid Household Number', 'error');
            return false;
        }

        if (flag == 0) {
            var html = '';
            html += '<div class="row">';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="total_structure_identified" class="label-control text-primary">Total Structure Identified</label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control  total_structure_identified" ' +
                'id="total_structure_identified" name="total_structure_identified"  autocomplete="structure_hh" required>' +
                '        </div>' +
                '    </div> ';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="total_household_identified" class="label-control text-primary">Total Household having 12-23 Months Children </label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"  minlength="1" min="1" class="form-control  total_household_identified"  autocomplete="total_hh" value="' + number_hh + '"  ' +
                'id="total_household_identified" name="total_household_identified" required  readonly disabled>' +
                '        </div>' +
                '    </div> ';

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="total_residential_structures" class="label-control text-primary">Total Residential Structures</label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"  minlength="1" min="1" class="form-control  total_residential_structures"  autocomplete="total_hs"  ' +
                'id="total_residential_structures" name="total_residential_structures" required>' +
                '        </div>' +
                '    </div> ';

            /*html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="household_targeted_children" class="label-control text-primary">Household With Targeted Children</label>' +
                '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"  minlength="1" min="1"  class="form-control household_targeted_children" value="2"   ' +
                'id="household_targeted_children" name="household_targeted_children" required>' +
                '        </div>' +
                '    </div> ';*/

            html += '<div class="col-sm-12 col-12"> ' +
                '       <div class="form-group">' +
                '            <label for="linelisting_date" class="label-control text-primary">Date of Linelisting </label>' +
                '            <input type="text" class="form-control mypickadat linelisting_date"  value="<?php echo date("d/m/Y")?>" ' +
                'id="linelisting_date" name="linelisting_date" required>' +
                '        </div>' +
                '    </div> ';


            html += '</div>';

            for (var i = 1; i <= number_hh; i++) {
                html += '<div class="row">';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '            <label for="structure_number" class="label-control text-primary">Structure Number</label>' +
                    '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control structure_number_' + i + '"  autocomplete="structure_number" id="structure_number_' + i + '"  required>' +
                    '        </div>' +
                    '    </div> ';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '            <label for="household_no" class="label-control text-primary">S.No of Household</label>' +
                    '            <input type="number" maxlength="3" max="3" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;" minlength="1" min="1" class="form-control household_no_' + i + '"   autocomplete="household_no" id="household_no_' + i + '"  required>' +
                    '        </div>' +
                    '    </div> ';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '            <label for="household_name_' + i + '" class="label-control text-primary">Name of Household</label>' +
                    '            <input type="text" class="form-control household_name_' + i + '" id="household_name_' + i + '"  autocomplete="name_hh" required>' +
                    '        </div>' +
                    '    </div> ';

                html += '<div class="col-sm-3 col-12"> ' +
                    '       <div class="form-group">' +
                    '              <label for="childAge_' + i + '" class="label-control text-primary">Total 12-23 months children</label>' +
                    '              <input type="number" maxlength="1" max="1" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;" minlength="1" min="1" class="form-control childAge_' + i + '"  autocomplete="childAge" id="childAge_' + i + '"  required>' +
                    '        </div>' +
                    '    </div> ';
                html += '</div>';


            }

            html += '<div class=" ">' +
                '<button type="button" class="btn btn-info" onclick="submitLineListing()">' +
                'Save Data</button>' +
                '</div>';
            html += '<div class="row"><div class="col-md-12 col-sm-12">' +
                '<p class="danger">Note: Please check data carefully before uploading it.</p>' +
                '</div></div>';

            $('.card_html').html(html);
            $('.my_card').removeClass('hide');
            mydate();
        }
    }

    function mydate() {
        $('.mypickadat').pickadate({
            selectYears: true,
            selectMonths: true,
            min: new Date(2019, 12, 1),
            max: true,
            format: 'dd-mm-yyyy'
        });
    }

    function submitLineListing() {
        var flag = 0;
        var data = {};
        data['total_structure_identified'] = $('#total_structure_identified').val();
        data['total_household_identified'] = $('#total_household_identified').val();
        data['total_residential_structures'] = $('#total_residential_structures').val();
        // data['household_targeted_children'] = $('#household_targeted_children').val();
        data['linelisting_date'] = $('#linelisting_date').val();

        data['province_select'] = $('#province_select').val();
        if (data['province_select'] == '' || data['province_select'] == undefined || data['province_select'] == '0') {
            $('#province_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Province', 'Invalid Province', 'error');
            return false;
        }

        data['district_select'] = $('#district_select').val();
        if (data['district_select'] == '' || data['district_select'] == undefined || data['district_select'] == '0') {
            $('#district_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('District', 'Invalid District', 'error');
            return false;
        }

        data['cluster_select'] = $('#clusters_select').val();
        if (data['cluster_select'] == '' || data['cluster_select'] == undefined || data['cluster_select'] == '0') {
            $('#clusters_select').css('border', '1px solid red');
            flag = 1;
            toastMsg('Cluster', 'Invalid Cluster', 'error');
            return false;
        }


        if (data['total_structure_identified'] == '' || data['total_structure_identified'] == undefined || data['total_structure_identified'] == 0) {
            flag = 1;
            $('#total_structure_identified').addClass('error');
            toastMsg('Structure Identified', 'Invalid Total Structure', 'error');
            return false;
        } else {
            $('#total_structure_identified').removeClass('error');
        }

        if (data['total_household_identified'] == '' || data['total_household_identified'] == undefined || data['total_household_identified'] == 0) {
            flag = 1;
            $('#total_household_identified').addClass('error');
            toastMsg('Household Identified', 'Invalid Household Identified', 'error');
            return false;
        } else {
            $('#total_household_identified').removeClass('error');
        }

        if (data['total_residential_structures'] == '' || data['total_residential_structures'] == undefined || data['total_residential_structures'] == 0) {
            flag = 1;
            $('#total_residential_structures').addClass('error');
            toastMsg('Residential Structure', 'Invalid Residential Structure', 'error');
            return false;
        } else {
            $('#total_residential_structures').removeClass('error');
        }

        /* if (data['household_targeted_children'] == '' || data['household_targeted_children'] == undefined) {
             flag = 1;
             $('#household_targeted_children').addClass('error');
             toastMsg('Targeted Children', 'Invalid Targeted Children', 'error');
             return false;
         } else {
             $('#household_targeted_children').removeClass('error');
         }*/

        if (data['linelisting_date'] == '' || data['linelisting_date'] == undefined) {
            flag = 1;
            $('#linelisting_date').addClass('error');
            toastMsg('Linelisting Data', 'Invalid Linelisting Data', 'error');
            return false;
        } else {
            $('#linelisting_date').removeClass('error');
        }

        /*if (data['total_structure_identified'] < data['total_household_identified']) {
            flag = 1;
            $('#total_household_identified').addClass('error');
            toastMsg('Household Identified', 'Household Identified is greater than Total Identified', 'error');
            return false;
        } else {
            $('#total_household_identified').removeClass('error');
        }*/

        /*  if (data['total_household_identified'] < data['household_targeted_children']) {
              flag = 1;
              $('#household_targeted_children').addClass('error');
              toastMsg('Household Targeted Children', 'Household Targeted Children is greater than Household Identified', 'error');
              return false;
          } else {
              $('#household_targeted_children').removeClass('error');
          }*/

        data["option"] = [];
        for (var i = 1; i <= data['total_household_identified']; i++) {
            var m = {};

            var structure_number_obj = $('#structure_number_' + i);
            var structure_number = structure_number_obj.val();
            if (structure_number != '' && structure_number != undefined && structure_number != 0) {
                m['structure_number'] = structure_number;
                structure_number_obj.removeClass('error');
            } else {
                flag = 1;
                structure_number_obj.addClass('error');
                toastMsg('Structure Number', 'Invalid Structure Number', 'error');
                return false;
            }

            var household_no_obj = $('#household_no_' + i);
            var household_no = household_no_obj.val();
            if (household_no != '' && household_no != undefined && household_no != 0) {
                m['household_no'] = household_no;
                household_no_obj.removeClass('error');
            } else {
                flag = 1;
                household_no_obj.addClass('error');
                toastMsg('Household Number', 'Invalid Household Number', 'error');
                return false;
            }

            var household_name_obj = $('#household_name_' + i);
            var household_name = household_name_obj.val();
            if (household_name != '' && household_name != undefined && household_name != 0) {
                m['household_name'] = household_name;
                household_name_obj.removeClass('error');
            } else {
                flag = 1;
                household_name_obj.addClass('error');
                toastMsg('Household Name', 'Invalid Household Name', 'error');
                return false;
            }

            var childAge_obj = $('#childAge_' + i);
            var childAge = childAge_obj.val();
            if (childAge != '' && childAge != undefined && childAge != 0) {
                m['childAge'] = childAge;
                childAge_obj.removeClass('error');
            } else {
                flag = 1;
                childAge_obj.addClass('error');
                toastMsg('Child Age', 'Invalid Count of 12-23 months children', 'error');
                return false;
            }

            data["option"].push(m);
        }

        if (flag == 0) {
            showloader();
            $('.mybtn').addClass('hide').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Manual_linelisting/insertData'); ?>', data, 'POST', function (result) {
                hideloader();
                $('.mybtn').removeClass('hide').removeAttr('disabled', 'disabled');
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else if (result == 2) {
                    toastMsg('Cluster', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    toastMsg('Error', 'Invalid Total Structure Identified', 'error');
                } else if (result == 4) {
                    toastMsg('Error', 'Invalid Total Household having 12-23 Months Children', 'error');
                } else if (result == 5) {
                    toastMsg('Error', 'Invalid Household Targeted Children', 'error');
                } else if (result == 6) {
                    toastMsg('Error', 'Invalid Linelisting Date', 'error');
                } else if (result == 7) {
                    toastMsg('Cluster', 'Cluster not found', 'error');
                } else if (result == 8) {
                    toastMsg('Error', 'Error in inserting', 'error');
                } else if (result == 10) {
                    toastMsg('Error', 'Error in Summary', 'error');
                } else if (result == 12) {
                    toastMsg('Error', 'Invalid Linelisting Date', 'error');
                } else if (result == 13) {
                    toastMsg('Error', 'Invalid Residential Structure', 'error');
                } else {
                    toastMsg('Error', 'Invalid went wrong', 'error');
                }
            });
        } else {
            toastMsg('Error', 'Invalid Data', 'error');
        }
    }

</script>