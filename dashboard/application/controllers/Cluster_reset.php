<?php

class Cluster_reset extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
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

        $district = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $district = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();
        $dist_list = $MCustom->getDistricts($district);
        $data['dist'] = $dist_list;

        $uc = '';
        $cluster = '';
        if (isset($_GET['d']) && $_GET['d'] != '') {
            $district = $_GET['d'];
            $uc = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        }
        if (isset($_GET['c']) && $_GET['c'] != '') {
            $cluster = $_GET['c'];
        }

        $data['slug_district'] = $district;
        $data['slug_uc'] = $uc;
        $data['slug_cluster'] = $cluster;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('cluster_reset', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function setReset()
    { 
        if (isset($_POST['cluster']) && $_POST['cluster'] != '') {
            $clusters = $_POST['cluster'];
            $Custom = new Custom();
            $editArr = array();
            $editArr['randomized'] = 0;
            $editData = $Custom->Edit($editArr, 'cluster_no', $clusters, 'clusters');
            if ($editData) {
                $bl_editArr = array();
                $bl_editArr['colFlag'] = '1';
                $bl_editArr['colRemarks'] = 'Dashboard By ' . $_SESSION['login']['username'];
                $bl_editData = $Custom->Edit($bl_editArr, 'hh02', $clusters, 'bl_randomised');
                if ($bl_editData) {
                    $result = 1;
                } else {
                    $result = 2;
                }
            } else {
                $result = 4;
            }
        } else {
            $result = 3;
        }
        echo $result;
    }

}

?>