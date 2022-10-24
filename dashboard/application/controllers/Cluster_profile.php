<?php

class Cluster_profile extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcluster_profile');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();

        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $district = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $district = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $dist_list = $MCustom->getDistricts($district);
        $data['dist'] = $dist_list;

        $uc = '';
        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $uc = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        }

        $M = new MCluster_profile();
        $myData = $M->getData($district, $uc);

        $data['slug_district'] = $district;
        $data['slug_uc'] = $uc;
        $data['myData'] = $myData;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('cluster_profile', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function editArea()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $id = $_POST['id'];
            $editArr['area'] = $_POST['area'];
            /*$editArr['updateBy'] = $_SESSION['login']['idUser'];
            $editArr['updatedDateTime'] = date('Y-m-d H:i:s');*/
            $editData = $Custom->Edit($editArr, 'id', $id, 'clusters');
            $trackarray = array("action" => "Edit Cluster Area -> Function: editArea() ",
                "result" => $editData, "PostData" => $editArr);
            $Custom->trackLogs($trackarray, "user_logs");

            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }

        } else {
            $result = 3;
        }
        echo $result;
    }


}

?>