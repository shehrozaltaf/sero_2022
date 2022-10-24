<?php error_reporting(0);

class Image_forms extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mimage_forms');
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
            $this->load->view('include/header');
            $this->load->view('include/top_header');
            $this->load->view('include/sidebar');
            $this->load->view('image_forms', $data);
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
            "activityName" => "Image_forms",
            "action" => "View Image_forms -> Function: Image_forms/index()",
            "result" => $track_msg,
            "PostData" => "",
            "affectedKey" => "",
            "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
            "username" => $this->encrypt->decode($_SESSION['login']['username']),
        );
        $Custom->trackLogs($trackarray, "all_logs");
        /*==========Log=============*/
    }

    function getData()
    {
        $Mimage_forms = new Mimage_forms();
        $cluster = $_POST['cluster_no'];
        $household = $_POST['household'];
        $childNo = $_POST['childNo'];
        $getData = $Mimage_forms->getDataImages($cluster, $household, $childNo);

        $checkExistData = $Mimage_forms->checkExistData($cluster, $household, $childNo);
        $data = array();
        $data['data'] = $getData;
        if (isset($checkExistData) && $checkExistData != '' && count($checkExistData) > 0) {
            $data['dataExist'] = $checkExistData;
        } else {
            $data['dataExist'] = '0';
        }

        echo json_encode($data);
    }

    function getDistrictByProvince()
    {
        $Mimage_forms = new Mimage_forms();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $data = $Mimage_forms->getProvince_District($province);
        $p = array();
        $res = array();
        foreach ($data as $k => $v) {
            $exp = explode('|', $v->geoarea);
            $p[$v->dist_id] = $exp[1];
            /* $key = substr($v->cluster_code, 0, 3);
            $exp = explode('|', $v->geoarea);
            $p[$key] = $exp[1];*/
        }
        $res[0] = $p;
        echo json_encode($res, true);
    }

    function getClustersByDist()
    {
        $Mimage_forms = new Mimage_forms();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $data = $Mimage_forms->getClusters($district);
        echo json_encode($data, true);
    }

    function getHhnoByCluster()
    {
        $Mimage_forms = new Mimage_forms();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $data = $Mimage_forms->gethhnoByClust($cluster);
        echo json_encode($data, true);
    }

    function getChildNoByHH()
    {
        $Mimage_forms = new Mimage_forms();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $hh = (isset($_REQUEST['hh']) && $_REQUEST['hh'] != '' ? $_REQUEST['hh'] : 0);
        $data = $Mimage_forms->getChildByHH($cluster, $hh);
        echo json_encode($data, true);
    }

    function submitData()
    {
        $Custom = new Custom();
        $insertArr = array();
        $insertArr['cluster_no'] = $_POST['cluster_no'];
        $insertArr['household'] = $_POST['household'];
        $flag = 0;
        if (!isset($insertArr['cluster_no']) || $insertArr['cluster_no'] == '' || $insertArr['cluster_no'] == 'undefined') {
            echo 2;
            $flag = 1;
            exit();
        }
        if (!isset($insertArr['household']) || $insertArr['household'] == '' || $insertArr['household'] == 'undefined') {
            echo 3;
            $flag = 1;
            exit();
        }
        if ($flag == 0) {
            $insertArr['image_status'] = (isset($_POST['image_status']) ? $_POST['image_status'] : '');
            $insertArr['dobstatus'] = (isset($_POST['dobstatus']) ? $_POST['dobstatus'] : '');
            $insertArr['child_ec14'] = (isset($_POST['child_ec14']) ? $_POST['child_ec14'] : '');
            $insertArr['ec13'] = (isset($_POST['ec13']) ? $_POST['ec13'] : '');
            $insertArr['f01'] = (isset($_POST['f01']) ? $_POST['f01'] : '');
            $insertArr['f02'] = (isset($_POST['f02']) ? $_POST['f02'] : '');
            $insertArr['bcg0'] = (isset($_POST['bcg0']) ? $_POST['bcg0'] : '');
            $insertArr['opv0'] = (isset($_POST['opv0']) ? $_POST['opv0'] : '');
            $insertArr['opv1'] = (isset($_POST['opv1']) ? $_POST['opv1'] : '');
            $insertArr['opv2'] = (isset($_POST['opv2']) ? $_POST['opv2'] : '');
            $insertArr['opv3'] = (isset($_POST['opv3']) ? $_POST['opv3'] : '');
            $insertArr['penta1'] = (isset($_POST['penta1']) ? $_POST['penta1'] : '');
            $insertArr['penta2'] = (isset($_POST['penta2']) ? $_POST['penta2'] : '');
            $insertArr['penta3'] = (isset($_POST['penta3']) ? $_POST['penta3'] : '');
            $insertArr['pcv1'] = (isset($_POST['pcv1']) ? $_POST['pcv1'] : '');
            $insertArr['pcv2'] = (isset($_POST['pcv2']) ? $_POST['pcv2'] : '');
            $insertArr['pcv3'] = (isset($_POST['pcv3']) ? $_POST['pcv3'] : '');
            $insertArr['rv1'] = (isset($_POST['rv1']) ? $_POST['rv1'] : '');
            $insertArr['rv2'] = (isset($_POST['rv2']) ? $_POST['rv2'] : '');
            $insertArr['ipv0'] = (isset($_POST['ipv0']) ? $_POST['ipv0'] : '');
            $insertArr['measles1'] = (isset($_POST['measles1']) ? $_POST['measles1'] : '');
            $insertArr['measles2'] = (isset($_POST['measles2']) ? $_POST['measles2'] : '');
            $insertArr['hep_b'] = (isset($_POST['hep_b']) ? $_POST['hep_b'] : '');
            $insertArr['ipv2'] = (isset($_POST['ipv2']) ? $_POST['ipv2'] : '');
            $insertArr['tcv'] = (isset($_POST['tcv']) ? $_POST['tcv'] : '');
            $insertArr['createdBy'] = $this->encrypt->decode($_SESSION['login']['username']);
            $insertArr['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($insertArr, 'id_Image_feedback', 'image_feedback', 'N');
            if ($InsertData) {
                echo 1;
                $track_msg='Successfully Inserted';
            } else {
                echo 4;
                $track_msg='Error in inserting data';
            }
            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "Image_forms",
                "action" => "Add Review Image_forms -> Function: Image_forms/submitData()",
                "result" => $track_msg,
                "PostData" => $insertArr,
                "affectedKey" => "id_Image_feedback",
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            echo 5;
        }
    }

    function editData()
    {
        $Custom = new Custom();
        $insertArr = array();

        $flag = 0;
        if (!isset($_POST['id']) || $_POST['id'] == '' || $_POST['id'] == 'undefined') {
            echo 7;
            $flag = 1;
            $id = 0;
            exit();
        } else {
            $id = $_POST['id'];
        }
        if ($flag == 0) {
            $insertArr['image_status'] = (isset($_POST['image_status']) ? $_POST['image_status'] : '');
            $insertArr['dobstatus'] = (isset($_POST['dobstatus']) ? $_POST['dobstatus'] : '');
            $insertArr['ec13'] = (isset($_POST['ec13']) ? $_POST['ec13'] : '');
            $insertArr['f01'] = (isset($_POST['f01']) ? $_POST['f01'] : '');
            $insertArr['f02'] = (isset($_POST['f02']) ? $_POST['f02'] : '');
            $insertArr['bcg0'] = (isset($_POST['bcg0']) ? $_POST['bcg0'] : '');
            $insertArr['opv0'] = (isset($_POST['opv0']) ? $_POST['opv0'] : '');
            $insertArr['opv1'] = (isset($_POST['opv1']) ? $_POST['opv1'] : '');
            $insertArr['opv2'] = (isset($_POST['opv2']) ? $_POST['opv2'] : '');
            $insertArr['opv3'] = (isset($_POST['opv3']) ? $_POST['opv3'] : '');
            $insertArr['penta1'] = (isset($_POST['penta1']) ? $_POST['penta1'] : '');
            $insertArr['penta2'] = (isset($_POST['penta2']) ? $_POST['penta2'] : '');
            $insertArr['penta3'] = (isset($_POST['penta3']) ? $_POST['penta3'] : '');
            $insertArr['pcv1'] = (isset($_POST['pcv1']) ? $_POST['pcv1'] : '');
            $insertArr['pcv2'] = (isset($_POST['pcv2']) ? $_POST['pcv2'] : '');
            $insertArr['pcv3'] = (isset($_POST['pcv3']) ? $_POST['pcv3'] : '');
            $insertArr['rv1'] = (isset($_POST['rv1']) ? $_POST['rv1'] : '');
            $insertArr['rv2'] = (isset($_POST['rv2']) ? $_POST['rv2'] : '');
            $insertArr['ipv0'] = (isset($_POST['ipv0']) ? $_POST['ipv0'] : '');
            $insertArr['measles1'] = (isset($_POST['measles1']) ? $_POST['measles1'] : '');
            $insertArr['measles2'] = (isset($_POST['measles2']) ? $_POST['measles2'] : '');
            $insertArr['hep_b'] = (isset($_POST['hep_b']) ? $_POST['hep_b'] : '');
            $insertArr['ipv2'] = (isset($_POST['ipv2']) ? $_POST['ipv2'] : '');
            $insertArr['tcv'] = (isset($_POST['tcv']) ? $_POST['tcv'] : '');
            $insertArr['updatedBy'] = $this->encrypt->decode($_SESSION['login']['username']);
            $insertArr['updatedDatetime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Edit($insertArr, 'id_Image_feedback', $id, 'image_feedback');
            if ($InsertData) {
                echo 1;
                $track_msg='Successfully Inserted';
            } else {
                echo 4;
                $track_msg='Error in inserting data';
            }
            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "Image_forms",
                "action" => "Edit Review Image_forms -> Function: Image_forms/editData()",
                "result" => $track_msg,
                "PostData" => $insertArr,
                "affectedKey" => "id_Image_feedback",
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        } else {
            echo 5;
        }
    }

}

?>