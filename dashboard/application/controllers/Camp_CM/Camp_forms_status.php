<?php

class Camp_forms_status extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcamp');
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
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $ucs = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $trackarray = array("action" => "View Camp Form Status - index", "activityName" => "Camp Form Status - index",
            "result" => "View Camp Form Status - index page. URL: " . current_url() . " .  Fucntion: Camp_status/Camp_forms_status()");
        $MCustom->trackLogs($trackarray, "user_logs");

        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;

        $area = '';
        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
            $area = (isset($_GET['a']) && $_GET['a'] != '' && $_GET['a'] != '0' ? $_GET['a'] : '');
            $MCamp = new MCamp();
            $data['myData'] = $MCamp->camps_form_status($district, $ucs, $area);
        } else {
            $district = '';
            $data['myData'] = '';
        }

        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_area'] = $area;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/camp_forms_status', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');

    }

}