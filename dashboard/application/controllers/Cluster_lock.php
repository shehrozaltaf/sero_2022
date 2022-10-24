<?php

class Cluster_lock extends CI_controller
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
        $this->load->view('cluster_lock', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function setLock()
    {
       if (isset($_POST['clusters']) && $_POST['clusters'] != '' && count($_POST['clusters']) >=1) {
            $clusters = $_POST['clusters'];
            $Custom = new Custom();
            foreach ($clusters as $k=>$c){
                if(isset($c['cluster_no']) && $c['cluster_no']!=''){
                    $editArr = array();
                    if(isset($c['lock']) && $c['lock']==1){
                        $editArr['locked'] = 1;
                        $editArr['lockedBy'] = $_SESSION['login']['idUser'];
                        $editArr['lockedDateTime'] = date('Y-m-d H:m:s');
                    }else{
                        $editArr['locked'] = 0;
                    }
                    $editData = $Custom->Edit($editArr, 'cluster_no', $c['cluster_no'], 'clusters');
                }
            }
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