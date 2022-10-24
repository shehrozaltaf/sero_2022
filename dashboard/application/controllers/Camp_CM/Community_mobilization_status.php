<?php

class Community_mobilization_status extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcamp');
        $this->load->model('mcommunity_mobilization');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array("action" => "View Community_mobilization Status", "activityName" => "Community_mobilization Status",
            "result" => "View Community_mobilization_status Main page. URL: " . current_url() . " .  Fucntion: Community_mobilization_status/index()");
        $Custom->trackLogs($trackarray, "user_logs");
        /*==========Log=============*/
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'Camp_CM/Community_mobilization_status');

        $district = '';
        $uc = '';
        $level = 1;

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

            $dist_array['Locked'][$dist_id]['camps'] = 0;
            $dist_array['Locked'][$dist_id]['ucCode'] = $v->ucCode;
            $dist_array['Locked'][$dist_id]['ucName'] = $v->ucName;
        }

        $MCommunity_mobilization = new MCommunity_mobilization();
        /*==============Community_mobilization List==============*/

        $totalCamps = $MCommunity_mobilization->totalCM($district, $uc, '1', '');
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


        $ConductedCamps = $MCommunity_mobilization->totalCM($district, $uc, '2', '');
        $Conducted = 0;
        foreach ($ConductedCamps as $k => $r) {
            $Conducted += $r->totalCamps;
            $dis = $r->ucCode;
            foreach ($dist_array['Total'] as $key => $dist_name) {
                if ($key == $dis) {
                    $dist_array['Conducted'][$dis]['camps'] += $r->totalCamps;
                    $dist_array['Remaining'][$dis]['camps'] = number_format($dist_array['Total'][$dis]['camps']) - number_format($dist_array['Conducted'][$dis]['camps']);
                }
            }
        }

        $RemainingCamps = $MCommunity_mobilization->totalCM($district, $uc, '3', '');
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

        $LockedCamps = $MCommunity_mobilization->totalCM($district, $uc, '', '1');
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

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camp_cm/community_mobilization_status', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }


}