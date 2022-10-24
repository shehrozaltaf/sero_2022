<?php

class Vaccine_Indicators extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mvaccine_indicators');
        $this->load->model('custom');
        $this->load->model('msettings');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $province = '';
            $district = '';

            if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
                && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
                $district = $this->encrypt->decode($_SESSION['login']['district']);
            }

            $MCustom = new Custom();
            $province = $MCustom->getProvinces($district);
            $data['province'] = $province;


            if (isset($_GET['p']) && $_GET['p'] != '') {
                $province = $_GET['p'];
                $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
            } else {
                $province = '';
            }

            $M = new MVaccine_indicators();
            $total = $M->getTotalChilds($province, $district);
            $tot = 0;
            foreach ($total as $t) {
                $tot += $t->totalChilds;
            }
            $data['total'] = $tot;


            $total_bcg = $M->getBcg($province, $district);
            $tot_bcg = 0;
            foreach ($total_bcg as $t_bcg) {
                $tot_bcg += $t_bcg->bcg;
            }
            $data['getBcg'] = $tot_bcg;


            $total_getpenta3 = $M->getpenta3($province, $district);
            $tot_getpenta3 = 0;
            foreach ($total_getpenta3 as $t_getpenta3) {
                $tot_getpenta3 += $t_getpenta3->penta3;
            }
            $data['getpenta3'] = $tot_getpenta3;


            $total_getCardAvailable = $M->getCardAvailable($province, $district);
            $tot_getCardAvailable = 0;
            foreach ($total_getCardAvailable as $t_getCardAvailable) {
                $tot_getCardAvailable += $t_getCardAvailable->cardavailable;
            }
            $data['getCardAvailable'] = $tot_getCardAvailable;


            $data['slug_province'] = $province;
            $data['slug_district'] = $district;

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('vaccine_indicators', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            $track_msg = 'errors/page-not-authorized';
            $this->load->view('errors/page-not-authorized', $data);
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Vaccine_Indicators",
            "action" => "View Vaccine_Indicators -> Function: Vaccine_Indicators/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }
}

?>