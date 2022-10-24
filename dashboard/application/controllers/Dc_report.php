<?php

class Dc_report extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdc_report');
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
            if (isset($_GET['f']) && $_GET['f'] != '') {
                $from = $_GET['f'];
            } else {
                $from = date('Y-m-d');
            }
            if (isset($_GET['t']) && $_GET['t'] != '') {
                $to = $_GET['t'];
            } else {
                $to = date('Y-m-d');
            }
            if (isset($_GET['s']) && $_GET['s'] != '') {
                $typ = $_GET['s'];
            } else {
                $typ = '';
            }

            $data['from'] = $from;
            $data['to'] = $to;
            $data['typ'] = $typ;

            $MSurveyReport = new MDc_report();
            $data['myData'] = $MSurveyReport->getData($from, $to, $typ);
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('dc_report', $data);
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
            "activityName" => "Dc_report",
            "action" => "View Dc_report -> Function: Dc_report/index()",
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