<?php

class Camp_status extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcamp');
        $this->load->model('mlinelisting');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {

        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View Camp Status", "activityName" => "Camp Status",
            "result" => "View Camp_status Main page. URL: " . current_url() . " .  Fucntion: Camp_status/index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

        $district = '';
        $uc = '';
        $level = 1;

        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $uc = $_SESSION['login']['district'];
        }

        $MCamp = new MCamp();

        $getClustersProvince = $MCamp->getDist($district, $uc);
        $dist_array = array();
        foreach ($getClustersProvince as $k => $v) {
            $dist_id = $v->dist_id;
            $dist_array['Total'][$dist_id]['camps'] = 0;
            $dist_array['Total'][$dist_id]['ucCode'] = $v->dist_id;
            $dist_array['Total'][$dist_id]['ucName'] = $v->district;

            $dist_array['Conducted'][$dist_id]['camps'] = 0;
            $dist_array['Conducted'][$dist_id]['ucCode'] = $v->dist_id;
            $dist_array['Conducted'][$dist_id]['ucName'] = $v->district;

            $dist_array['Remaining'][$dist_id]['camps'] = 0;
            $dist_array['Remaining'][$dist_id]['ucCode'] = $v->dist_id;
            $dist_array['Remaining'][$dist_id]['ucName'] = $v->district;
        }

        /*==============Camp List==============*/

        $totalCamps = $MCamp->totalCampsByDict($district, $uc, '1', '');
        $Total = 0;
        foreach ($totalCamps as $k => $r) {
            $Total += $r->totalCamps;
            $dis = $r->dist_id;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Total'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $ConductedCamps = $MCamp->totalCampsByDict($district, $uc, '2', '');
        $Conducted = 0;
        foreach ($ConductedCamps as $k => $r) {
            $Conducted += $r->totalCamps;
            $dis = $r->dist_id;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Conducted'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $RemainingCamps = $MCamp->totalCampsByDict($district, $uc, '3', '');
        $Remaining = 0;
        foreach ($RemainingCamps as $k => $r) {
            $Remaining += $r->totalCamps;
            $dis = $r->dist_id;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Remaining'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $data['graphdata']['total'] = $Total;
        $data['graphdata']['Conducted'] = $Conducted;
        $data['graphdata']['Remaining'] = $Remaining;
        $data['graphdata']['list'] = $dist_array;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/camp_status', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function camp_status_ucs()
    {

        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View Camp Status", "activityName" => "Camp Status",
            "result" => "View Camp_status Main page. URL: " . current_url() . " .  Fucntion: Camp_status/index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

        $district = '';
        $uc = '';

        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
        }

        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1 && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $uc = $_SESSION['login']['district'];
        }

        $MCamp = new MCamp();

        $getClustersProvince = $MCamp->getDistUC($district, $uc);
        $dist_array = array();
        foreach ($getClustersProvince as $k => $v) {
            $dist_id = $v->ucCode;
            $dist_array['Total'][$dist_id]['camps'] = 0;
            $dist_array['Total'][$dist_id]['ucCode'] = $v->ucCode;
            $dist_array['Total'][$dist_id]['ucName'] = $v->ucName;

            $dist_array['Conducted'][$dist_id]['camps'] = 0;
            $dist_array['Conducted'][$dist_id]['ucCode'] = $v->ucCode;
            $dist_array['Conducted'][$dist_id]['ucName'] = $v->ucName;

            $dist_array['Remaining'][$dist_id]['camps'] = 0;
            $dist_array['Remaining'][$dist_id]['ucCode'] = $v->ucCode;
            $dist_array['Remaining'][$dist_id]['ucName'] = $v->ucName;
        }

        /*==============Camp List==============*/

        $totalCamps = $MCamp->totalCamps($district, $uc, '1', '');
        $Total = 0;
        foreach ($totalCamps as $k => $r) {
            $Total += $r->totalCamps;
            $dis = $r->ucCode;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Total'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $ConductedCamps = $MCamp->totalCamps($district, $uc, '2', '');
        $Conducted = 0;
        foreach ($ConductedCamps as $k => $r) {
            $Conducted += $r->totalCamps;
            $dis = $r->ucCode;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Conducted'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $RemainingCamps = $MCamp->totalCamps($district, $uc, '3', '');
        $Remaining = 0;
        foreach ($RemainingCamps as $k => $r) {
            $Remaining += $r->totalCamps;
            $dis = $r->ucCode;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Remaining'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $LockedCamps = $MCamp->totalCamps($district, $uc, '', '1');
        $Locked = 0;
        foreach ($LockedCamps as $k => $r) {
            $Locked += $r->totalCamps;
            $dis = $r->ucCode;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Locked'][$dis]['camps'] += $r->totalCamps;
                }
            }
        }

        $data['graphdata']['total'] = $Total;
        $data['graphdata']['Conducted'] = $Conducted;
        $data['graphdata']['Remaining'] = $Remaining;
        $data['graphdata']['Locked'] = $Locked;
        $data['graphdata']['list'] = $dist_array;
        /*==============Visitors==============*/

        $total_v = array();
        $total_v['Overall'] = 0;
        $totalVisitors = $MCamp->visitors_status($district, $uc, '', 'total');
        if (isset($totalVisitors) && $totalVisitors != '') {
            foreach ($totalVisitors as $totV) {
                if (isset($totV->ucName) && $totV->ucName != '') {
                    $total_v[$totV->ucName]['totalVisitors'] = $totV->totalVisitors;
                    $total_v[$totV->ucName]['ucName'] = $totV->ucName;
                    $total_v[$totV->ucName]['ucCode'] = $totV->ucCode;
                    $total_v['Overall'] += $totV->totalVisitors;
                }
            }
        }
        $data['totalVisitors'] = $total_v;

        /*==============Children==============*/
        $total_children = array();
        $total_children['Overall'] = 0;
        $totalChildren = $MCamp->visitors_status($district, $uc, '', 'u5');
        if (isset($totalChildren) && $totalChildren != '') {
            foreach ($totalChildren as $totChildren) {
                if (isset($totChildren->ucName) && $totChildren->ucName != '') {
                    $total_children[$totChildren->ucName]['totalVisitors'] = $totChildren->totalVisitors;
                    $total_children[$totChildren->ucName]['ucName'] = $totChildren->ucName;
                    $total_children[$totChildren->ucName]['ucCode'] = $totChildren->ucCode;
                    $total_children['Overall'] += $totChildren->totalVisitors;
                }
            }
        }
        $data['totalChildren'] = $total_children;

        /*==============WRA==============*/
        $total_wra = array();
        $total_wra['Overall'] = 0;
        $totalwra = $MCamp->visitors_status($district, $uc, '', 'wra');
        if (isset($totalwra) && $totalwra != '') {
            foreach ($totalwra as $totwra) {
                if (isset($totwra->ucName) && $totwra->ucName != '') {
                    $total_wra[$totwra->ucName]['totalVisitors'] = $totwra->totalVisitors;
                    $total_wra[$totwra->ucName]['ucName'] = $totwra->ucName;
                    $total_wra[$totwra->ucName]['ucCode'] = $totwra->ucCode;
                    $total_wra['Overall'] += $totwra->totalVisitors;
                }
            }
        }
        $data['totalWRA'] = $total_wra;

        /*==============Other==============*/
        $total_other = array();
        $total_other['Overall'] = 0;
        $totalother = $MCamp->visitors_status($district, $uc, '', 'others');
        if (isset($totalother) && $totalother != '') {
            foreach ($totalother as $totother) {
                if (isset($totother->ucName) && $totother->ucName != '') {
                    $total_other[$totother->ucName]['totalVisitors'] = $totother->totalVisitors;
                    $total_other[$totother->ucName]['ucName'] = $totother->ucName;
                    $total_other[$totother->ucName]['ucCode'] = $totother->ucCode;
                    $total_other['Overall'] += $totother->totalVisitors;
                }
            }
        }
        $data['totalother'] = $total_other;


        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/camp_status_ucs', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function status_children()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Children Status status_children", "activityName" => "Camp Status - status_children",
                "result" => "View Camp status_children Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_children()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;
            $MCamp = new MCamp();

            $totalChildren = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'u5');
            $data['totalChildren'] = $totalChildren;

            $immunized = $MCamp->children($data['slug_district'], $uc, $area, 'immunized');
            $data['immunized'] = $immunized;

            $anthro = $MCamp->children($data['slug_district'], $uc, $area, 'anthro');
            $data['anthro'] = $anthro;

            $examine = $MCamp->children($data['slug_district'], $uc, $area, 'examine');
            $data['examine'] = $examine;

            $medi_prescibed = $MCamp->children($data['slug_district'], $uc, $area, 'medi_prescibed');
            $data['medi_prescibed'] = $medi_prescibed;
            /*   echo '<pre>';
                        print_r($totalChildren);
                        echo '<pre>';
                        exit();*/
            if (isset($uc) && $uc != '') {
                $data['myData'] = $MCamp->camps_health_summary($data['slug_district'], $uc, $area);
            }

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_children', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function status_children_immunization()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Children Status status_children_immunization", "activityName" => "Camp Status - status_children_immunization",
                "result" => "View Camp status_children Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_children_immunization()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;
            $MCamp = new MCamp();

            $totalChildren = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'u5');
            $data['totalChildren'] = $totalChildren;

            $immunized = $MCamp->children($data['slug_district'], $uc, $area, 'immunized');
            $data['immunized'] = $immunized;


            if (isset($uc) && $uc != '') {
                $data['myData'] = $MCamp->camps_health_summary_child($data['slug_district'], $uc, $area, 'immunization', 'u5');
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_children_immunization', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function status_children_anthro()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Children Status status_children_anthro", "activityName" => "Camp Status - status_children_anthro",
                "result" => "View Camp status_children_anthro Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_children_anthro()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;
            $MCamp = new MCamp();

            $totalChildren = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'u5');
            $data['totalChildren'] = $totalChildren;

            $anthro = $MCamp->children($data['slug_district'], $uc, $area, 'anthro');
            $data['anthro'] = $anthro;


            if (isset($uc) && $uc != '') {
                $data['myData'] = $MCamp->camps_health_summary_child($data['slug_district'], $uc, $area, 'anthro', 'u5');
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_children_anthro', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function status_children_examine()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Children Status status_children_examine", "activityName" => "Camp Status - status_children_examine",
                "result" => "View Camp status_children_examine Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_children_examine()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;
            $MCamp = new MCamp();

            $totalChildren = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'u5');
            $data['totalChildren'] = $totalChildren;

            $examine = $MCamp->children($data['slug_district'], $uc, $area, 'examine');
            $data['examine'] = $examine;

            if (isset($uc) && $uc != '') {
                $data['myData'] = $MCamp->camps_health_summary_child($data['slug_district'], $uc, $area, 'examine', 'u5');
                $data['children_top_deseases'] = $MCamp->children_top_deseases($data['slug_district'], $uc, $area);
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_children_examine', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function status_children_medi_prescibed()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Children Medi status_children_medi_prescibed", "activityName" => "Camp Status - status_children_medi_prescibed",
                "result" => "View Camp status_children_medi_prescibed Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_children_medi_prescibed()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;
            $MCamp = new MCamp();

            $totalChildren = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'u5');
            $data['totalChildren'] = $totalChildren;

            $examine = $MCamp->children($data['slug_district'], $uc, $area, 'medi_prescibed');
            $data['medi_prescibed'] = $examine;

            if (isset($uc) && $uc != '') {
                $data['myData'] = $MCamp->camps_health_summary_child($data['slug_district'], $uc, $area, 'medi_prescibed', 'u5');
                $data['medi_prescibed_data'] = $MCamp->children_top_medi_prescibed($data['slug_district'], $uc, $area);
            }
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_children_medi_prescibed', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function status_visitors()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Status Total Visitors", "activityName" => "Camp Status - status_visitors",
                "result" => "View Camp Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_visitors()");
            $MCustom->trackLogs($trackarray, "user_logs");


            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'index.php/Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;

            $MCamp = new MCamp();

            $total_visitors = $MCamp->visitors_status($data['slug_district'], $uc, $area, '');
            $data['total_visitors'] = $total_visitors;

            $male = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'male');
            $data['male'] = $male;

            $female = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'female');
            $data['female'] = $female;

            $wra = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'wra');
            $data['wra'] = $wra;

            /* $mwra = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'mwra');
             $data['mwra'] = $mwra;*/

            $u5 = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'u5');
            $data['u5'] = $u5;

            if (isset($area) && $area != '') {
                $data['myData'] = $MCamp->camps_form_status($data['slug_district'], $uc, $area);
            }

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_visitors', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function status_wra()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp WRA Status status_wra", "activityName" => "Camp Status - status_wra",
                "result" => "View Camp status_wra Status page. URL: " . current_url() . " .  Fucntion: Camp_status/status_wra()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;
            $MCamp = new MCamp();

            $totalWRA = $MCamp->visitors_status($data['slug_district'], $uc, $area, 'wra');
            $data['totalWRA'] = $totalWRA;

            $anc_checkup = $MCamp->wra($data['slug_district'], $uc, $area, 'anc_checkup');
            $data['anc_checkup'] = $anc_checkup;

            $tetanus = $MCamp->wra($data['slug_district'], $uc, $area, 'tetanus');
            $data['tetanus'] = $tetanus;

            $physical_examine = $MCamp->wra($data['slug_district'], $uc, $area, 'physical_examine');
            $data['physical_examine'] = $physical_examine;

            $medi_prescibed = $MCamp->wra($data['slug_district'], $uc, $area, 'medi_prescibed');
            $data['medi_prescibed'] = $medi_prescibed;

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/status_wra', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

    function camp_immunized_status2()
    {
        if (isset($_GET['uc']) && $_GET['uc'] != '') {
            $MCustom = new Custom();
            $trackarray = array("action" => "View Camp Status mwra_anc", "activityName" => "Camp Status - mwra_anc",
                "result" => "View Camp mwra_anc Status page. URL: " . current_url() . " .  Fucntion: Camp_status/camp_mwra_anc_status()");
            $MCustom->trackLogs($trackarray, "user_logs");

            $data = array();
            $MSettings = new MSettings();
            $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Camp_status');

            $ucs = '';
            $area = '';
            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
                $ucs = $_SESSION['login']['district'];
            }

            if (isset($_GET['a']) && $_GET['a'] != '') {
                $area = $_GET['a'];
            }
            $district = $MCustom->getDistricts($ucs);
            $data['district'] = $district;
            $uc = $_GET['uc'];
            $data['slug_district'] = substr($uc, 0, 3);
            $data['slug_ucs'] = $uc;
            $data['slug_area'] = $area;

            $MCamp = new MCamp();

            $Vaccines_By_Antigen = $MCamp->immunized($data['slug_district'], $uc, $area, 'Vaccines_By_Antigen');
            $data['Vaccines_By_Antigen'] = $Vaccines_By_Antigen;

            $height = $MCamp->immunized($data['slug_district'], $uc, $area, 'height');
            $data['height'] = $height;

            $weight = $MCamp->immunized($data['slug_district'], $uc, $area, 'weight');
            $data['weight'] = $weight;

            $muac = $MCamp->immunized($data['slug_district'], $uc, $area, 'muac');
            $data['muac'] = $muac;

            $Vaccination_not_Reported = $MCamp->immunized($data['slug_district'], $uc, $area, 'Vaccination_not_Reported');
            $data['Vaccination_not_Reported'] = $Vaccination_not_Reported;

            if (isset($uc) && $uc != '') {
                $data['myData'] = $MCamp->camps_health_summary($data['slug_district'], $uc, $area);
            }

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('camp_cm/camp_immunized_status', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');

        } else {
            echo '';
        }

    }

}

?>