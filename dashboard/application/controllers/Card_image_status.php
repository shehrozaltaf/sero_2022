<?php error_reporting(0);

class Card_image_status extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('mimage_forms');
        $this->load->model('mcard_image_status');
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
            $Mimage_forms = new Mimage_forms();
            $province = $Mimage_forms->getProvince_District('');
            $p = array();
            foreach ($province as $k => $v) {
                $key = substr($v->dist_id, 0, 1);
                $exp = explode('|', $v->geoarea);
                $p[$key] = $exp[0];
            }
            $data['province'] = $p;

            $district = 0;
            if (isset($_GET['p']) && $_GET['p'] != '') {
                $province = $_GET['p'];
                $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
                $M = new Mcard_image_status();
                $totalClusters = $M->getDataImg($province, $district);

                /*   echo '<pre>';
                   print_r($totalClusters);
                   echo '<pre>';
                   exit();*/
                $total = 0;
                $scored = 0;
                $errored = 0;
                $edited = 0;
                $cluster = array();
                foreach ($totalClusters as $k => $v) {
                    $total += $v->totalClusters;
                    $cluster[$v->cluster_code]['totalClusters'] = $v->totalClusters;
                    $cluster[$v->cluster_code]['scoredClusters'] = 0;
                    $cluster[$v->cluster_code]['errorClusters'] = 0;
                    $cluster[$v->cluster_code]['editedClusters'] = 0;
                }
                $data['total'] = $total;

                $getDataScoredImg = $M->getDataScoredImg($province, $district);
                foreach ($getDataScoredImg as $kk => $vv) {
                    $cluster[$vv->cluster_no]['scoredClusters']++;
                    $scored++;
                }

                $getDataErroredImg = $M->getDataErroredImg($province, $district);
                foreach ($getDataErroredImg as $ek => $ev) {
                    $cluster[$ev->cluster_no]['errorClusters']++;
                    $errored++;
                }

                $getDataEditedImg = $M->getDataEditedImg($province, $district);
                foreach ($getDataEditedImg as $edk => $edv) {
                    $cluster[$edv->cluster_no]['editedClusters']++;
                    $edited++;
                }
                $data['scored'] = $scored;
                $data['errored'] = $errored;
                $data['edited'] = $edited;
                $data['getData'] = $cluster;
            }

            $data['slug_province'] = $province;
            $data['slug_district'] = $district;

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('card_img_status', $data);
            $this->load->view('include/customizer');
            $this->load->view('include/footer');
            $track_msg = 'Success';
        } else {
            echo 'Invalid Cluster';
            $track_msg = 'Invalid Cluster';
        }
        /*==========Log=============*/
        $Custom = new Custom();
        $trackarray = array(
            "activityName" => "Card Review Summary",
            "action" => "View Card_image_status -> Function: Card_image_status/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }


    function getData($province, $district)
    {

        /*  $province = 2;
          $district = (isset($_POST['district']) && $_POST['district'] != '' ? $_POST['district'] : '');
          $district = 293;*/
        $M = new Mcard_image_status();
        $totalClusters = $M->getDataImg($province, $district);

        $total = 0;
        $scored = 0;
        $data = array();
        $data['getData'] = $totalClusters;
        foreach ($totalClusters as $k => $v) {
            $total += $v->totalClusters;
            $scored += $v->scoredClusters;
        }
        $data['total'] = $total;
        $data['scored'] = $scored;

        echo json_encode($data);
    }
}

?>