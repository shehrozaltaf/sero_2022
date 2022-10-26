<?php

class Sample_Information extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msample_information');
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
            $province_slug = (isset($_GET['p']) && $_GET['p'] != '' && $_GET['p'] != '0' ? $_GET['p'] : '');

            $MSample_Information = new MSample_Information();
            $province = $MSample_Information->getProv_district('','','');
            $pro_array=array();
            foreach ($province  as $pro){
                $pro_array[$pro->province]=$pro->province;
            }
            $data['province'] = $pro_array;

            $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
            $cluster= (isset($_GET['c']) && $_GET['c'] != '' && $_GET['c'] != '0' ? $_GET['c'] : '');

            $data['slug_province'] = $province_slug;
            $data['slug_district'] = $district;
            $data['slug_cluster'] = $cluster;

            if(isset($province_slug) && $province_slug!=''){
                $data['getData']=$MSample_Information->getProv_district($province_slug,$district,$cluster);
            }

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('sample_information', $data);
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
            "activityName" => "Sample_Information",
            "action" => "View Sample_Information -> Function: Sample_Information/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function addSample($slug)
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'sample_information');
        if (isset($data['permission'][0]->CanView) && $data['permission'][0]->CanView == 1) {
            $province_slug = (isset($_GET['p']) && $_GET['p'] != '' && $_GET['p'] != '0' ? $_GET['p'] : '');

            $MSample_Information = new MSample_Information();
            $province = $MSample_Information->getProv_district('','','');
            $pro_array=array();
            foreach ($province  as $pro){
                $pro_array[$pro->province]=$pro->province;
            }
            $data['province'] = $pro_array;

            $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
            $cluster= (isset($_GET['c']) && $_GET['c'] != '' && $_GET['c'] != '0' ? $_GET['c'] : '');

            $data['slug_province'] = $province_slug;
            $data['slug_district'] = $district;
            $data['slug_cluster'] = $cluster;

            if(isset($province_slug) && $province_slug!=''){
                $data['getData']=$MSample_Information->getProv_district($province_slug,$district,$cluster);
            }

            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('sample_information_add', $data);
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
            "activityName" => "Sample_Information Add",
            "action" => "View Sample_Information Add -> Function: Sample_Information/addSample()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function getDistrictByProvince()
    {
        $MSample_Information = new MSample_Information();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $data = $MSample_Information->getProv_district($province,'','');
        $res=array();
        foreach ($data  as $dist){
            $res[$dist->dist_id]=$dist->district;
        }
        echo json_encode($res, true);
    }

    function getClusterByDistrict()
    {
        $MSample_Information = new MSample_Information();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $data = $MSample_Information->getProv_district($province,$district,'');
        $res=array();
        foreach ($data  as $dist){
            $res[$dist->ebCode]=$dist->ebCode;
        }
        echo json_encode($res, true);
    }

}

?>