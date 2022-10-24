<?php

class Health_camp_report extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mhealth_camp_report');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $ucs = '';
        $area = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $ucs = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $trackarray = array("action" => "View Health Camps Report", "activityName" => "Camp Area - Health Camps Report",
            "result" => "View Health Camps Report page. URL: " . current_url() . " .  Fucntion: Health_camp_report/index()");
        $MCustom->trackLogs($trackarray, "user_logs");


        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;
        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
            $area = (isset($_GET['a']) && $_GET['a'] != '' && $_GET['a'] != '0' ? $_GET['a'] : '');
            $MHealth_camp_report = new MHealth_camp_report();

            $getCampDetail = $MHealth_camp_report->getCampDetail($district, $ucs, $area);
            $data['dist_name']= (isset($getCampDetail[0]->district) && $getCampDetail[0]->district != '' ? $getCampDetail[0]->district : '');
            if(isset($ucs) && $ucs != '' &&$ucs != '0'){
                $data['ucName']= (isset($getCampDetail[0]->ucName) && $getCampDetail[0]->ucName != '' ? $getCampDetail[0]->ucName : '');
            }

            if(isset($area) &&$area != '' && $area != '0'){
                $data['area_name']= (isset($getCampDetail[0]->area_name) && $getCampDetail[0]->area_name != '' ? $getCampDetail[0]->area_name : '');
                $data['camp_no']= (isset($getCampDetail[0]->camp_no) && $getCampDetail[0]->camp_no != '' ? $getCampDetail[0]->camp_no : '');
                $data['execution_date']= (isset($getCampDetail[0]->execution_date) && $getCampDetail[0]->execution_date != '' ? $getCampDetail[0]->execution_date : '');
                $data['execution_duration']= (isset($getCampDetail[0]->execution_duration) && $getCampDetail[0]->execution_duration != '' ? $getCampDetail[0]->execution_duration : '');
            }


            $u2ym = $MHealth_camp_report->getReport($district, $ucs, $area, 'u2ym');
            $data['u2ym'] = (isset($u2ym[0]->totalCnt) && $u2ym[0]->totalCnt != '' ? $u2ym[0]->totalCnt : '');

            $u2yf = $MHealth_camp_report->getReport($district, $ucs, $area, 'u2yf');
            $data['u2yf'] = (isset($u2yf[0]->totalCnt) && $u2yf[0]->totalCnt != '' ? $u2yf[0]->totalCnt : '');

            $u24mm = $MHealth_camp_report->getReport($district, $ucs, $area, 'u24mm');
            $data['u24mm'] = (isset($u24mm[0]->totalCnt) && $u24mm[0]->totalCnt != '' ? $u24mm[0]->totalCnt : '');

            $u24mf = $MHealth_camp_report->getReport($district, $ucs, $area, 'u24mf');
            $data['u24mf'] = (isset($u24mf[0]->totalCnt) && $u24mf[0]->totalCnt != '' ? $u24mf[0]->totalCnt : '');

            $u60mm = $MHealth_camp_report->getReport($district, $ucs, $area, 'u60mm');
            $data['u60mm'] = (isset($u60mm[0]->totalCnt) && $u60mm[0]->totalCnt != '' ? $u60mm[0]->totalCnt : '');

            $u60mf = $MHealth_camp_report->getReport($district, $ucs, $area, 'u60mf');
            $data['u60mf'] = (isset($u60mf[0]->totalCnt) && $u60mf[0]->totalCnt != '' ? $u60mf[0]->totalCnt : '');

            $u14m = $MHealth_camp_report->getReport($district, $ucs, $area, 'u14m');
            $data['u14m'] = (isset($u14m[0]->totalCnt) && $u14m[0]->totalCnt != '' ? $u14m[0]->totalCnt : '');

            $u14f = $MHealth_camp_report->getReport($district, $ucs, $area, 'u14f');
            $data['u14f'] = (isset($u14f[0]->totalCnt) && $u14f[0]->totalCnt != '' ? $u14f[0]->totalCnt : '');

            $totmale = $MHealth_camp_report->getReport($district, $ucs, $area, 'totmale');
            $data['totmale'] = (isset($totmale[0]->totalCnt) && $totmale[0]->totalCnt != '' ? $totmale[0]->totalCnt : '');

            $totmale = $MHealth_camp_report->getReport($district, $ucs, $area, 'totmale');
            $data['totmale'] = (isset($totmale[0]->totalCnt) && $totmale[0]->totalCnt != '' ? $totmale[0]->totalCnt : '');

            $totfemale = $MHealth_camp_report->getReport($district, $ucs, $area, 'totfemale');
            $data['totfemale'] = (isset($totfemale[0]->totalCnt) && $totfemale[0]->totalCnt != '' ? $totfemale[0]->totalCnt : '');

            $givenroutinem = $MHealth_camp_report->getReport($district, $ucs, $area, 'givenroutinem');
            $data['givenroutinem'] = (isset($givenroutinem[0]->totalCnt) && $givenroutinem[0]->totalCnt != '' ? $givenroutinem[0]->totalCnt : '');

            $givenroutinef = $MHealth_camp_report->getReport($district, $ucs, $area, 'givenroutinef');
            $data['givenroutinef'] = (isset($givenroutinef[0]->totalCnt) && $givenroutinef[0]->totalCnt != '' ? $givenroutinef[0]->totalCnt : '');

            $givenTT = $MHealth_camp_report->getReport($district, $ucs, $area, 'givenTT');
            $data['givenTT'] = (isset($givenTT[0]->totalCnt) && $givenTT[0]->totalCnt != '' ? $givenTT[0]->totalCnt : '');

            $zeroRIu2m = $MHealth_camp_report->getReport($district, $ucs, $area, 'zeroRIu2m');
            $data['zeroRIu2m'] = (isset($zeroRIu2m[0]->totalCnt) && $zeroRIu2m[0]->totalCnt != '' ? $zeroRIu2m[0]->totalCnt : '');

            $zeroRIu2f = $MHealth_camp_report->getReport($district, $ucs, $area, 'zeroRIu2f');
            $data['zeroRIu2f'] = (isset($zeroRIu2f[0]->totalCnt) && $zeroRIu2f[0]->totalCnt != '' ? $zeroRIu2f[0]->totalCnt : '');

            $siam = $MHealth_camp_report->getReport($district, $ucs, $area, 'siam');
            $data['siam'] = (isset($siam[0]->totalCnt) && $siam[0]->totalCnt != '' ? $siam[0]->totalCnt : '');

            $siaf = $MHealth_camp_report->getReport($district, $ucs, $area, 'siaf');
            $data['siaf'] = (isset($siaf[0]->totalCnt) && $siaf[0]->totalCnt != '' ? $siaf[0]->totalCnt : '');

            $anc = $MHealth_camp_report->getReport($district, $ucs, $area, 'anc');
            $data['anc'] = (isset($anc[0]->totalCnt) && $anc[0]->totalCnt != '' ? $anc[0]->totalCnt : '');

            $referals = $MHealth_camp_report->getReport($district, $ucs, $area, 'referals');
            $data['referals'] = (isset($referals[0]->totalCnt) && $referals[0]->totalCnt != '' ? $referals[0]->totalCnt : '');

            $ors_zincm = $MHealth_camp_report->getReport($district, $ucs, $area, 'ors_zincm');
            $data['ors_zincm'] = (isset($ors_zincm[0]->totalCnt) && $ors_zincm[0]->totalCnt != '' ? $ors_zincm[0]->totalCnt : '');

            $ors_zincf = $MHealth_camp_report->getReport($district, $ucs, $area, 'ors_zincf');
            $data['ors_zincf'] = (isset($ors_zincf[0]->totalCnt) && $ors_zincf[0]->totalCnt != '' ? $ors_zincf[0]->totalCnt : '');

            $amoxm = $MHealth_camp_report->getReport($district, $ucs, $area, 'amoxm');
            $data['amoxm'] = (isset($amoxm[0]->totalCnt) && $amoxm[0]->totalCnt != '' ? $amoxm[0]->totalCnt : '');

            $amoxf = $MHealth_camp_report->getReport($district, $ucs, $area, 'amoxf');
            $data['amoxf'] = (isset($amoxf[0]->totalCnt) && $amoxf[0]->totalCnt != '' ? $amoxf[0]->totalCnt : '');

            $refslip = $MHealth_camp_report->getReport($district, $ucs, $area, 'refslip');
            $data['refslip'] = (isset($refslip[0]->totalCnt) && $refslip[0]->totalCnt != '' ? $refslip[0]->totalCnt : '');

            $tot = $MHealth_camp_report->getReport($district, $ucs, $area, 'tot');
            $data['tot'] = (isset($tot[0]->totalCnt) && $tot[0]->totalCnt != '' ? $tot[0]->totalCnt : '');


        } else {
            $district = '0';
        }

        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_area'] = $area;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/health_camp_report', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

}

?>