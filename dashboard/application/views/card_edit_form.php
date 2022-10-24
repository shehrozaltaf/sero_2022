<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/extensions/swiper.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins/extensions/swiper.css">

<style>
    .img-fluid {
        width: 100%;
    }

    .my-table-bordered tr, th, td, .my-table-bordered thead th {
        border: 1px solid black;
    }

    .child_name {
        text-transform: capitalize;
    }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Card Edit Form</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Card Edit</li>
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
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <?php
                                    $img = '';
                                    if ((isset($data->f01) && $data->f01 != '') || (isset($data->f02) && $data->f02 != '')) {
                                        $img = '<div class="swiper-slide">
                                                        <img class="img-fluid"
                                                             src="https://vcoe1.aku.edu/sero_2022/api/uploads/' . $data->f01 . '"
                                                             alt="' . $data->f01 . '">
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <img class="img-fluid"
                                                             src="https://vcoe1.aku.edu/sero_2022/api/uploads/' . $data->f02 . '"
                                                             alt="' . $data->f02 . '">
                                                    </div>';
                                    } else {
                                        $img = '<div class="swiper-slide"><p>No Image found</p></div>';
                                    } ?>
                                    <div class="swiper-gallery swiper-container gallery-top">
                                        <div class="swiper-wrapper gallery_images">
                                            <?php echo $img; ?>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                    <div class="swiper-container gallery-thumbs">
                                        <div class="swiper-wrapper mt-25 gallery_images">
                                            <?php echo $img; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="cluster_code" class="label-control ">Cluster</label>
                                                <input type="text" class="form-control" required id="cluster_code"
                                                       name="cluster_code" readonly disabled
                                                       value="<?php echo(isset($data->cluster_code) && $data->cluster_code != '' ? $data->cluster_code : '') ?>">


                                                <input type="hidden" class="form-control" required id="ec"
                                                       name="ec" readonly disabled
                                                       value="<?php echo(isset($ec) && $ec != '' ? $ec : '1') ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="hhno" class="label-control ">hhno</label>
                                                <input type="text" class="form-control" required id="hhno"
                                                       name="hhno" readonly disabled
                                                       value="<?php echo(isset($data->hhno) && $data->hhno != '' ? $data->hhno : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ec14" class="label-control ">Child Name</label>
                                                <input type="text" class="form-control" required id="ec14"
                                                       name="ec14" readonly disabled
                                                       value="<?php echo(isset($data->ec14) && $data->ec14 != '' ? $data->ec14 : '') ?>">
                                            </div>
                                        </div>
                                        <?php
                                        if ($data->ec15 == 1) {
                                            $gender = 'Male';
                                        } else if ($data->ec15 == 2) {
                                            $gender = 'Female';
                                        } else {
                                            $gender = '';
                                        }
                                        ?>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ec15" class="label-control ">Gender</label>
                                                <input type="text" class="form-control" required id="ec15"
                                                       name="ec15" readonly disabled
                                                       value="<?php echo $gender; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ec13" class="label-control ">Child No</label>
                                                <input type="text" class="form-control" required id="ec13"
                                                       name="ec13" readonly disabled
                                                       value="<?php echo(isset($data->ec13) && $data->ec13 != '' ? $data->ec13 : '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="dob" class="label-control ">DoB</label>
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->dob_val) && $data->dob_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="dob" name="dob"
                                                    <?php echo(isset($data->dob_val) && $data->dob_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo $data->im04dd . '-' . $data->im04mm . '-' . $data->im04yy; ?>">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="bcg" class="label-control ">BCG</label>
                                                <span class="bcg_parent">
                                                    <input type="text"
                                                           class="form-control <?php echo(isset($data->bcg0_val) && $data->bcg0_val == 2 ? 'mypickadat' : ''); ?>"
                                                           required id="bcg"
                                                           name="bcg"
                                                           <?php echo(isset($data->bcg0_val) && $data->bcg0_val == 2 ? '' : 'readonly disabled'); ?>
                                                           value="<?php echo(isset($data->bcg) && $data->bcg != '' ? $data->bcg : '') ?>">
                                                </span>
                                                <?php if (isset($data->bcg0_val) && $data->bcg0_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="bcg_checklist" data-id="bcg"
                                                               data-val="<?php echo(isset($data->bcg) && $data->bcg != '' ? $data->bcg : '') ?>"
                                                               value="1" id="bcg_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="bcg_checklist_other" data-id="bcg"
                                                               data-val="<?php echo(isset($data->bcg) && $data->bcg != '' ? $data->bcg : '') ?>"
                                                               value="98" id="bcg_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>

                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="opv0" class="label-control ">opv0</label>
                                                <span class="opv0_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->opv0_val) && $data->opv0_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="opv0"
                                                       name="opv0"
                                                    <?php echo(isset($data->opv0_val) && $data->opv0_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->opv0) && $data->opv0 != '' ? $data->opv0 : '') ?>">
                                                </span>
                                                <?php if (isset($data->opv0_val) && $data->opv0_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="opv0_checklist" data-id="opv0"
                                                               data-val="<?php echo(isset($data->opv0) && $data->opv0 != '' ? $data->bcg : '') ?>"
                                                               value="1" id="opv0_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="opv0_checklist_other"
                                                               data-id="opv0"
                                                               data-val="<?php echo(isset($data->opv0) && $data->opv0 != '' ? $data->opv0 : '') ?>"
                                                               value="98" id="opv0_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="opv1" class="label-control ">opv1</label>
                                                <span class="opv1_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->opv1_val) && $data->opv1_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="opv1"
                                                       name="opv1"
                                                    <?php echo(isset($data->opv1_val) && $data->opv1_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->opv1) && $data->opv1 != '' ? $data->opv1 : '') ?>">
                                                </span>
                                                <?php if (isset($data->opv1_val) && $data->opv1_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="opv1_checklist" data-id="opv1"
                                                               data-val="<?php echo(isset($data->opv1) && $data->opv1 != '' ? $data->opv1 : '') ?>"
                                                               value="1" id="opv1_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="opv1_checklist_other"
                                                               data-id="opv1"
                                                               data-val="<?php echo(isset($data->opv1) && $data->opv1 != '' ? $data->opv1 : '') ?>"
                                                               value="98" id="opv1_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="hep_b" class="label-control ">hep b</label>
                                                <span class="hep_b_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->hep_b_val) && $data->hep_b_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required
                                                       id="hep_b" name="hep_b"
                                                    <?php echo(isset($data->hep_b_val) && $data->hep_b_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->hep_b) && $data->hep_b != '' ? $data->hep_b : '') ?>">
                                                </span>
                                                <?php if (isset($data->hep_b_val) && $data->hep_b_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="hep_b_checklist" data-id="hep_b"
                                                               data-val="<?php echo(isset($data->hep_b) && $data->hep_b != '' ? $data->hep_b : '') ?>"
                                                               value="1" id="hep_b_checklist"
                                                               onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="hep_b_checklist_other"
                                                               data-id="hep_b"
                                                               data-val="<?php echo(isset($data->hep_b) && $data->hep_b != '' ? $data->hep_b : '') ?>"
                                                               value="98" id="hep_b_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="opv2" class="label-control ">opv2</label>
                                                <span class="opv2_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->opv2_val) && $data->opv2_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="opv2"
                                                       name="opv2"
                                                    <?php echo(isset($data->opv2_val) && $data->opv2_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->opv2) && $data->opv2 != '' ? $data->opv2 : '') ?>">
                                                </span>
                                                <?php if (isset($data->opv2_val) && $data->opv2_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="opv2_checklist" data-id="opv2"
                                                               data-val="<?php echo(isset($data->opv2) && $data->opv2 != '' ? $data->opv2 : '') ?>"
                                                               value="1" id="opv2_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="opv2_checklist_other"
                                                               data-id="opv2"
                                                               data-val="<?php echo(isset($data->opv2) && $data->opv2 != '' ? $data->opv2 : '') ?>"
                                                               value="98" id="opv2_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="opv3" class="label-control ">opv3</label>
                                                <span class="opv3_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->opv3_val) && $data->opv3_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="opv3"
                                                       name="opv3"
                                                    <?php echo(isset($data->opv3_val) && $data->opv3_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->opv3) && $data->opv3 != '' ? $data->opv3 : '') ?>">
                                                </span>
                                                <?php if (isset($data->opv3_val) && $data->opv3_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="opv3_checklist" data-id="opv3"
                                                               data-val="<?php echo(isset($data->opv3) && $data->opv3 != '' ? $data->opv3 : '') ?>"
                                                               value="1" id="opv3_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="opv3_checklist_other"
                                                               data-id="opv3"
                                                               data-val="<?php echo(isset($data->opv3) && $data->opv3 != '' ? $data->opv3 : '') ?>"
                                                               value="98" id="opv3_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="penta1" class="label-control ">penta1</label>
                                                <span class="penta1_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->penta1_val) && $data->penta1_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="penta1"
                                                       name="penta1"
                                                    <?php echo(isset($data->penta1_val) && $data->penta1_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->penta1) && $data->penta1 != '' ? $data->penta1 : '') ?>">
                                                </span>
                                                <?php if (isset($data->penta1_val) && $data->penta1_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="penta1_checklist" data-id="penta1"
                                                               data-val="<?php echo(isset($data->penta1) && $data->penta1 != '' ? $data->penta1 : '') ?>"
                                                               value="1" id="penta1_checklist"
                                                               onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="penta1_checklist_other"
                                                               data-id="penta1"
                                                               data-val="<?php echo(isset($data->penta1) && $data->penta1 != '' ? $data->penta1 : '') ?>"
                                                               value="98" id="penta1_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="penta2" class="label-control ">penta2</label>
                                                <span class="penta2_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->penta2_val) && $data->penta2_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="penta2"
                                                       name="penta2"
                                                    <?php echo(isset($data->penta2_val) && $data->penta2_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->penta2) && $data->penta2 != '' ? $data->penta2 : '') ?>">
                                                </span>
                                                <?php if (isset($data->penta2_val) && $data->penta2_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="penta2_checklist" data-id="penta2"
                                                               value="1" id="penta2_checklist"
                                                               data-val="<?php echo(isset($data->penta2) && $data->penta2 != '' ? $data->penta2 : '') ?>"
                                                               onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="penta2_checklist_other"
                                                               data-id="penta2"
                                                               data-val="<?php echo(isset($data->penta2) && $data->penta2 != '' ? $data->penta2 : '') ?>"
                                                               value="98" id="penta2_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="penta3" class="label-control ">penta3</label>
                                                <span class="penta3_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->penta3_val) && $data->penta3_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="penta3"
                                                       name="penta3"
                                                    <?php echo(isset($data->penta3_val) && $data->penta3_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->penta3) && $data->penta3 != '' ? $data->penta3 : '') ?>">
                                                </span>
                                                <?php if (isset($data->penta3_val) && $data->penta3_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="penta3_checklist" data-id="penta3"
                                                               data-val="<?php echo(isset($data->penta3) && $data->penta3 != '' ? $data->penta3 : '') ?>"
                                                               value="1" id="penta3_checklist"
                                                               onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="penta3_checklist_other"
                                                               data-id="penta3"
                                                               data-val="<?php echo(isset($data->penta3) && $data->penta3 != '' ? $data->penta3 : '') ?>"
                                                               value="98" id="penta3_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="pcv" class="label-control ">pcv1</label>
                                                <span class="pcv_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->pcv1_val) && $data->pcv1_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="pcv"
                                                       name="pcv"
                                                    <?php echo(isset($data->pcv1_val) && $data->pcv1_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->pcv) && $data->pcv != '' ? $data->pcv : '') ?>">
                                                </span>
                                                <?php if (isset($data->pcv1_val) && $data->pcv1_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="pcv_checklist" data-id="pcv"
                                                               data-val="<?php echo(isset($data->pcv) && $data->pcv != '' ? $data->pcv : '') ?>"
                                                               value="1" id="pcv_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="pcv_checklist_other" data-id="pcv"
                                                               data-val="<?php echo(isset($data->pcv) && $data->pcv != '' ? $data->pcv : '') ?>"
                                                               value="98" id="pcv_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="pcv2" class="label-control ">pcv2</label>
                                                <span class="pcv2_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->pcv2_val) && $data->pcv2_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="pcv2"
                                                       name="pcv2"
                                                    <?php echo(isset($data->pcv2_val) && $data->pcv2_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->pcv2) && $data->pcv2 != '' ? $data->pcv2 : '') ?>">
                                                </span>
                                                <?php if (isset($data->pcv2_val) && $data->pcv2_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="pcv2_checklist" data-id="pcv2"
                                                               data-val="<?php echo(isset($data->pcv2) && $data->pcv2 != '' ? $data->pcv2 : '') ?>"
                                                               value="1" id="pcv2_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="pcv2_checklist_other"
                                                               data-id="pcv2"
                                                               data-val="<?php echo(isset($data->pcv2) && $data->pcv2 != '' ? $data->pcv2 : '') ?>"
                                                               value="98" id="pcv2_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="pcv3" class="label-control ">pcv3</label>
                                                <span class="pcv3_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->pcv3_val) && $data->pcv3_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="pcv3"
                                                       name="pcv3"
                                                    <?php echo(isset($data->pcv3_val) && $data->pcv3_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->pcv3) && $data->pcv3 != '' ? $data->pcv3 : '') ?>">
                                                </span>
                                                <?php if (isset($data->pcv3_val) && $data->pcv3_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="pcv3_checklist" data-id="pcv3"
                                                               data-val="<?php echo(isset($data->pcv3) && $data->pcv3 != '' ? $data->pcv3 : '') ?>"
                                                               value="1" id="pcv3_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="pcv3_checklist_other"
                                                               data-id="pcv3"
                                                               data-val="<?php echo(isset($data->pcv3) && $data->pcv3 != '' ? $data->pcv3 : '') ?>"
                                                               value="98" id="pcv3_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="rv1" class="label-control ">rv1</label>
                                                <span class="rv1_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->rv1_val) && $data->rv1_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="rv1"
                                                       name="rv1"
                                                    <?php echo(isset($data->rv1_val) && $data->rv1_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->rv1) && $data->rv1 != '' ? $data->rv1 : '') ?>">
                                                </span>
                                                <?php if (isset($data->rv1_val) && $data->rv1_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="rv1_checklist" data-id="rv1"
                                                               data-val="<?php echo(isset($data->rv1) && $data->rv1 != '' ? $data->rv1 : '') ?>"
                                                               value="1" id="rv1_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="rv1_checklist_other" data-id="rv1"
                                                               data-val="<?php echo(isset($data->rv1) && $data->rv1 != '' ? $data->rv1 : '') ?>"
                                                               value="98" id="rv1_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="rv2" class="label-control ">rv2</label>
                                                <span class="rv2_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->rv2_val) && $data->rv2_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="rv2"
                                                       name="rv2"
                                                    <?php echo(isset($data->rv2_val) && $data->rv2_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->rv2) && $data->rv2 != '' ? $data->rv2 : '') ?>">
                                                </span>
                                                <?php if (isset($data->rv2_val) && $data->rv2_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="rv2_checklist" data-id="rv2"
                                                               data-val="<?php echo(isset($data->rv2) && $data->rv2 != '' ? $data->rv2 : '') ?>"
                                                               value="1" id="rv2_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="rv2_checklist_other" data-id="rv2"
                                                               data-val="<?php echo(isset($data->rv2) && $data->rv2 != '' ? $data->rv2 : '') ?>"
                                                               value="98" id="rv2_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ipv" class="label-control ">ipv 1</label>
                                                <span class="ipv_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->ipv0_val) && $data->ipv0_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required id="ipv"
                                                       name="ipv"
                                                    <?php echo(isset($data->ipv0_val) && $data->ipv0_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->ipv) && $data->ipv != '' ? $data->ipv : '') ?>">
                                                </span>
                                                <?php if (isset($data->ipv0_val) && $data->ipv0_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="ipv_checklist" data-id="ipv"
                                                               data-val="<?php echo(isset($data->ipv) && $data->ipv != '' ? $data->ipv : '') ?>"
                                                               value="1" id="ipv_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="ipv_checklist_other" data-id="ipv"
                                                               data-val="<?php echo(isset($data->ipv) && $data->ipv != '' ? $data->ipv : '') ?>"
                                                               value="98" id="ipv_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="measles1" class="label-control ">measles1</label>
                                                <span class="measles1_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->measles1_val) && $data->measles1_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required
                                                       id="measles1" name="measles1"
                                                    <?php echo(isset($data->measles1_val) && $data->measles1_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->measles1) && $data->measles1 != '' ? $data->measles1 : '') ?>">
                                                </span>
                                                <?php if (isset($data->measles1_val) && $data->measles1_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="measles1_checklist"
                                                               data-id="measles1"
                                                               data-val="<?php echo(isset($data->measles1) && $data->measles1 != '' ? $data->measles1 : '') ?>"
                                                               value="1" id="measles1_checklist"
                                                               onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="measles1_checklist_other"
                                                               data-id="measles1"
                                                               data-val="<?php echo(isset($data->measles1) && $data->measles1 != '' ? $data->measles1 : '') ?>"
                                                               value="98" id="measles1_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="measles2" class="label-control ">measles2</label>
                                                <span class="measles2_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->measles2_val) && $data->measles2_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required
                                                       id="measles2" name="measles2"
                                                    <?php echo(isset($data->measles2_val) && $data->measles2_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->measles2) && $data->measles2 != '' ? $data->measles2 : '') ?>">
                                                </span>
                                                <?php if (isset($data->measles2_val) && $data->measles2_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="measles2_checklist"
                                                               data-id="measles2"
                                                               data-val="<?php echo(isset($data->measles2) && $data->measles2 != '' ? $data->measles2 : '') ?>"
                                                               value="1" id="measles2_checklist"
                                                               onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="measles2_checklist_other"
                                                               data-id="measles2"
                                                               data-val="<?php echo(isset($data->measles2) && $data->measles2 != '' ? $data->measles2 : '') ?>"
                                                               value="98" id="measles2_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="ipv2" class="label-control ">ipv 2</label>
                                                <span class="ipv2_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->ipv2_val) && $data->ipv2_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required
                                                       id="ipv2" name="ipv2"
                                                    <?php echo(isset($data->ipv2_val) && $data->ipv2_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->ipv2) && $data->ipv2 != '' ? $data->ipv2 : '') ?>">
                                                </span>
                                                <?php if (isset($data->ipv2_val) && $data->ipv2_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="ipv2_checklist" data-id="ipv2"
                                                               data-val="<?php echo(isset($data->ipv2) && $data->ipv2 != '' ? $data->ipv2 : '') ?>"
                                                               value="1" id="ipv2_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="ipv2_checklist_other"
                                                               data-id="ipv2"
                                                               data-val="<?php echo(isset($data->ipv2) && $data->ipv2 != '' ? $data->ipv2 : '') ?>"
                                                               value="98" id="ipv2_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="tcv" class="label-control ">tcv</label>
                                                <span class="tcv_parent">
                                                <input type="text"
                                                       class="form-control <?php echo(isset($data->tcv_val) && $data->tcv_val == 2 ? 'mypickadat' : ''); ?>"
                                                       required
                                                       id="tcv" name="tcv"
                                                    <?php echo(isset($data->tcv_val) && $data->tcv_val == 2 ? '' : 'readonly disabled'); ?>
                                                       value="<?php echo(isset($data->tcv) && $data->tcv != '' ? $data->tcv : '') ?>">
                                                </span>
                                                <?php if (isset($data->tcv_val) && $data->tcv_val == 2) { ?>
                                                    <span class="danger small">Change Code
                                                        <input type="checkbox" name="tcv_checklist" data-id="tcv"
                                                               data-val="<?php echo(isset($data->tcv) && $data->tcv != '' ? $data->tcv : '') ?>"
                                                               value="1" id="tcv_checklist" onclick="changeType(this)">
                                                    </span><br>
                                                    <span class="danger small">Vaccinator Error
                                                        <input type="checkbox" name="tcv_checklist_other" data-id="tcv"
                                                               data-val="<?php echo(isset($data->tcv) && $data->tcv != '' ? $data->tcv : '') ?>"
                                                               value="98" id="tcv_checklist_other"
                                                               onclick="changeOther(this)">
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12 col-12 ">
                                            <button type="button" class="btn btn-primary" onclick="addata()">
                                                Insert Data
                                            </button>
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
<input type="hidden" id="hidden_loginUser"
       value="<?php echo(isset($_SESSION['login']['UserName']) && $_SESSION['login']['UserName'] != '' ? $_SESSION['login']['UserName'] : 0) ?>">

<script src="<?php echo base_url() ?>assets/vendors/js/extensions/swiper.min.js"></script>
<script>

    $(document).ready(function () {
        gallery();
        pickaDate();
    });

    function pickaDate() {
        $('.mypickadat').pickadate({
            editable: true,
            selectYears: true,
            selectMonths: true,
            max: [2022,11,31],
            disable: [
                [2020, 7, 1],
                [2020, 8, 28]
            ],
            format: 'dd-mm-yyyy'
        });
    }

    function changeType(obj) {
        var items = '';
        var id = $(obj).attr('data-id');
        var myval = $(obj).attr('data-val');
        var key = $('#' + id + '_checklist');
        if ($(key).is(":checked")) {
            items += '<select class="select2 form-control" required id="' + id + '" name="' + id + '">' +
                '<option value="0" selected disabled readonly="">Select</option>' +
                '<option value="44">44</option>' +
                '<option value="66">66</option>' +
                '<option value="88">88</option>' +
                '<option value="97">97</option>' +
                '</select>';
            $('.' + id + '_parent').html('').val('').html(items);
        } else {
            items += '<input type="text" class="form-control mypickadat" required id="' + id + '" name="' + id + '"  value="' + myval + '">';
            $('.' + id + '_parent').html('').val('').html(items);
            setTimeout(function () {
                pickDate();
            }, 500);
        }
    }

    function changeOther(obj) {
        var items = '';
        var id = $(obj).attr('data-id');
        var myval = $(obj).attr('data-val');
        var key = $('#' + id + '_checklist_other');
        if ($(key).is(":checked")) {
            items += '<input type="text" class="form-control mypickadat" required id="' + id + '" name="' + id + '" value="' + myval + '">';
            $('.' + id + '_parent').html('').val('').html(items);
            $('#' + id).attr('readonly', 'readonly').attr('disabled', 'disabled');
            $('#' + id + '_checklist').prop("checked", false).attr('readonly', 'readonly').attr('disabled', 'disabled');
        } else {
            $('#' + id).removeAttr('readonly').removeAttr('disabled');
            $('#' + id + '_checklist').removeAttr('readonly').removeAttr('disabled');
            setTimeout(function () {
                pickDate();
            }, 500);
        }
    }

    function gallery() {
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            zoom: true,
            pagination: {
                el: '.swiper-pagination',
            },
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
        setTimeout(function () {
            pickDate();
        }, 500);
    }


    function addata() {
        var data = {};
        data['cluster_code'] = $('#cluster_code').val();
        data['hhno'] = $('#hhno').val();
        data['ec'] = $('#ec').val();
        data['dob'] = $('#dob').val();

        data['bcg'] = $('#bcg').val();
        data['bcg_check'] = ($('#bcg_checklist_other').is(":checked") ? 98 : 0);
        data['opv0'] = $('#opv0').val();
        data['opv0_check'] = ($('#opv0_checklist_other').is(":checked") ? 98 : 0);
        data['opv1'] = $('#opv1').val();
        data['opv1_check'] = ($('#opv1_checklist_other').is(":checked") ? 98 : 0);
        data['opv2'] = $('#opv2').val();
        data['opv2_check'] = ($('#opv2_checklist_other').is(":checked") ? 98 : 0);
        data['opv3'] = $('#opv3').val();
        data['opv3_check'] = ($('#opv3_checklist_other').is(":checked") ? 98 : 0);
        data['penta1'] = $('#penta1').val();
        data['penta1_check'] = ($('#penta1_checklist_other').is(":checked") ? 98 : 0);
        data['penta2'] = $('#penta2').val();
        data['penta2_check'] = ($('#penta2_checklist_other').is(":checked") ? 98 : 0);
        data['penta3'] = $('#penta3').val();
        data['penta3_check'] = ($('#penta3_checklist_other').is(":checked") ? 98 : 0);
        data['pcv'] = $('#pcv').val();
        data['pcv_check'] = ($('#pcv_checklist_other').is(":checked") ? 98 : 0);
        data['pcv2'] = $('#pcv2').val();
        data['pcv2_check'] = ($('#pcv2_checklist_other').is(":checked") ? 98 : 0);
        data['pcv3'] = $('#pcv3').val();
        data['pcv3_check'] = ($('#pcv3_checklist_other').is(":checked") ? 98 : 0);
        data['rv1'] = $('#rv1').val();
        data['rv1_check'] = ($('#rv1_checklist_other').is(":checked") ? 98 : 0);
        data['rv2'] = $('#rv2').val();
        data['rv2_check'] = ($('#rv2_checklist_other').is(":checked") ? 98 : 0);
        data['ipv'] = $('#ipv').val();
        data['ipv_check'] = ($('#ipv_checklist_other').is(":checked") ? 98 : 0);
        data['measles1'] = $('#measles1').val();
        data['measles1_check'] = ($('#measles1_checklist_other').is(":checked") ? 98 : 0);
        data['measles2'] = $('#measles2').val();
        data['measles2_check'] = ($('#measles2_checklist_other').is(":checked") ? 98 : 0);
        data['hep_b'] = $('#hep_b').val();
        data['hep_b_check'] = ($('#hep_b_checklist_other').is(":checked") ? 98 : 0);
        data['ipv2'] = $('#ipv2').val();
        data['ipv2_check'] = ($('#ipv2_checklist_other').is(":checked") ? 98 : 0);
        data['tcv'] = $('#tcv').val();
        data['tcv_check'] = ($('#tcv_checklist_other').is(":checked") ? 98 : 0);
        var vd = validateData(data);
        if (vd) {

            showloader();
            $('.mybtn').attr('disabled', 'disabled');
            CallAjax('<?php echo base_url('index.php/Card_edit/addForm'); ?>', data, 'POST', function (result) {
                hideloader();
                if (result == 1) {
                    toastMsg('Success', 'Successfully inserted', 'success');
                } else if (result == 2) {
                    toastMsg('Error', 'Invalid Cluster', 'error');
                } else if (result == 3) {
                    toastMsg('Error', 'Invalid Household', 'error');
                } else if (result == 6) {
                    toastMsg('Error', 'Invalid Cluster & Household information', 'error');
                } else {
                    toastMsg('Error', 'Something went wrong', 'error');
                }
            });
        } else {
            toastMsg('Page', 'Something went wrong', 'error');
        }
    }
</script>